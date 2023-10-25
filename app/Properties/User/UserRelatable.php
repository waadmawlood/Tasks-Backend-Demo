<?php

namespace App\Properties\User;

use App\Models\Workspace;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Waad\Repository\Traits\ConstructorableModel;

trait UserRelatable
{

    /** constructor : do not remove that */
    use ConstructorableModel;

    // attributes allowed include join from db by request parameter
    // ex : `example.com/api/posts?include=users,comments,likes.user`
    public $includeable = [
        'workSpaceOwners',
        'workspaces',
    ];


    /** always return relationship with any request of this model */
    public $with_override = [];


    /** always return count records of relationship with any request of this model */
    public $withCount_override = [];


    /** +-----------+------------+------------+------------+ **/
    /**      Related     Function     with      model        **/
    /** +-----------+------------+------------+------------+ **/


    public function workSpaceOwners(): HasMany
    {
        return $this->hasMany(Workspace::class);
    }


    public function workspaces(): BelongsToMany
    {
        return $this->belongsToMany(Workspace::class)->withTimestamps()->withPivot('is_active')->withCasts(['is_active' => 'boolean']);
    }
}
