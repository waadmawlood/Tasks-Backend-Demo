<?php

namespace App\Properties\Project;

use Illuminate\Database\Eloquent\Builder;
use Waad\Repository\Traits\HasScopeable;

trait ProjectScopable
{
    /** +-----------+------------+------------+------------+ **/
    /**      Scope     Function     Query        Builde      **/
    /** +-----------+------------+------------+------------+ **/


    /**
    * trait including scope except of select
    */
    use HasScopeable;


    /**
     * workspace scope
     *
     * @param Builder $query
     * @return void
     */
    public function scopeWorkspace(Builder $query): void
    {
        $query->where('workspace_id', getPermissionsTeamId());
    }

}
