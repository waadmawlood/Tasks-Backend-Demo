<?php

namespace App\Policies;

use App\Helpers\Utilities;
use App\Models\Status;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StatusPolicy
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
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Status  $status
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Status $status)
    {
        return $status->workspace_id === getPermissionsTeamId() || $status->user_id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return Utilities::isUserOwnerWorkspace($user, getPermissionsTeamId());
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Status  $status
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Status $status)
    {
        return Utilities::isUserOwnerWorkspace($user, getPermissionsTeamId()) &&
            $status->workspace_id === getPermissionsTeamId();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Status  $status
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Status $status)
    {
        return Utilities::isUserOwnerWorkspace($user, getPermissionsTeamId()) &&
            $status->workspace_id === getPermissionsTeamId();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Status  $status
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Status $status)
    {
        return Utilities::isUserOwnerWorkspace($user, getPermissionsTeamId()) &&
            $status->workspace_id === getPermissionsTeamId();
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Status  $status
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Status $status)
    {
        return Utilities::isUserOwnerWorkspace($user, getPermissionsTeamId()) &&
            $status->workspace_id === getPermissionsTeamId();
    }
}
