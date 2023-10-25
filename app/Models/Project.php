<?php

namespace App\Models;

use App\Properties\Project\ProjectPropertable;
use App\Properties\Project\ProjectScopable;
use App\Properties\Project\ProjectAccessorable;
use App\Properties\Project\ProjectMutatorable;
use App\Properties\Project\ProjectRelatable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Waad\Media\Traits\HasOneMedia;

class Project extends Model
{
    use HasUuids;
    use SoftDeletes;
    use ProjectPropertable;
    use ProjectScopable;
    use ProjectAccessorable;
    use ProjectMutatorable;
    use ProjectRelatable;

    use HasFactory;
    use HasOneMedia;
}
