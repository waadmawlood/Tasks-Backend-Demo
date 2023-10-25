<?php

namespace App\Models;

use App\Properties\Admin\AdminPropertable;
use App\Properties\Admin\AdminScopable;
use App\Properties\Admin\AdminAccessorable;
use App\Properties\Admin\AdminMutatorable;
use App\Properties\Admin\AdminRelatable;
use App\Traits\HasJwt;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Waad\Repository\Traits\HasAnyRolePermissions;

class Admin extends Authenticatable implements JWTSubject
{
    use HasFactory;

    use HasUuids;
    use SoftDeletes;
    use AdminPropertable;
    use AdminScopable;
    use AdminAccessorable;
    use AdminMutatorable;
    use AdminRelatable;

    use HasRoles;
    use HasAnyRolePermissions;

    use HasJwt;
}
