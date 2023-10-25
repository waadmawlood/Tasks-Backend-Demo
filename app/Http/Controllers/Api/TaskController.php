<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\AddCommentRequest;
use App\Http\Requests\Task\AddMediaCommentRequest;
use App\Http\Requests\Task\IndexTaskRequest;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateCommentRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Interfaces\TaskInterface;
use App\Models\Comment;
use App\Models\Media;
use App\Models\Project;
use App\Models\Status;
use App\Models\Task;
use App\Models\TaskUser;
use App\Models\User;
use App\Models\Workspace;

class TaskController extends Controller
{
    /**
     * TaskRepository
     * @var TaskInterface
     */
    private $TaskRepository;

    /**
     * TaskController::__construct
     *
     * @param TaskInterface $taskRepository
     */
    public function __construct(TaskInterface $taskRepository)
    {
        $this->authorizeResource(Task::class, 'task');
        $this->TaskRepository = $taskRepository;
    }

    /**
     * Get List
     *
     * @param IndexTaskRequest $request
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function index(IndexTaskRequest $request)
    {
        return $this->TaskRepository->index($request);
    }

    /**
     * Store
     *
     * @param  \App\Http\Requests\Task\StoreTaskRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreTaskRequest $request)
    {
        return $this->TaskRepository->store($request->validated());
    }

    /**
     * Show
     *
     * @param  \App\Models\Task  $task
     * @return Task|null
     */
    public function show(Workspace $workspace, Project $project, Task $task)
    {
        return $this->TaskRepository->show($task);
    }

    /**
     * Update
     *
     * @param  \App\Http\Requests\Task\UpdateTaskRequest  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateTaskRequest $request, Workspace $workspace, Project $project, Task $task)
    {
        return $this->TaskRepository->update($request->validated(), $task);
    }

    /**
     * Soft Delete
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Workspace $workspace, Project $project, Task $task)
    {
        return $this->TaskRepository->destroy($task);
    }

    /**
     * Force Delete
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Workspace $workspace, Project $project, Task $task)
    {
        return $this->TaskRepository->delete($task);
    }

    /**
     * Restore
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore(Workspace $workspace, Project $project, Task $task)
    {
        return $this->TaskRepository->restore($task);
    }

    /**
     * Change Status Task
     *
     * @param Workspace $workspace
     * @param Project $project
     * @param Task $task
     * @param Status $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeStatusTask(Workspace $workspace, Project $project, Task $task, Status $status)
    {
        $this->authorize('changeStatusTask', [$task, $status]);
        return $this->TaskRepository->changeStatusTask($task, $status);
    }

    /**
     * Change Status Task User
     *
     * @param Workspace $workspace
     * @param Project $project
     * @param Task $task
     * @param Status $status
     * @param TaskUser $task_user
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeStatusTaskUser(Workspace $workspace, Project $project, Task $task, Status $status, TaskUser $task_user)
    {
        $this->authorize('changeStatusTaskUser', [$task, $status, $task_user]);
        return $this->TaskRepository->changeStatusTaskUser($task_user, $status);
    }

    /**
     * Add Attachments
     *
     * @param AddMediaCommentRequest $request
     * @param Workspace $workspace
     * @param Project $project
     * @param Task $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function addAttachment(AddMediaCommentRequest $request, Workspace $workspace, Project $project, Task $task)
    {
        $this->authorize('addCommentTask', $task);
        return $this->TaskRepository->addAttachment($request, $task, $workspace);
    }

    /**
     * Delete Attachment
     *
     * @param Workspace $workspace
     * @param Project $project
     * @param Task $task
     * @param Media $media
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteAttachment(Workspace $workspace, Project $project, Task $task, Media $media)
    {
        $this->authorize('deleteAttachment', [$task, $media]);
        return $this->TaskRepository->deleteAttachment($media);
    }

    /**
     * Assign User
     *
     * @param Workspace $workspace
     * @param Project $project
     * @param Task $task
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function assignUser(Workspace $workspace, Project $project, Task $task, User $user)
    {
        $this->authorize('assignUser', [$task, $user, $workspace]);
        return $this->TaskRepository->assignUser($task, $user);
    }

    /**
     * Add Comment
     *
     * @param AddCommentRequest $request
     * @param Workspace $workspace
     * @param Project $project
     * @param Task $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function addComment(AddCommentRequest $request, Workspace $workspace, Project $project, Task $task)
    {
        $this->authorize('addCommentTask', $task);
        return $this->TaskRepository->addComment($request, $task, $workspace);
    }

    /**
     * Update Comment
     *
     * @param UpdateCommentRequest $request
     * @param Workspace $workspace
     * @param Project $project
     * @param Task $task
     * @param Comment $comment
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateComment(UpdateCommentRequest $request, Workspace $workspace, Project $project, Task $task, Comment $comment)
    {
        $this->authorize('updateCommentTask', [$task, $comment]);
        return $this->TaskRepository->updateComment($request, $comment);
    }

    /**
     * Delete Comment
     *
     * @param Workspace $workspace
     * @param Project $project
     * @param Task $task
     * @param Comment $comment
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteComment(Workspace $workspace, Project $project, Task $task, Comment $comment)
    {
        $this->authorize('updateCommentTask', [$task, $comment]);
        return $this->TaskRepository->deleteComment($comment);
    }

    /**
     * Add Media Comment
     *
     * @param AddMediaCommentRequest $request
     * @param Workspace $workspace
     * @param Project $project
     * @param Task $task
     * @param Comment $comment
     * @return \Illuminate\Http\JsonResponse
     */
    public function addMediaComment(AddMediaCommentRequest $request, Workspace $workspace, Project $project, Task $task, Comment $comment)
    {
        $this->authorize('updateCommentTask', [$task, $comment]);
        return $this->TaskRepository->addMediaComment($request, $comment, $workspace);
    }

    /**
     * Delete Media Comment
     *
     * @param Workspace $workspace
     * @param Project $project
     * @param Task $task
     * @param Comment $comment
     * @param Media $media
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteMediaComment(Workspace $workspace, Project $project, Task $task, Comment $comment, Media $media)
    {
        $this->authorize('updateCommentTask', [$task, $comment]);
        return $this->TaskRepository->deleteMediaComment($media);
    }
}
