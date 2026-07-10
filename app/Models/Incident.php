<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Incident extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'reported_by', 'title', 'description', 'type', 'severity',
        'status', 'location_name', 'affected_people',
        'needs_volunteers', 'needs_donations',
    ];

    protected $casts = [
        'needs_volunteers' => 'boolean',
        'needs_donations'  => 'boolean',
    ];

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reported_by')->withTrashed();
    }

    public function reliefRequests()
    {
        return $this->hasMany(ReliefRequest::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function volunteerTasks()
    {
        return $this->hasMany(VolunteerTask::class);
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['verified', 'active']);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function getSeverityBadgeAttribute(): string
    {
        return match ($this->severity) {
            'low'      => '<span class="badge bg-success">Low</span>',
            'medium'   => '<span class="badge bg-warning text-dark">Medium</span>',
            'high'     => '<span class="badge bg-orange" style="background:#fd7e14">High</span>',
            'critical' => '<span class="badge bg-danger">Critical</span>',
            default    => '<span class="badge bg-secondary">Unknown</span>',
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending'  => '<span class="badge bg-secondary">Pending</span>',
            'verified' => '<span class="badge bg-info text-dark">Verified</span>',
            'active'   => '<span class="badge bg-danger">Active</span>',
            'resolved' => '<span class="badge bg-success">Resolved</span>',
            default    => '<span class="badge bg-secondary">Unknown</span>',
        };
    }

    public function getTypeIconAttribute(): string
    {
        return match ($this->type) {
            'flood'      => '🌊',
            'earthquake' => '🏚️',
            'cyclone'    => '🌀',
            'fire'       => '🔥',
            'landslide'  => '⛰️',
            'drought'    => '☀️',
            default      => '⚠️',
        };
    }
}
