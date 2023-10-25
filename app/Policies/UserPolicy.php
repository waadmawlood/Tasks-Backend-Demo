<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User|Admin $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User|Admin $user)
    {
        return $user->hasAnyRolePermissions(['user_list'], ['user', 'admin']);
        // return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User|Admin $user
     * @param  \App\Models\User  $userModel
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User|Admin $user, User $userModel)
    {
        return $user->hasAnyRolePermissions(['user_list'], ['user', 'admin']);
        // return user->user_id == $user->id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User|Admin $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User|Admin $user)
    {
        return $user->hasAnyRolePermissions(['user_create'], ['user', 'admin']);
        // return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User|Admin $user
     * @param  \App\Models\User  $userModel
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User|Admin $user, User $userModel)
    {
        return $user->hasAnyRolePermissions(['user_update'], ['user', 'admin']);
        // return user->user_id == $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User|Admin $user
     * @param  \App\Models\User  $userModel
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User|Admin $user, User $userModel)
    {
        return $user->hasAnyRolePermissions(['user_delete'], ['user', 'admin']);
        // return user->user_id == $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User|Admin $user
     * @param  \App\Models\User  $userModel
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User|Admin $user, User $userModel)
    {
        return $user->hasAnyRolePermissions(['user_restore'], ['user', 'admin']);
        // return user->user_id == $user->id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User|Admin $user
     * @param  \App\Models\User  $userModel
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User|Admin $user, User $userModel)
    {
        return $user->hasAnyRolePermissions(['user_forcedelete'], ['user', 'admin']);
    }
}
