<?php

namespace App\Repositories;

use App\Interfaces\WorkspaceInterface;
use App\Mail\InvitationMail;
use App\Models\Workspace;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Waad\Repository\Enums\ResponseStatus;
use Waad\Repository\Repositories\BaseRepository;

class WorkspaceRepository extends BaseRepository implements WorkspaceInterface
{
    public function __construct()
    {
        $this->model = new Workspace();
    }


    /**
     * index
     *
     * @param Request $request
     * @param string|null $trash
     * @param bool|null $QueryBilderEnable
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Pagination\LengthAwarePaginator
     */
    public function index(Request $request, string|null $trash = null, bool|null $QueryBilderEnable = true)
    {
        $where = array();

        return $this->indexObject($request, $where, $trash, $QueryBilderEnable)->paginate($request->take);
    }


    /**
     * show
     *
     * @param Model|int|string $object
     * @param bool|null $trash
     * @param bool|null $enableQueryBuilder
     * @return Model|null
     */
    public function show(Model|int|string $object, bool|null $trash = false, bool|null $enableQueryBuilder = true)
    {
        return $this->showObject($object, $trash, $enableQueryBuilder);
    }


    /**
     * store
     *
     * @param array $data
     * @param bool|null $is_object
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(array $data, bool|null $is_object = true)
    {
        $response = $this->storeObject($data, $is_object);

        $response->users()->attach($response->user_id);

        return $this->jsonResponce(
            message: 'The Workspace data has been Created successfully',
            data: $is_object ? $response : ['id' => $response],
            status: ResponseStatus::CREATED->value
        );
    }


    /**
     * update
     *
     * @param array $values
     * @param Model|int|string $object
     * @param bool|null $getObject
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(array $values, Model|int|string $object, bool|null $getObject = false)
    {
        $response = $this->updateObject($values, $object, $getObject);

        return $this->jsonResponce(
            message: 'The Workspace data has been Updated successfully',
            data: $getObject ? $response : null,
            status: $getObject ? ResponseStatus::SUCCESS->value : ResponseStatus::NO_CONTENT->value,
        );
    }

    /**
     * destroy
     *
     * @param Model|int|string $object
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Model|int|string $object)
    {
        $response = $this->destroyObject($object);

        return $this->jsonResponce(
            message: $response ? 'The Workspace data has been destroied successfully' : "Not Found",
            data: $response ? $response : null,
            status: $response ? ResponseStatus::NO_CONTENT->value : ResponseStatus::NOT_FOUND->value,
        );
    }

    /**
     * delete
     *
     * @param Model|int|string $object
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Model|int|string $object)
    {
        $response = $this->deleteObject($object);

        return $this->jsonResponce(
            message: $response ? 'The Workspace data has been force deleted successfully' : "Not Found",
            data: $response ? $response : null,
            status: $response ? ResponseStatus::NO_CONTENT->value : ResponseStatus::NOT_FOUND->value,
        );
    }

    /**
     * restore
     *
     * @param Model|int|string $object
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore(Model|int|string $object)
    {
        $response = $this->restoreObject($object);

        return $this->jsonResponce(
            message: $response ? 'The Workspace data has been restored successfully' : "Not Found",
            data: $response ? $response : null,
            status: $response ? ResponseStatus::NO_CONTENT->value : ResponseStatus::NOT_FOUND->value,
        );
    }

    /**
     * My Workspaces
     *
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function myWorkspaces(Request $request)
    {
        return $this->indexObject($request)
            ->where(
                fn ($query) => $query->whereHas('users', fn ($users) => $users->where('id', auth('user')->id()))
                    ->orWhere('user_id', auth('user')->id())
            )
            ->get();
    }

    /**
     * Store Invitations of workspace
     *
     * @param \App\Http\Requests\Workspace\InviteStoreUsersWorkspaceRequest $request
     * @param Workspace $workspace
     * @return Workspace
     */
    public function storeInvitations($request, $workspace)
    {
        // if not exists
        error_if(!$request->filled('emails'), 404, "`emails` Not Founds");

        // send invitations to emails
        foreach ($request->emails as $email) {

            // if not exists
            if (!$workspace->users()->where('email', $email)->exists()) {

                // create invitation for email and workspace
                $created = $workspace->invitations()->create([
                    'email' => $email,
                    'workspace_id' => $workspace->getAttribute('id'),
                    'expires_at' => now()->addDays(7),
                ]);

                // send invitation mail
                if ($created) {
                    Mail::to($email)->send(new InvitationMail($workspace->getAttribute('id'), $created->id, $created->expires_at));
                }
            }
        }

        return $workspace->load('invitations');
    }

    /**
     * Get Invitation
     *
     * @param \App\Models\Workspace $workspace
     * @param \App\Models\InviteWorkspace $inviteWorkspace
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInvitation($workspace, $inviteWorkspace)
    {
        // if not exists
        error_if($inviteWorkspace->workspace_id != $workspace->getAttribute('id'), 404, "Invitation Not Found");

        // if accepted
        error_if($inviteWorkspace->expires_at < now(), 404, "Invitation Expired");

        return response()->json([
            'is_joinned' => $workspace->users()->where('email', $inviteWorkspace->email)->exists(),
            'invitation_id' => $inviteWorkspace->id,
            'workspace_id' => $inviteWorkspace->workspace_id,
            'accepted' => $inviteWorkspace->accepted,
        ]);
    }

    /**
     * Accept Invitation
     *
     * @param \App\Models\Workspace $workspace
     * @param \App\Models\InviteWorkspace $inviteWorkspace
     * @return \Illuminate\Http\JsonResponse
     */
    public function acceptInvitation($workspace, $inviteWorkspace)
    {
        // if not exists
        error_if($inviteWorkspace->workspace_id != $workspace->getAttribute('id'), 404, "Invitation Not Found");

        // if accepted
        error_if($inviteWorkspace->accepted, 404, "Invitation Already Accepted");

        // if user already joinned
        error_if($workspace->users()->where('email', $inviteWorkspace->email)->exists(), 404, "User Already Joined");

        // if expired
        error_if($inviteWorkspace->expires_at < now(), 404, "Invitation Expired");

        // accept invitation
        $inviteWorkspace->accepted = true;
        $inviteWorkspace->save();

        // if user not registered
        $user = \App\Models\User::where('email', $inviteWorkspace->email)->first();
        $isRegistered = false;
        if (!$user) {
            $registerRepository = new AuthUserRepository();
            $createToken = $registerRepository->register(
                data: [
                    'name' => str($inviteWorkspace->email)->before('@')->value() ?? $inviteWorkspace->email,
                    'email' => $inviteWorkspace->email,
                    'password' => str()->random(16),
                ],
                isArray: true
            );
            $isRegistered = true;
            $user = $createToken['user'];
        }

        // attach user to workspace
        $workspace->users()->attach($user);

        return response()->json(
            $isRegistered ?
                array_merge($createToken, ['workspace_id' => $workspace->getAttribute('id')]) :
                ['user' => $user, 'workspace_id' => $workspace->getAttribute('id')],
            $isRegistered ?
                201 :
                200
        );
    }
}
