<?php

namespace App\Repositories;

use App\Interfaces\RoleInterface;
use App\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Waad\Repository\Enums\ResponseStatus;
use Waad\Repository\Repositories\BaseRepository;

class RoleRepository extends BaseRepository implements RoleInterface
{
    public function __construct()
    {
        $this->model = new Role();
    }


    /**
     * index
     *
     * @param Request $request
     * @param string|null $trash
     * @param bool|null $QueryBilderEnable
     * @return \Illuminate\Pagination\LengthAwarePaginator
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
     * @return Role|null
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
            message: 'The Role data has been Created successfully',
            data : $is_object ? $response : ['id' => $response],
            status : ResponseStatus::CREATED->value
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
            message: 'The Role data has been Updated successfully',
            data : $getObject ? $response : null,
            status : $getObject ? ResponseStatus::SUCCESS->value : ResponseStatus::NO_CONTENT->value,
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
            message: $response ? 'The Role data has been destroied successfully' : "Not Found",
            data : $response ? $response : null,
            status : $response ? ResponseStatus::NO_CONTENT->value : ResponseStatus::NOT_FOUND->value,
        );
    }

    /**
     * Assign Permissions
     *
     * @param \App\Http\Requests\Role\AssignPermissionRoleRequest $request
     * @param Role $role
     * @return \App\Models\Role
     */
    public function assignPermissions($request, $role)
    {
        return $role->syncPermissions($request->permissions);
    }
}
