<?php

namespace App\Interfaces;

use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Waad\Repository\Interfaces\BaseInterface;

interface ProjectInterface extends BaseInterface
{

    /**
     * index
     *
     * @param Request $request
     * @param string|null $trash
     * @param bool|null $QueryBilderEnable
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Pagination\LengthAwarePaginator
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
     * @param Request $data
     * @param bool|null $is_object
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, bool|null $is_object = true);


    /**
     * update
     *
     * @param Request $request
     * @param Model|int|string $object
     * @param bool|null $getObject
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Model|int|string $object, bool|null $getObject = true);

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
     * Get my projects
     *
     * @param Request $request
     * @return mixed
     */
    public function myProjects(Request $request);

    /**
     * Toggle Active
     *
     * @param Project $project
     * @return Project
     */
    public function toggleActive(Project $project);

    /**
     * Make Archive
     *
     * @param Project $project
     * @return Project
     */
    public function makeArchive(Project $project);
}
