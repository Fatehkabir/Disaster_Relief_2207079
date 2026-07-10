<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VolunteerTaskAssignment extends Model
{
    protected $fillable = [
        'volunteer_task_id', 'user_id', 'status', 'assigned_at',
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
    ];

    public function task()
    {
        return $this->belongsTo(VolunteerTask::class, 'volunteer_task_id');
    }

    public function volunteer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
