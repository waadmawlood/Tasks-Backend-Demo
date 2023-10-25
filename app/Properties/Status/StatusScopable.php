<?php

namespace App\Properties\Status;

use Illuminate\Database\Eloquent\Builder;
use Waad\Repository\Traits\HasScopeable;

trait StatusScopable
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
    public function scopeCustom(Builder $query): void
    {
        $query->where('workspace_id', getPermissionsTeamId());
    }

    public function scopeDefault(Builder $query): void
    {
        $query->whereNull('workspace_id');
    }
}
