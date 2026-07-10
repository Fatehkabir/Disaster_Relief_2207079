<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VolunteerTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'incident_id', 'created_by', 'title', 'description',
        'category', 'status', 'volunteers_needed', 'volunteers_assigned',
        'location_name',
    ];

    public function incident()
    {
        return $this->belongsTo(Incident::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by')->withTrashed();
    }

    public function volunteers()
    {
        return $this->belongsToMany(User::class, 'volunteer_task_assignments', 'volunteer_task_id', 'user_id')
                    ->withPivot(['status', 'assigned_at'])
                    ->withTimestamps();
    }

    public function assignments()
    {
        return $this->hasMany(VolunteerTaskAssignment::class);
    }

    public function isFull(): bool
    {
        return $this->volunteers_assigned >= $this->volunteers_needed;
    }

    public function getSpotsLeftAttribute(): int
    {
        return max(0, $this->volunteers_needed - $this->volunteers_assigned);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'open'        => '<span class="badge bg-success">Open</span>',
            'in_progress' => '<span class="badge bg-primary">In Progress</span>',
            'completed'   => '<span class="badge bg-dark">Completed</span>',
            default       => '<span class="badge bg-secondary">Unknown</span>',
        };
    }

    public function getCategoryLabelAttribute(): string
    {
        return match ($this->category) {
            'search_rescue'    => '🔍 Search & Rescue',
            'medical_aid'      => '🏥 Medical Aid',
            'food_distribution'=> '🍲 Food Distribution',
            'shelter_setup'    => '🏕️ Shelter Setup',
            'logistics'        => '🚛 Logistics',
            default            => '🤝 Other',
        };
    }
}
