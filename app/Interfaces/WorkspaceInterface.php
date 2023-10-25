<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Waad\Repository\Interfaces\BaseInterface;


interface WorkspaceInterface extends BaseInterface
{

    /**
     * index
     *
     * @param Request $request
     * @param string|null $trash
     * @param bool|null $QueryBilderEnable
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Pagination\LengthAwarePaginator
     */
    public function index(Request $request, string|null $trash = null, bool|null $QueryBilderEnable = true);


    /**
     * show
     *
     * @param Model|int|string $object
     * @param bool|null $trash
     * @param bool|null $enableQueryBuilder
     * @return Model|null
     */
    public function show(Model|int|string $object, bool|null $trash = false, bool|null $enableQueryBuilder = true);

    /**
     * store
     *
     * @param array $data
     * @param bool|null $is_object
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(array $data, bool|null $is_object = true);


    /**
     * update
     *
     * @param array $values
     * @param Model|int|string $object
     * @param bool|null $getObject
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(array $values, Model|int|string $object, bool|null $getObject = false);
    /**
     * destroy
     *
     * @param Model|int|string $object
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Model|int|string $object);

    /**
     * delete
     *
     * @param Model|int|string $object
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Model|int|string $object);

    /**
     * restore
     *
     * @param Model|int|string $object
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore(Model|int|string $object);

    /**
     * My Workspaces
     *
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function myWorkspaces(Request $request);

    /**
     * Store Invitations of workspace
     *
     * @param \App\Http\Requests\Workspace\InviteStoreUsersWorkspaceRequest $request
     * @param \App\Models\Workspace $workspace
     * @return \App\Models\Workspace
     */
    public function storeInvitations($request, $workspace);

    /**
     * Get Invitation
     *
     * @param \App\Models\Workspace $workspace
     * @param \App\Models\InviteWorkspace $inviteWorkspace
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInvitation($workspace, $inviteWorkspace);

    /**
     * Accept Invitation
     *
     * @param \App\Models\Workspace $workspace
     * @param \App\Models\InviteWorkspace $inviteWorkspace
     * @return \Illuminate\Http\JsonResponse
     */
    public function acceptInvitation($workspace, $inviteWorkspace);
}
