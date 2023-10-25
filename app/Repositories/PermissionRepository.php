<?php

namespace App\Repositories;

use App\Helpers\Guard;
use App\Http\Requests\Pagination;
use App\Http\Requests\Unlimit;
use App\Interfaces\PermissionInterface;
use App\Models\Permission;
use Illuminate\Http\Request;
use Waad\Repository\Repositories\BaseRepository;

class PermissionRepository extends BaseRepository implements PermissionInterface
{
    public function __construct()
    {
        $this->model = new Permission();
    }


    /**
     * index
     *
     * @param Request|Pagination|Unlimit $request
     * @param string|null $trash
     * @param bool|null $QueryBilderEnable
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index(Request|Pagination|Unlimit $request, string|null $trash = null, bool|null $QueryBilderEnable = true)
    {
        $where = array();

        $guard = Guard::guardMe();
        $permissions = $this->indexObject($request, $where, $trash, $QueryBilderEnable)->where('guard_name', $guard);

        return $permissions->get()->groupBy('group');
    }

    /**
     * Sync Permissions User
     *
     * @param \App\Http\Requests\Permission\ListPermissionsUserRequest $request
     * @param \App\models\User $user
     * @return mixed
     */
    public function syncPermissionsUser($request, $user)
    {
        return $user->syncPermissions($request->permissions);
    }
}
