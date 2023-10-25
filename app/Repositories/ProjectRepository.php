<?php

namespace App\Repositories;

use App\Helpers\Guard;
use App\Interfaces\ProjectInterface;
use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Waad\Repository\Enums\ResponseStatus;
use Waad\Repository\Repositories\BaseRepository;

class ProjectRepository extends BaseRepository implements ProjectInterface
{
    public function __construct()
    {
        $this->model = new Project();
    }


    /**
     * index
     *
     * @param Request $request
     * @param string|null $trash
     * @param bool|null $QueryBilderEnable
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Pagination\LengthAwarePaginator
     */
    public function index(Request $request, string|null $trash = null, bool|null $QueryBilderEnable = true)
    {
        $where = array();
        $projects = $this->indexObject($request, $where, $trash, $QueryBilderEnable)->workspace();

        return $request->filled('take') ? $projects->paginate($request->take) : $projects->get();
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
     * @param Request $data
     * @param bool|null $is_object
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, bool|null $is_object = true)
    {
        $response = $this->storeObject(Arr::except($request->validated(), ['image']), $is_object);

        $this->addOrChangeCover($request, $response);

        return $this->jsonResponce(
            message: 'The Project data has been Created successfully',
            data: $is_object ? $response->load('media') : ['id' => $response],
            status: ResponseStatus::CREATED->value
        );
    }


    /**
     * update
     *
     * @param Request $request
     * @param Model|int|string $object
     * @param bool|null $getObject
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Model|int|string $object, bool|null $getObject = true)
    {
        $response = $this->updateObject(Arr::except($request->validated(), ['image']), $object, $getObject);

        $this->addOrChangeCover($request, $response, 'syncMedia');

        return $this->jsonResponce(
            status: ResponseStatus::NO_CONTENT->value,
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
            message: $response ? 'The Project data has been destroied successfully' : "Not Found",
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
            message: $response ? 'The Project data has been force deleted successfully' : "Not Found",
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
            message: $response ? 'The Project data has been restored successfully' : "Not Found",
            data: $response ? $response : null,
            status: $response ? ResponseStatus::NO_CONTENT->value : ResponseStatus::NOT_FOUND->value,
        );
    }

    /**
     * Get my projects
     *
     * @param Request $request
     * @return mixed
     */
    public function myProjects(Request $request)
    {
        $projects = $this->indexObject($request)->workspace();

        $user_id = Guard::authId();
        $projects = $projects->where('user_id', $user_id);

        return $request->filled('take') ? $projects->paginate($request->take) : $projects->get();
    }

    /**
     * Toggle Active
     *
     * @param Project $project
     * @return Project
     */
    public function toggleActive(Project $project)
    {
        $project->update(['is_active' => !$project->getAttribute('is_active')]);

        return $project;
    }

    /**
     * Make Archive
     *
     * @param Project $project
     * @return Project
     */
    public function makeArchive(Project $project)
    {
        $project->update(['is_archive' => false]);

        return $project;
    }

    /**
     * Summary of addOrChangeCover
     * @param mixed $request
     * @param mixed $project
     * @param mixed $method
     * @return void
     */
    private function addOrChangeCover($request, $project, $method = 'addMedia')
    {
        if ($request->hasFile('image')) {
            $project->$method($request->file('image'))
                ->directory(sprintf("workspaces/%s/projects/covers", getPermissionsTeamId() ?? 'general'))
                ->label('cover')
                ->upload();
        }
    }
}
