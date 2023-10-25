<?php

if (!function_exists('setProjectId')) {

    /**
     * @param  int|string|\Illuminate\Database\Eloquent\Model  $id
     */
    function setProjectId($projectId)
    {
        if (blank($projectId))
            return null;

        app(\App\Services\ProjectRegister::class)->setProjectId($projectId);
    }
}


if (!function_exists('getProjectId')) {

    /**
     * @return int|string
     */
    function getProjectId()
    {
        return app(\App\Services\ProjectRegister::class)->getProjectId();
    }
}

if (!function_exists('setTaskId')) {

    /**
     * @param  int|string|\Illuminate\Database\Eloquent\Model  $id
     */
    function setTaskId($taskId)
    {
        if (blank($taskId))
            return null;

        app(\App\Services\TaskRegister::class)->setTaskId($taskId);
    }
}


if (!function_exists('getTaskId')) {

    /**
     * @return int|string
     */
    function getTaskId()
    {
        return app(\App\Services\TaskRegister::class)->getTaskId();
    }
}


if (!function_exists('getTaskModel')) {

    /**
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    function getTaskModel()
    {
        return \App\Models\Task::find(getTaskId());
    }
}

if (!function_exists('getProjectModel')) {

    /**
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    function getProjectModel()
    {
        return \App\Models\Project::find(getProjectId());
    }
}


if (!function_exists('getWorkspaceModel'))
{
    /**
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    function getWorkspaceModel()
    {
        return \App\Models\Workspace::find(getPermissionsTeamId());
    }
}


if (!function_exists('getFirstStatusId'))
{
    /**
     * @return int|string|null
     */
    function getFirstStatusId()
    {
        $workspace = getWorkspaceModel();
        if (blank($workspace)) {
            return \App\Models\Status::default()->orderBy('position')->first()?->id;
        }

        if ($workspace->is_custom_status) {
            return \App\Models\Status::custom()->orderBy('position')->first()?->id;
        }

        return \App\Models\Status::default()->orderBy('position')->first()?->id;
    }
}
