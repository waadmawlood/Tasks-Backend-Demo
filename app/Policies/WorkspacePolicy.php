<?php

namespace App\Policies;

use App\Helpers\Utilities;
use App\Models\Workspace;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class WorkspacePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->hasAnyRolePermissions(['workspace_list'], ['user']);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Workspace  $workspace
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Workspace $workspace)
    {
        return $user->hasAnyRolePermissions(['workspace_show'], ['user']);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->hasAnyRolePermissions(['workspace_create'], ['user']);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Workspace  $workspace
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Workspace $workspace)
    {
        return $user->hasAnyRolePermissions(['workspace_update'], ['user']);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Workspace  $workspace
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Workspace $workspace)
    {
        return $user->hasAnyRolePermissions(['workspace_delete'], ['user']);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Workspace  $workspace
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Workspace $workspace)
    {
        return $user->hasAnyRolePermissions(['workspace_restore'], ['user']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Workspace  $workspace
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Workspace $workspace)
    {
        return $user->hasAnyRolePermissions(['workspace_forcedelete'], ['user']);
    }

    /**
     * Check if a user is authorized to assign permissions within a workspace.
     *
     * @param User $user
     * @param Workspace $workspace
     * @return bool
     */
    public function assignUsersWorkspace(User $user, Workspace $workspace)
    {
        setPermissionsTeamId($workspace->id);
        return $user->hasAnyRolePermissions(['workspace_assign_users'], ['user']) || $workspace->user_id === $user->id;
    }

    public function inviteStoreUsersWorkspace(User $user, Workspace $workspace)
    {
        setPermissionsTeamId($workspace->id);
        return $user->hasAnyRolePermissions(['workspace_invite_users'], ['user']) || $workspace->user_id === $user->id;
    }

    public function listPermissionsUser(User $user)
    {
        $workspace = Utilities::isUserOwnerWorkspace($user, getPermissionsTeamId());

        return $user->hasAnyRolePermissions(['permission_list'], ['user']) || $workspace;
    }
}
