<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Guard;
use App\Http\Controllers\Controller;
use App\Http\Requests\Pagination;
use App\Http\Requests\Unlimit;
use App\Http\Requests\Workspace\AssignUsersWorkspaceRequest;
use App\Http\Requests\Workspace\InviteStoreUsersWorkspaceRequest;
use App\Http\Requests\Workspace\StoreWorkspaceRequest;
use App\Http\Requests\Workspace\UpdateWorkspaceRequest;
use App\Interfaces\WorkspaceInterface;
use App\Models\InviteWorkspace;
use App\Models\Workspace;

class WorkspaceController extends Controller
{
    /**
     * WorkspaceRepository
     * @var WorkspaceInterface
     */
    private $WorkspaceRepository;

    /**
     * WorkspaceController::__construct
     *
     * @param WorkspaceInterface $workspaceRepository
     */
    public function __construct(WorkspaceInterface $workspaceRepository)
    {
        $this->WorkspaceRepository = $workspaceRepository;
    }

    /**
     * Get List
     *
     * @param Pagination $pagination
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Pagination\LengthAwarePaginator
     */
    public function index(Pagination $pagination)
    {
        return $this->WorkspaceRepository->index($pagination);
    }

    /**
     * Store
     *
     * @param  \App\Http\Requests\Workspace\StoreWorkspaceRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreWorkspaceRequest $request)
    {
        return $this->WorkspaceRepository->store($request->validated());
    }

    /**
     * Show
     *
     * @param  \App\Models\Workspace  $workspace
     * @return \Illuminate\Support\Collection|array|null
     */
    public function show(Workspace $workspace)
    {
        return $this->WorkspaceRepository->show($workspace);
    }

    /**
     * Update
     *
     * @param  \App\Http\Requests\Workspace\UpdateWorkspaceRequest  $request
     * @param  \App\Models\Workspace  $workspace
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateWorkspaceRequest $request, Workspace $workspace)
    {
        return $this->WorkspaceRepository->update($request->validated(), $workspace);
    }

    /**
     * Soft Delete
     *
     * @param  \App\Models\Workspace  $workspace
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Workspace $workspace)
    {
        return $this->WorkspaceRepository->destroy($workspace);
    }

    /**
     * Force Delete
     *
     * @param  \App\Models\Workspace  $workspace
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Workspace $workspace)
    {
        return $this->WorkspaceRepository->delete($workspace);
    }

    /**
     * Restore
     *
     * @param  \App\Models\Workspace  $workspace
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore(Workspace $workspace)
    {
        return $this->WorkspaceRepository->restore($workspace);
    }

    /**
     * Create new workspace
     *
     * @param StoreWorkspaceRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createNew(StoreWorkspaceRequest $request)
    {
        // Check if user has 5 workspaces
        $workspaceCount = Workspace::query()->whereUserId(Guard::authId())->count();
        error_if($workspaceCount >= 5, 403, 'You can\'t create more than 5 workspaces');

        return $this->WorkspaceRepository->store($request->validated());
    }

    /**
     * My Workspaces
     *
     * @param Unlimit $request
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function myWorkspaces(Unlimit $request)
    {
        return $this->WorkspaceRepository->myWorkspaces($request);
    }

    /**
     * Assign Users To Workspace
     *
     * @param AssignUsersWorkspaceRequest $request
     * @param Workspace $workspace
     * @return array
     */
    public function assignUsers(AssignUsersWorkspaceRequest  $request, Workspace $workspace)
    {
        $this->authorize('assignUsersWorkspace', $workspace);
        return $workspace->users()->sync($request->users);
    }

    /**
     * Invite User
     *
     * @param InviteStoreUsersWorkspaceRequest $request
     * @param Workspace $workspace
     * @return Workspace
     */
    public function storeInvitations(InviteStoreUsersWorkspaceRequest $request, Workspace $workspace)
    {
        $this->authorize('inviteStoreUsersWorkspace', $workspace);
        return $this->WorkspaceRepository->storeInvitations($request, $workspace);
    }

    /**
     * Get Invitation
     *
     * @param Workspace $workspace
     * @param InviteWorkspace $inviteWorkspace
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInvitation(Workspace $workspace, InviteWorkspace $inviteWorkspace)
    {
        return $this->WorkspaceRepository->getInvitation($workspace, $inviteWorkspace);
    }

    /**
     * Accept Invitation
     *
     * @param \App\Models\Workspace $workspace
     * @param \App\Models\InviteWorkspace $inviteWorkspace
     * @return \Illuminate\Http\JsonResponse
     */
    public function acceptInvitation(Workspace $workspace, InviteWorkspace $inviteWorkspace)
    {
        return $this->WorkspaceRepository->acceptInvitation($workspace, $inviteWorkspace);
    }
}
