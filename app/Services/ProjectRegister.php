<?php

namespace App\Services;

class ProjectRegister
{
    protected $projectId;

    /**
     * @param @param  int|string|\Illuminate\Database\Eloquent\Model $id
     * @return void
     */
    public function setProjectId($id)
    {
        if ($id instanceof \Illuminate\Database\Eloquent\Model) {
            $id = $id->getKey();
        }

        $this->projectId = $id;
    }

    /**
     * @return int|string
     */
    public function getProjectId()
    {
        return $this->projectId;
    }
}
