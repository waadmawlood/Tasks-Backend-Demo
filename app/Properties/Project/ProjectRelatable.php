<?php

namespace App\Properties\Project;

use App\Models\User;
use App\Models\Workspace;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Waad\Repository\Traits\ConstructorableModel;

trait ProjectRelatable
{

    /** constructor : do not remove that */
    use ConstructorableModel;

    // attributes allowed include join from db by request parameter
    // ex : `example.com/api/posts?include=users,comments,likes.user`
    public $includeable = [
        'owner',
        'workspace',
        'media',
    ];


    /** always return relationship with any request of this model */
    public $with_override = [];


    /** always return count records of relationship with any request of this model */
    public $withCount_override = [];


    /** +-----------+------------+------------+------------+ **/
    /**      Related     Function     with      model        **/
    /** +-----------+------------+------------+------------+ **/

    /**
     * Get the user that owns the ProjectRelatable
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class)->select(['id', 'name', 'email', 'gender', 'last_active', 'timezone']);
    }

    public function workspace(): BelongsTo
    {
        return $this->belongsTo(Workspace::class)->except(['created_at', 'updated_at']);
    }
}
