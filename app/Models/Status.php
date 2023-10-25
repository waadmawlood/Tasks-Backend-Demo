<?php

namespace App\Models;

use App\Properties\Status\StatusPropertable;
use App\Properties\Status\StatusScopable;
use App\Properties\Status\StatusAccessorable;
use App\Properties\Status\StatusMutatorable;
use App\Properties\Status\StatusRelatable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{

    use HasUuids;
    use SoftDeletes;
    use StatusPropertable;
    use StatusScopable;
    use StatusAccessorable;
    use StatusMutatorable;
    use StatusRelatable;
}
