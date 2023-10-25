<?php

namespace App\Services;

class TaskRegister
{
    protected $taskId;

    /**
     * @param @param  int|string|\Illuminate\Database\Eloquent\Model $id
     * @return void
     */
    public function setTaskId($id)
    {
        if ($id instanceof \Illuminate\Database\Eloquent\Model) {
            $id = $id->getKey();
        }

        $this->taskId = $id;
    }

    /**
     * @return int|string
     */
    public function getTaskId()
    {
        return $this->taskId;
    }
}
