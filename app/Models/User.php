<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Properties\User\UserAccessorable;
use App\Properties\User\UserMutatorable;
use App\Properties\User\UserPropertable;
use App\Properties\User\UserRelatable;
use App\Properties\User\UserScopable;
use App\Traits\HasJwt;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Waad\Media\Traits\HasOneMedia;
use Waad\Repository\Traits\HasAnyRolePermissions;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory;

    use HasUuids;
    use SoftDeletes;
    use UserPropertable;
    use UserScopable;
    use UserAccessorable;
    use UserMutatorable;
    use UserRelatable;

    use HasRoles;
    use HasAnyRolePermissions;

    use HasJwt;
    use HasOneMedia;

    public $media_directory = 'avatars';
}
