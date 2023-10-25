<?php

namespace App\Interfaces;

use Waad\Repository\Interfaces\BaseInterface;
use Illuminate\Http\Request;

interface PermissionInterface extends BaseInterface
{
    /**
     * index
     *
     * @param Request $request
     * @param string|null $trash
     * @param bool|null $QueryBilderEnable
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index(Request $request, string|null $trash = null, bool|null $QueryBilderEnable = true);

    /**
     * Sync Permissions User
     *
     * @param \App\Http\Requests\Permission\ListPermissionsUserRequest $request
     * @param \App\models\User $user
     * @return mixed
     */
    public function syncPermissionsUser($request, $user);
}
