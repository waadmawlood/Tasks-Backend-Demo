<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Permission\ListPermissionsUserRequest;
use App\Http\Requests\Unlimit;
use App\Interfaces\PermissionInterface;
use App\Models\Permission;
use App\Models\User;
use App\Models\Workspace;

class PermissionController extends Controller
{
    /**
     * PermissionRepository
     * @var PermissionInterface
     */
    private $PermissionRepository;

    /**
     * PermissionController::__construct
     *
     * @param PermissionInterface $permissionRepository
     */
    public function __construct(PermissionInterface $permissionRepository)
    {
        $this->authorizeResource(Permission::class, 'permission');
        $this->PermissionRepository = $permissionRepository;
    }

    /**
     * Get List
     *
     * @param Unlimit $request
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index(Unlimit $request)
    {
        return $this->PermissionRepository->index($request);
    }

    /**
     * Sync Permissions User
     *
     * @param \App\Http\Requests\Permission\ListPermissionsUserRequest $request
     * @param \App\models\User $user
     * @return mixed
     */
    public function syncPermissionsUser(ListPermissionsUserRequest $request, Workspace $workspace, User $user)
    {
        return $this->PermissionRepository->syncPermissionsUser($request, $user);
    }

    /**
     * List Permissions User
     *
     * @param Workspace $workspace
     * @param User $user
     * @return mixed
     */
    public function listPermissionsUser(Workspace $workspace, User $user)
    {
        $this->authorize('listPermissionsUser', $workspace);
        return $user->permissions->groupBy('group');
    }

    /**
     * My Permissions
     *
     * @return mixed
     */
    public function myPermissionsUser()
    {
        return auth()->user()->permissions->groupBy('group');
    }
}
