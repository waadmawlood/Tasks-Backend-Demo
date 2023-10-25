<?php

namespace App\Properties\Task;

use App\Enums\TaskPriority;

trait TaskAccessorable
{

    /**
     * Set attribute to body request
     * @var array $appends_override
     **/
    protected $appends_override = [];


    /** +-----------+------------+------------+------------+ **/
    /**     Accessor     Function      Get      Value        **/
    /** +-----------+------------+------------+------------+ **/


    public function getPriorityAttribute()
    {
        return TaskPriority::tryFrom($this->attributes['priority'])?->name;
    }
}
