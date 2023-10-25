<?php

namespace App\Models;

use App\Properties\Workspace\WorkspacePropertable;
use App\Properties\Workspace\WorkspaceRelatable;
use App\Properties\Workspace\WorkspaceScopable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Workspace extends Model
{
    use HasUuids;
    use SoftDeletes;
    use WorkspacePropertable;
    use WorkspaceScopable;
    use WorkspaceRelatable;

    use HasFactory;
}
