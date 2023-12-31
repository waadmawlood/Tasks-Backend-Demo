<?php

namespace App\Repositories;

use App\Http\Requests\Admin\AssignRoleAdminRequest;
use App\Http\Requests\Pagination;
use App\Http\Requests\Unlimit;
use App\Interfaces\AdminInterface;
use App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Spatie\QueryBuilder\QueryBuilder as SpatieQueryBuilder;
use Spatie\QueryBuilder\Concerns\SortsQuery;
use Waad\Repository\Repositories\BaseRepository;
use Waad\Repository\Enums\ResponseStatus;

class AdminRepository extends BaseRepository implements AdminInterface
{
    protected $model;

    public function __construct()
    {
        $this->model = new Admin();
    }


    /**
     * index
     *
     * @param Request|Pagination|Unlimit $request
     * @param string|null $trash
     * @param bool|null $QueryBilderEnable
     * @return EloquentBuilder|QueryBuilder|SpatieQueryBuilder|SortsQuery|mixed
     */
    public function index(Request|Pagination|Unlimit $request, string|null $trash = null, bool|null $QueryBilderEnable = true)
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
     * @return Collection|array|null
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

        return $this->jsonResponce(
            message: 'The Admin data has been Created successfully',
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
            message: 'The Admin data has been Updated successfully',
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
            message: $response ? 'The Admin data has been destroied successfully' : "Not Found",
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
            message: $response ? 'The Admin data has been force deleted successfully' : "Not Found",
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
            message: $response ? 'The Admin data has been restored successfully' : "Not Found",
            data: $response ? $response : null,
            status: $response ? ResponseStatus::NO_CONTENT->value : ResponseStatus::NOT_FOUND->value,
        );
    }

    /**
     * Assign Roles to Admin
     *
     * @param AssignRoleAdminRequest $request
     * @param Admin $admin
     * @return Admin
     */
    public function assignRoleAdmin(AssignRoleAdminRequest $request, Admin $admin)
    {
        return $admin->syncRoles($request->roles);
    }
}
