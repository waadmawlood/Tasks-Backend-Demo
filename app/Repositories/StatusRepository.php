<?php

namespace App\Repositories;

use App\Interfaces\StatusInterface;
use App\Models\Status;
use App\Models\Workspace;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Waad\Repository\Enums\ResponseStatus;
use Waad\Repository\Repositories\BaseRepository;

class StatusRepository extends BaseRepository implements StatusInterface
{
    public function __construct()
    {
        $this->model = new Status();
    }


    /**
     * index
     *
     * @param Request $request
     * @param Workspace $workspace
     * @param string|null $trash
     * @param bool|null $QueryBilderEnable
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index(Request $request, Workspace $workspace,  string|null $trash = null, bool|null $QueryBilderEnable = true)
    {
        $where = array();
        $statuses = $this->indexObject($request, $where, $trash, $QueryBilderEnable)
            ->orderBy('position')
            ->except(['created_at', 'updated_at', 'workspace_id', 'user_id']);

        if ($workspace->getAttribute('is_custom_status'))
            $statuses->custom();
        else
            $statuses->default();

        return $statuses->get();
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
            message: 'The Status data has been Created successfully',
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

        return $this->jsonResponce(
            message: 'The Status data has been Updated successfully',
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
            message: $response ? 'The Status data has been destroied successfully' : "Not Found",
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
            message: $response ? 'The Status data has been force deleted successfully' : "Not Found",
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
            message: $response ? 'The Status data has been restored successfully' : "Not Found",
            data: $response ? $response : null,
            status: $response ? ResponseStatus::NO_CONTENT->value : ResponseStatus::NOT_FOUND->value,
        );
    }
}
