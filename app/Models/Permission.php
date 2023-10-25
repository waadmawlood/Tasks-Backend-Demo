<?php

namespace App\Models;

use App\Properties\Permission\PermissionPropertable;
use App\Properties\Permission\PermissionScopable;
use App\Properties\Permission\PermissionAccessorable;
use App\Properties\Permission\PermissionMutatorable;
use App\Properties\Permission\PermissionRelatable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Spatie\Permission\Models\Permission as ModelsPermission;

class Permission extends ModelsPermission
{
    use HasUuids;
    use PermissionPropertable;
    use PermissionScopable;
    use PermissionAccessorable;
    use PermissionMutatorable;
    use PermissionRelatable;
}
