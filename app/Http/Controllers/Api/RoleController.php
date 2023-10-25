<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pagination;
use App\Http\Requests\Role\AssignPermissionRoleRequest;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Interfaces\RoleInterface;
use App\Models\Role;

class RoleController extends Controller
{
    /**
     * RoleRepository
     * @var RoleInterface
     */
    private $RoleRepository;

    /**
     * RoleController::__construct
     *
     * @param RoleInterface $roleRepository
     */
    public function __construct(RoleInterface $roleRepository)
    {
        $this->authorizeResource(Role::class, 'role');
        $this->RoleRepository = $roleRepository;
    }

    /**
     * Get List
     *
     * @param Pagination $pagination
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function index(Pagination $pagination)
    {
        return $this->RoleRepository->index($pagination);
    }

    /**
     * Store
     *
     * @param  \App\Http\Requests\Role\StoreRoleRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRoleRequest $request)
    {
        return $this->RoleRepository->store($request->validated());
    }

    /**
     * Show
     *
     * @param  \App\Models\Role  $role
     * @return Role|null
     */
    public function show(Role $role)
    {
        return $this->RoleRepository->show($role);
    }

    /**
     * Update
     *
     * @param  \App\Http\Requests\Role\UpdateRoleRequest  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        return $this->RoleRepository->update($request->validated(), $role);
    }

    /**
     * Delete
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Role $role)
    {
        return $this->RoleRepository->destroy($role);
    }

    /**
     * Assign Permissions
     *
     * @param AssignPermissionRoleRequest $request
     * @param Role $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function assignPermissions(AssignPermissionRoleRequest  $request, Role $role)
    {
        return $this->RoleRepository->assignPermissions($request, $role);
    }
}
