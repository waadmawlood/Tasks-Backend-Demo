<?php

namespace App\Models;

use App\Properties\Task\TaskPropertable;
use App\Properties\Task\TaskScopable;
use App\Properties\Task\TaskAccessorable;
use App\Properties\Task\TaskMutatorable;
use App\Properties\Task\TaskRelatable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Waad\Comments\Traits\HasComments;
use Waad\Media\Traits\HasManyMedia;

class Task extends Model
{
    use HasUuids;
    use SoftDeletes;
    use TaskPropertable;
    use TaskScopable;
    use TaskAccessorable;
    use TaskMutatorable;
    use TaskRelatable;

    use HasFactory;
    use HasManyMedia;
    use HasComments;

    public $media_directory = 'attachments';
}
