<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Http\Requests\Unlimit;
use App\Interfaces\ProjectInterface;
use App\Models\Project;
use App\Models\Workspace;

class ProjectController extends Controller
{
    /**
     * ProjectRepository
     * @var ProjectInterface
     */
    private $ProjectRepository;

    /**
     * ProjectController::__construct
     *
     * @param ProjectInterface $projectRepository
     */
    public function __construct(ProjectInterface $projectRepository)
    {
        $this->authorizeResource(Project::class, 'project');
        $this->ProjectRepository = $projectRepository;
    }

    /**
     * Get List
     *
     * @param Unlimit $pagination use `Pagination Or Unlimit`
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Pagination\LengthAwarePaginator
     */
    public function index(Unlimit $pagination)
    {
        return $this->ProjectRepository->index($pagination);
    }

    /**
     * Store
     *
     * @param  \App\Http\Requests\Project\StoreProjectRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreProjectRequest $request)
    {
        return $this->ProjectRepository->store($request);
    }

    /**
     * Show
     *
     * @param  \App\Models\Project  $project
     * @return \App\Models\Project|null
     */
    public function show(Workspace $workspace, Project $project)
    {
        return $this->ProjectRepository->show($project);
    }

    /**
     * Update
     *
     * @param  \App\Http\Requests\Project\UpdateProjectRequest  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateProjectRequest $request, Workspace $workspace, Project $project)
    {
        return $this->ProjectRepository->update($request, $project);
    }

    /**
     * Soft Delete
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Workspace $workspace, Project $project)
    {
        return $this->ProjectRepository->destroy($project);
    }

    /**
     * Force Delete
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Workspace $workspace, Project $project)
    {
        return $this->ProjectRepository->delete($project);
    }

    /**
     * Restore
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore(Workspace $workspace, Project $project)
    {
        return $this->ProjectRepository->restore($project);
    }

    /**
     * My Projects
     *
     * @param Unlimit $request
     * @return mixed
     */
    public function myProjects(Unlimit $request)
    {
        return $this->ProjectRepository->myProjects($request);
    }

    /**
     * Toggle Active
     *
     * @param Project $project
     * @return Project
     */
    public function toggleActive(Workspace $workspace, Project $project)
    {
        $this->authorize('toggleActive', $project);
        return $this->ProjectRepository->toggleActive($project);
    }

    /**
     * Make Archive
     *
     * @param Project $project
     * @return Project
     */
    public function makeArchive(Workspace $workspace, Project $project)
    {
        $this->authorize('makeArchive', $project);
        return $this->ProjectRepository->makeArchive($project);
    }
}
