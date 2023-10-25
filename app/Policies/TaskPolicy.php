<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\Media;
use App\Models\Status;
use App\Models\Task;
use App\Models\TaskUser;
use App\Models\User;
use App\Models\Workspace;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
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
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Task $task)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        if ($this->isOwnerWorkspaceOrProject($user))
            return true;

        return $user->hasAnyRolePermissions(['task_create'], ['user']) && $this->isProjectNotArchive();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Task $task)
    {
        if ($this->isOwnerWorkspaceOrProject($user))
            return true;

        return $user->hasAnyRolePermissions(['task_update'], ['user']) && $this->isProjectNotArchive();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Task $task)
    {
        if ($this->isOwnerWorkspaceOrProject($user))
            return true;

        return $user->hasAnyRolePermissions(['task_delete'], ['user']) && $this->isProjectNotArchive();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Task $task)
    {
        if ($this->isOwnerWorkspaceOrProject($user))
            return true;

        return $user->hasAnyRolePermissions(['task_restore'], ['user']) && $this->isProjectNotArchive();
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Task $task)
    {
        if ($this->isOwnerWorkspaceOrProject($user))
            return true;

        return $user->hasAnyRolePermissions(['task_delete'], ['user']) && $this->isProjectNotArchive();
    }

    /**
     * Determine whether the user can change status task.
     *
     * @param User $user
     * @param Task $task
     * @param Status $status
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function changeStatusTask(User $user, Task $task, Status $status)
    {
        return $this->isWorkspaceActiveAndProjectActive($task) &&
            $this->isProjectNotArchive($task) &&
            $task->status_id != $status->id &&
            ($this->isOwnerWorkspaceOrProject($user) || $task->user_id === $user->id);
    }

    /**
     * Determine whether the user can change status task user.
     *
     * @param User $user
     * @param Task $task
     * @param Status $status
     * @param TaskUser $task_user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function changeStatusTaskUser(User $user, Task $task, Status $status, TaskUser $task_user)
    {
        return $this->isWorkspaceActiveAndProjectActive($task) &&
            $this->isProjectNotArchive($task) &&
            $task_user->status_id != $status->id &&
            ($this->isOwnerWorkspaceOrProject($user) || $task->user_id === $user->id || $task_user->user_id === $user->id);
    }

    /**
     * Determine whether the user can assign user task.
     *
     * @param User $user
     * @param Task $task
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function assignUser(User $user, Task $task, User $userAssign, Workspace $workspace)
    {
        return $this->isWorkspaceActiveAndProjectActive($task) &&
            $this->isProjectNotArchive($task) &&
            $workspace->users()->where('id', $userAssign->id)->exists() &&
            ($this->isOwnerWorkspaceOrProject($user) || $task->user_id === $user->id);
    }

    /**
     * Determine whether the user can add comment task.
     *
     * @param User $user
     * @param Task $task
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function addCommentTask(User $user, Task $task)
    {
        return $this->isWorkspaceActiveAndProjectActive($task) &&
            $this->isProjectNotArchive($task) &&
            ($this->isOwnerWorkspaceOrProject($user) || $task->user_id === $user->id || $task->users()->where('id', $user->id)->exists());
    }

    /**
     * Determine whether the user can update comment task.
     *
     * @param User $user
     * @param Task $task
     * @param Comment $comment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function updateCommentTask(User $user, Task $task, Comment $comment)
    {
        return $this->isWorkspaceActiveAndProjectActive($task) &&
            $this->isProjectNotArchive($task) &&
            $comment->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete media task.
     *
     * @param User $user
     * @param Task $task
     * @param Media $media
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function deleteAttachment(User $user, Task $task, Media $media)
    {
        return $this->isWorkspaceActiveAndProjectActive($task) &&
            $this->isProjectNotArchive($task) &&
            $media->user instanceof $user && $media->user?->id === $user->getAttribute('id');
    }

    private function isOwnerWorkspaceOrProject(User $user, Task $task = null)
    {
        $workspace = blank($task) ? getWorkspaceModel() : $task?->project?->workspace;
        if ($workspace?->user_id == $user->id)
            return true;

        $project ??= getProjectModel();
        if ($project?->user_id == $user->id)
            return true;

        return false;
    }

    private function isWorkspaceActiveAndProjectActive(Task $task = null)
    {
        $task ??= getTaskModel();
        $workspace =  $task?->project?->workspace;

        if ($task && $workspace && $workspace?->is_active && $task?->project?->is_active)
            return true;

        return false;
    }

    private function isProjectNotArchive(Task $task = null)
    {
        $project = $task?->project ?? getProjectModel();

        if ($project && !$project?->is_archive)
            return true;

        return false;
    }
}
