<?php

namespace App\Properties\Permission;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\PermissionRegistrar;
use Waad\Repository\Traits\ConstructorableModel;

trait PermissionRelatable
{

    /** constructor : do not remove that */
    use ConstructorableModel;

    // attributes allowed include join from db by request parameter
    // ex : `example.com/api/posts?include=users,comments,likes.user`
    public $includeable = [
        'users',
    ];


    /** always return relationship with any request of this model */
    public $with_override = [];


    /** always return count records of relationship with any request of this model */
    public $withCount_override = [];


    /** +-----------+------------+------------+------------+ **/
    /**      Related     Function     with      model        **/
    /** +-----------+------------+------------+------------+ **/


    public function permissions(): BelongsToMany
    {
        $relation = $this->morphToMany(
            config('permission.models.permission'),
            'model',
            config('permission.table_names.model_has_permissions'),
            config('permission.column_names.model_morph_key'),
            PermissionRegistrar::$pivotPermission
        )->withPivot('work_space_id');

        if ($this->workSpaceId) {
            $relation = $relation->wherePivot('work_space_id', $this->workSpaceId);
        }

        if (! PermissionRegistrar::$teams) {
            return $relation;
        }

        return $relation->wherePivot(PermissionRegistrar::$teamsKey, getPermissionsTeamId());
    }

}
