<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'phone', 'is_active', 'profile_photo',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'password'  => 'hashed',
        'is_active' => 'boolean',
    ];

    // ── Role Helpers ─────────────────────────────────────────
    public function isAdmin(): bool     { return $this->role === 'admin'; }
    public function isVolunteer(): bool { return $this->role === 'volunteer'; }
    public function isVictim(): bool    { return $this->role === 'victim'; }

    // ── Relationships ────────────────────────────────────────
    public function reportedIncidents()
    {
        return $this->hasMany(Incident::class, 'reported_by');
    }

    public function reliefRequests()
    {
        return $this->hasMany(ReliefRequest::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class, 'donor_id');
    }

    public function volunteerTasks()
    {
        return $this->belongsToMany(VolunteerTask::class, 'volunteer_task_assignments', 'user_id', 'volunteer_task_id')
                    ->withPivot(['status', 'assigned_at'])
                    ->withTimestamps();
    }

    public function createdTasks()
    {
        return $this->hasMany(VolunteerTask::class, 'created_by');
    }

    // ── Accessors ────────────────────────────────────────────
    public function getRoleBadgeAttribute(): string
    {
        return match ($this->role) {
            'admin'     => '<span class="badge bg-danger">Admin</span>',
            'volunteer' => '<span class="badge bg-success">Volunteer</span>',
            'victim'    => '<span class="badge bg-warning text-dark">Victim</span>',
            default     => '<span class="badge bg-secondary">User</span>',
        };
    }

    public function getAvatarUrlAttribute(): string
    {
        if ($this->profile_photo) {
            return asset('storage/' . $this->profile_photo);
        }
        $name = urlencode($this->name);
        $color = match ($this->role) {
            'admin'     => 'dc2626',
            'volunteer' => '16a34a',
            default     => 'd97706',
        };
        return "https://ui-avatars.com/api/?name={$name}&background={$color}&color=fff&size=64";
    }
}
