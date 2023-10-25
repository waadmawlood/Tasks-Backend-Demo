<?php

namespace App\Models;

use App\Properties\Role\RolePropertable;
use App\Properties\Role\RoleScopable;
use App\Properties\Role\RoleAccessorable;
use App\Properties\Role\RoleMutatorable;
use App\Properties\Role\RoleRelatable;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Spatie\Permission\Models\Role as ModelsRole;

class Role extends ModelsRole
{
    use HasUuids;
    use RolePropertable;
    use RoleScopable;
    use RoleAccessorable;
    use RoleMutatorable;
    use RoleRelatable;
}
