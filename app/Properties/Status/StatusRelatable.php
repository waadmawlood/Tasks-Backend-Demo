<?php

namespace App\Properties\Status;

use App\Models\User;
use App\Models\Workspace;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Waad\Repository\Traits\ConstructorableModel;

trait StatusRelatable
{

    /** constructor : do not remove that */
    use ConstructorableModel;

    // attributes allowed include join from db by request parameter
    // ex : `example.com/api/posts?include=users,comments,likes.user`
    public $includeable = [
        'user',
        'workspace',
    ];


    /** always return relationship with any request of this model */
    public $with_override = [];


    /** always return count records of relationship with any request of this model */
    public $withCount_override = [];


    /** +-----------+------------+------------+------------+ **/
    /**      Related     Function     with      model        **/
    /** +-----------+------------+------------+------------+ **/


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->select(['id', 'name', 'email', 'gender', 'last_active', 'timezone']);
    }

    public function workspace(): BelongsTo
    {
        return $this->belongsTo(Workspace::class)->except(['created_at', 'updated_at']);
    }

}
