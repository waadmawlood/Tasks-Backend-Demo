<?php

namespace App\Repositories;

use App\Interfaces\TaskInterface;
use App\Models\Comment;
use App\Models\Media;
use App\Models\Status;
use App\Models\Task;
use App\Models\TaskUser;
use App\Models\User;
use App\Models\Workspace;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Waad\Repository\Enums\ResponseStatus;
use Waad\Repository\Repositories\BaseRepository;

class TaskRepository extends BaseRepository implements TaskInterface
{
    public function __construct()
    {
        $this->model = new Task();
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
        $tasks = $this->indexObject($request, $where, $trash, $QueryBilderEnable)
            ->activeProject()
            ->archiveProject(false);

        // filter if project exists else filter all by worksape
        if (filled(getProjectId()))
            $tasks = $tasks->project(); // filter by project scope
        else
            $tasks = $tasks->workspace(); // scope workspace

        if ($request->filled('is_test') && $request->boolean('is_test'))
            $tasks = $tasks->testStatus($request->is_test); // scope is_test

        if ($request->filled('is_done') && $request->boolean('is_completed'))
            $tasks = $tasks->doneStatus($request->is_done); // scope is_done

        if ($request->filled('is_active') && $request->boolean('is_active'))
            $tasks = $tasks->activeProject($request->is_active); // scope is_active

        if ($request->filled('is_archived') && $request->boolean('is_archived'))
            $tasks = $tasks->archiveProject($request->is_archived); // scope is_archived

        return $request->filled('take') ? $tasks->paginate($request->take) : $tasks->get();
    }


    /**
     * show
     *
     * @param Model|int|string $object
     * @param bool|null $trash
     * @param bool|null $enableQueryBuilder
     * @return Model|null
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
            message: 'The Task data has been Created successfully',
            data: $is_object ? $response : ['id' => $response],
            status: ResponseStatus::CREATED->value
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

        if ($response === false)
            return $this->jsonResponce(message: "There are some errors when updating", status: 400);

        return $this->jsonResponce(
            message: 'The Task data has been Updated successfully',
            data: $getObject ? $response : null,
            status: $getObject ? ResponseStatus::SUCCESS->value : ResponseStatus::NO_CONTENT->value,
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
            message: $response ? 'The Task data has been destroied successfully' : "Not Found",
            data: $response ? $response : null,
            status: $response ? ResponseStatus::NO_CONTENT->value : ResponseStatus::NOT_FOUND->value,
        );
    }

    /**
     * delete
     *
     * @param Model|int|string $object
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Model|int|string $object)
    {
        $response = $this->deleteObject($object);

        return $this->jsonResponce(
            message: $response ? 'The Task data has been force deleted successfully' : "Not Found",
            data: $response ? $response : null,
            status: $response ? ResponseStatus::NO_CONTENT->value : ResponseStatus::NOT_FOUND->value,
        );
    }

    /**
     * restore
     *
     * @param Model|int|string $object
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore(Model|int|string $object)
    {
        $response = $this->restoreObject($object);

        return $this->jsonResponce(
            message: $response ? 'The Task data has been restored successfully' : "Not Found",
            data: $response ? $response : null,
            status: $response ? ResponseStatus::NO_CONTENT->value : ResponseStatus::NOT_FOUND->value,
        );
    }

    /**
     * Change Status Task
     *
     * @param Task $task
     * @param Status $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeStatusTask(Task $task, Status $status)
    {
        $isUpadte = $task->update(['status_id' => $status->getAttribute('id')]);

        error_if(!$isUpadte, 400, "Task status not updated");

        return $this->jsonResponce(status: ResponseStatus::NO_CONTENT->value);
    }

    /**
     * Change Status Task User
     *
     * @param TaskUser $taskUser
     * @param Status $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeStatusTaskUser(TaskUser $taskUser, Status $status)
    {
        $isUpadte = $taskUser->update(['status_id' => $status->getAttribute('id')]);

        error_if(!$isUpadte, 400, "Task status not updated");

        return $this->jsonResponce(status: ResponseStatus::NO_CONTENT->value);
    }

    /**
     * Add Attachment
     *
     * @param Request $request
     * @param Task $task
     * @param Workspace $workspace
     * @return \Illuminate\Http\JsonResponse
     */
    public function addAttachment(Request $request, Task $task, Workspace $workspace)
    {
        $media = null;
        if ($request->hasFile('attachments')) {
            $media = $task->addMedia($request->file('attachments'))->upload();
            $workspace->increment('storage', $media->sum('file_size'));
        }

        return $this->jsonResponce(
            message: $media ? "Attachments Of Task uploaded successfully" : "Bad Request",
            data: $media ? $task->load('media') : null,
            status: $media ? ResponseStatus::CREATED->value : ResponseStatus::BAD_REQUEST->value
        );
    }

    /**
     * Delete Attachment
     *
     * @param Media $media
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteAttachment(Media $media)
    {
        return $this->deleteModel($media);
    }

    /**
     * Assign User
     *
     * @param Task $task
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function assignUser(Task $task, User $user)
    {
        $assigned = $task->users()->attach($user, ['status_id' => getFirstStatusId()]);

        return $this->jsonResponce(message: "Assign User successfully", data: $assigned, status: ResponseStatus::CREATED->value);
    }

    /**
     * Add Comment With Media
     *
     * @param Request $request
     * @param Task $task
     * @param Workspace $workspace
     * @return \Illuminate\Http\JsonResponse
     */
    public function addComment(Request $request, Task $task, Workspace $workspace)
    {
        $comment = $task->addComment($request->comment);

        if ($request->hasFile('attachments')) {
            $media = $comment->addMedia($request->file('attachments'))->upload();
            $workspace->increment('storage', $media->sum('file_size'));
        }

        return $this->jsonResponce(message: "Comment created successfully", data: $comment->load('media'), status: ResponseStatus::CREATED->value);
    }

    /**
     * Update Comment
     *
     * @param Request $request
     * @param Comment $comment
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateComment(Request $request, Comment $comment)
    {
        $isUpdated = $comment->update(['comment' => $request->comment]);
        return $this->jsonResponce(status: $isUpdated ? ResponseStatus::NO_CONTENT->value : ResponseStatus::BAD_REQUEST->value);
    }

    /**
     * Delete Comment
     *
     * @param Comment $comment
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteComment(Comment $comment)
    {
        return $this->deleteModel($comment);
    }

    /**
     * Add Media Comment
     *
     * @param Request $request
     * @param Comment $comment
     * @param Workspace $workspace
     * @return \Illuminate\Http\JsonResponse
     */
    public function addMediaComment(Request $request, Comment $comment, Workspace $workspace)
    {
        $media = null;
        if ($request->hasFile('attachments')) {
            $media = $comment->addMedia($request->file('attachments'))->upload();
            $workspace->increment('storage', $media->sum('file_size'));
        }

        return $this->jsonResponce(
            message: $media ? "Media of Comment uploaded successfully" : "Bad Request",
            data: $media ? $comment->load('media') : null,
            status: $media ? ResponseStatus::CREATED->value : ResponseStatus::BAD_REQUEST->value
        );
    }

    /**
     * Delete Media Comment
     *
     * @param Media $media
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteMediaComment(Media $media)
    {
        return $this->deleteModel($media);
    }

    /**
     * Delete Model
     *
     * @param Model $model
     * @return \Illuminate\Http\JsonResponse
     */
    private function deleteModel(Model $model)
    {
        $isDeleted = $model->delete();
        return $this->jsonResponce(status: $isDeleted ? ResponseStatus::NO_CONTENT->value : ResponseStatus::BAD_REQUEST->value);
    }
}
