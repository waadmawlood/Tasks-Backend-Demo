<?php

namespace App\Properties\Workspace;

use App\Models\InviteWorkspace;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Waad\Repository\Traits\ConstructorableModel;

trait WorkspaceRelatable
{

    /** constructor : do not remove that */
    use ConstructorableModel;

    // attributes allowed include join from db by request parameter
    // ex : `example.com/api/posts?include=users,comments,likes.user`
    public $includeable = [
        'owner',
        'projects',
        'users',
        'invitations',
    ];


    /** always return relationship with any request of this model */
    public $with_override = [];


    /** always return count records of relationship with any request of this model */
    public $withCount_override = [];


    /** +-----------+------------+------------+------------+ **/
    /**      Related     Function     with      model        **/
    /** +-----------+------------+------------+------------+ **/


    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class)->select(['id', 'name', 'email', 'gender', 'last_active', 'timezone']);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withCasts(['is_active' => 'boolean'])->withPivot('is_active')->withTimestamps();
    }

    public function invitations(): HasMany
    {
        return $this->hasMany(InviteWorkspace::class);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }
}
