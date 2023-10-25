<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class TaskUser extends Pivot
{
    use HasUuids;

    public $table = 'task_user';

    protected $appends = ['status'];

    protected $hidden = ['statusTask'];

    public function getStatusAttribute(): mixed
    {
        return $this->statusTask;
    }

    public function statusTask(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'status_id')->select('id', 'name', 'color', 'position', 'is_test', 'is_done');
    }
}
