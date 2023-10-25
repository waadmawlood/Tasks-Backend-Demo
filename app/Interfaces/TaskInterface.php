<?php

namespace App\Interfaces;

use App\Models\Comment;
use App\Models\Media;
use App\Models\Status;
use App\Models\Task;
use App\Models\TaskUser;
use App\Models\User;
use App\Models\Workspace;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Waad\Repository\Interfaces\BaseInterface;

interface TaskInterface extends BaseInterface
{

    /**
     * index
     *
     * @param Request $request
     * @param string|null $trash
     * @param bool|null $QueryBilderEnable
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function index(Request $request, string|null $trash = null, bool|null $QueryBilderEnable = true);

    /**
     * show
     *
     * @param Model|int|string $object
     * @param bool|null $trash
     * @param bool|null $enableQueryBuilder
     * @return Model|null
     */
    public function show(Model|int|string $object, bool|null $trash = false, bool|null $enableQueryBuilder = true);

    /**
     * store
     *
     * @param array $data
     * @param bool|null $is_object
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(array $data, bool|null $is_object = true);

    /**
     * update
     *
     * @param array $values
     * @param Model|int|string $object
     * @param bool|null $getObject
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(array $values, Model|int|string $object, bool|null $getObject = false);

    /**
     * destroy
     *
     * @param Model|int|string $object
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Model|int|string $object);

    /**
     * delete
     *
     * @param Model|int|string $object
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Model|int|string $object);

    /**
     * restore
     *
     * @param Model|int|string $object
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore(Model|int|string $object);

    /**
     * Change Status Task
     *
     * @param Task $task
     * @param Status $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeStatusTask(Task $task, Status $status);

    /**
     * Change Status Task User
     *
     * @param TaskUser $taskUser
     * @param Status $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeStatusTaskUser(TaskUser $taskUser, Status $status);

    /**
     * Add Attachment
     *
     * @param Request $request
     * @param Task $task
     * @param Workspace $workspace
     * @return \Illuminate\Http\JsonResponse
     */
    public function addAttachment(Request $request, Task $task, Workspace $workspace);
    /**
     * Delete Attachment
     *
     * @param Media $media
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteAttachment(Media $media);

    /**
     * Assign User
     *
     * @param Task $task
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function assignUser(Task $task, User $user);

    /**
     * Add Comment With Media
     *
     * @param Request $request
     * @param Task $task
     * @param Workspace $workspace
     * @return \Illuminate\Http\JsonResponse
     */
    public function addComment(Request $request, Task $task, Workspace $workspace);

    /**
     * Update Comment
     *
     * @param Request $request
     * @param Comment $comment
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateComment(Request $request, Comment $comment);

    /**
     * Delete Comment
     *
     * @param Comment $comment
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteComment(Comment $comment);

    /**
     * Add Media Comment
     *
     * @param Request $request
     * @param Comment $comment
     * @param Workspace $workspace
     * @return \Illuminate\Http\JsonResponse
     */
    public function addMediaComment(Request $request, Comment $comment, Workspace $workspace);

    /**
     * Delete Media Comment
     *
     * @param Media $media
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteMediaComment(Media $media);
}
