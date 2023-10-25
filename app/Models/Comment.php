<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Waad\Comments\Comment as CommentModel;
use Waad\Media\Traits\HasManyMedia;

class Comment extends CommentModel
{
    use SoftDeletes;
    use HasUuids;
    use HasManyMedia;
    use CascadeSoftDeletes;

    protected $guarded = [];

    protected $cascadeDeletes = ['media'];

    protected $with = ['media'];
    protected $withCount = ['media'];

    public $media_directory = 'comments';
}
