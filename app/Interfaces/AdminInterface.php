<?php

namespace App\Interfaces;

use App\Http\Requests\Admin\AssignRoleAdminRequest;
use App\Models\Admin;
use Waad\Repository\Interfaces\BaseInterface;
use App\Http\Requests\Pagination;
use App\Http\Requests\Unlimit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Spatie\QueryBuilder\QueryBuilder as SpatieQueryBuilder;
use Spatie\QueryBuilder\Concerns\SortsQuery;

interface AdminInterface extends BaseInterface
{

    /**
     * index
     *
     * @param Request|Pagination|Unlimit $request
     * @param string|null $trash
     * @param bool|null $QueryBilderEnable
     * @return EloquentBuilder|QueryBuilder|SpatieQueryBuilder|SortsQuery|mixed
     */
    public function index(Request|Pagination|Unlimit $request, string|null $trash = null, bool|null $QueryBilderEnable = true);

    /**
     * show
     *
     * @param Model|int|string $object
     * @param bool|null $trash
     * @param bool|null $enableQueryBuilder
     * @return Collection|array|null
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
     * Assign Roles Admin
     *
     * @param AssignRoleAdminRequest $request
     * @param Admin $admin
     * @return Admin
     */
    public function assignRoleAdmin(AssignRoleAdminRequest $request, Admin $admin);
}
