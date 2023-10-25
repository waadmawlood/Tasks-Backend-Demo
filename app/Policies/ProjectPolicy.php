<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
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
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Project $project)
    {
        if (blank(getPermissionsTeamId()))
            return false;

        return getPermissionsTeamId() === $project->workspace_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->hasAnyRolePermissions(['project_create'], ['user']);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Project $project)
    {
        return $user->hasAnyRolePermissions(['project_update'], ['user']) || $user->id === $project->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Project $project)
    {
        return $user->hasAnyRolePermissions(['project_delete'], ['user']);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Project $project)
    {
        return $user->hasAnyRolePermissions(['project_restore'], ['user']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Project $project)
    {
        return $user->hasAnyRolePermissions(['project_forcedelete'], ['user']);
    }

    /**
     * Toggle Active
     *
     * @param User $user
     * @param Project $project
     * @return bool
     */
    public function toggleActive(User $user, Project $project)
    {
        if ($project->workspace()->where('user_id', $user->id)->exists())
            return true;

        return $user->id === $project->user_id;
    }

    /**
     * Make Archive
     *
     * @param User $user
     * @param Project $project
     * @return bool
     */
    public function makeArchive(User $user, Project $project)
    {
        if ($project->workspace()->where('user_id', $user->id)->exists())
            return true;

        return $user->id === $project->user_id && $project->is_archive === false;
    }
}
