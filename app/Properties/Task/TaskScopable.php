<?php

namespace App\Properties\Task;

use Illuminate\Database\Eloquent\Builder;
use Waad\Repository\Traits\HasScopeable;

trait TaskScopable
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
    public function scopeWorkspace(Builder $query)
    {
        $query->whereRelation('project', 'workspace_id', getPermissionsTeamId());
    }

    /**
     * project scope
     *
     * @param Builder $query
     * @return void
     */
    public function scopeProject(Builder $query)
    {
        $query->where('project_id', getProjectId());
    }

    /**
     * Active project scope
     *
     * @param Builder $query
     * @return void
     */
    public function scopeActiveProject(Builder $query, bool $is_active = true)
    {
        $query->whereRelation('project', 'is_active', $is_active);
    }

    /**
     * Archive project scope
     *
     * @param Builder $query
     * @return void
     */
    public function scopeArchiveProject(Builder $query, bool $is_archive = true)
    {
        $query->whereRelation('project', 'is_archive', $is_archive);
    }

    /**
     * Status Done scope
     *
     * @param Builder $query
     * @return void
     */
    public function scopeDoneStatus(Builder $query, bool $is_done = true)
    {
        $query->whereRelation('status', 'is_done', $is_done);
    }

    /**
     * Status Test scope
     *
     * @param Builder $query
     * @return void
     */
    public function scopeTestStatus(Builder $query, bool $is_test = true)
    {
        $query->whereRelation('status', 'is_test', $is_test);
    }

}
