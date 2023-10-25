<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Waad\Media\Media as MediaMedia;

class Media extends MediaMedia
{
    use HasUuids;
}
