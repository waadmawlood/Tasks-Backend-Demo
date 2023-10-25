<?php

namespace App\Properties\Task;

use App\Models\Project;
use App\Models\Status;
use App\Models\TaskUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Waad\Repository\Traits\ConstructorableModel;

trait TaskRelatable
{

    /** constructor : do not remove that */
    use ConstructorableModel;

    // attributes allowed include join from db by request parameter
    // ex : `example.com/api/posts?include=users,comments,likes.user`
    public $includeable = [
        'owner',
        'project',
        'project.workspace',
        'attachments',
        'comments',
        'status',
        'users',
    ];


    /** always return relationship with any request of this model */
    public $with_override = [

    ];


    /** always return count records of relationship with any request of this model */
    public $withCount_override = [
        'attachments',
        'comments',
        'users'
    ];


    /** +-----------+------------+------------+------------+ **/
    /**      Related     Function     with      model        **/
    /** +-----------+------------+------------+------------+ **/

    /**
     * Get the user that owns the TaskRelatable
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id')->select(['id', 'name', 'email', 'gender', 'last_active', 'timezone']);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }


    public function attachments(): MorphMany
    {
        return $this->media();
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withPivot(['id', 'status_id'])
            ->withTimestamps()
            ->as('task_user')
            ->using(TaskUser::class);
    }
}
