<?php

namespace App\Properties\Task;

use App\Enums\TaskPriority;

trait TaskMutatorable
{
    /** +-----------+------------+------------+------------+ **/
    /**      Mutator     Function     Set      Values        **/
    /** +-----------+------------+------------+------------+ **/


    public function setPriorityAttribute($value)
    {
        $this->attributes['priority'] = TaskPriority::tryFromName($value)->value;
    }

}
