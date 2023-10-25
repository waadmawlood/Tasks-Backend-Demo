<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AssignRoleAdminRequest;
use App\Http\Requests\Admin\StoreAdminRequest;
use App\Http\Requests\Admin\UpdateAdminRequest;
use App\Http\Requests\Pagination;
use App\Http\Requests\Unlimit;
use App\Interfaces\AdminInterface;
use App\Models\Admin;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Spatie\QueryBuilder\QueryBuilder as SpatieQueryBuilder;
use Spatie\QueryBuilder\Concerns\SortsQuery;

class AdminController extends Controller
{
    /**
     * AdminRepository
     * @var AdminInterface
     */
    private $AdminRepository;

    /**
     * AdminController::__construct
     *
     * @param AdminInterface $adminRepository
     */
    public function __construct(AdminInterface $adminRepository)
    {
        $this->authorizeResource(Admin::class, 'admin');
        $this->AdminRepository = $adminRepository;
    }

    /**
     * Get List
     *
     * @param Pagination|Unlimit $pagination use `Pagination Or Unlimit`
     * @return EloquentBuilder|QueryBuilder|SpatieQueryBuilder|SortsQuery|mixed
     */
    public function index(Pagination $pagination)
    {
        return $this->AdminRepository->index($pagination);
    }

    /**
     * Store
     *
     * @param  \App\Http\Requests\Admin\StoreAdminRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreAdminRequest $request)
    {
        return $this->AdminRepository->store($request->validated());
    }

    /**
     * Show
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Support\Collection|array|null
     */
    public function show(Admin $admin)
    {
        return $this->AdminRepository->show($admin);
    }

    /**
     * Update
     *
     * @param  \App\Http\Requests\Admin\UpdateAdminRequest  $request
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateAdminRequest $request, Admin $admin)
    {
        return $this->AdminRepository->update($request->validated(), $admin);
    }

    /**
     * Soft Delete
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Admin $admin)
    {
        return $this->AdminRepository->destroy($admin);
    }

    /**
     * Force Delete
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Admin $admin)
    {
        return $this->AdminRepository->delete($admin);
    }

    /**
     * Restore
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore(Admin $admin)
    {
        return $this->AdminRepository->restore($admin);
    }

    /**
     * Assign Roles Admin
     *
     * @param AssignRoleAdminRequest $request
     * @param Admin $admin
     * @return Admin
     */
    public function assignRoleAdmin(AssignRoleAdminRequest $request, Admin $admin)
    {
        return $this->AdminRepository->assignRoleAdmin($request, $admin);
    }
}
