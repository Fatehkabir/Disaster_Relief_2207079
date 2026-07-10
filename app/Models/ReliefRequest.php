<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReliefRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 'incident_id', 'title', 'description',
        'type', 'urgency', 'status', 'people_count',
        'location_name', 'contact_phone',
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function incident()
    {
        return $this->belongsTo(Incident::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeFulfilled($query)
    {
        return $query->where('status', 'fulfilled');
    }

    public function scopeUrgent($query)
    {
        return $query->whereIn('urgency', ['high', 'critical']);
    }

    public function getUrgencyBadgeAttribute(): string
    {
        return match ($this->urgency) {
            'low'      => '<span class="badge bg-success">Low</span>',
            'medium'   => '<span class="badge bg-warning text-dark">Medium</span>',
            'high'     => '<span class="badge" style="background:#fd7e14">High</span>',
            'critical' => '<span class="badge bg-danger">Critical</span>',
            default    => '<span class="badge bg-secondary">Unknown</span>',
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending'      => '<span class="badge bg-secondary">Pending</span>',
            'acknowledged' => '<span class="badge bg-info text-dark">Acknowledged</span>',
            'fulfilled'    => '<span class="badge bg-success">Fulfilled</span>',
            'cancelled'    => '<span class="badge bg-dark">Cancelled</span>',
            default        => '<span class="badge bg-secondary">Unknown</span>',
        };
    }

    public function getTypeIconAttribute(): string
    {
        return match ($this->type) {
            'food'     => '🍲',
            'water'    => '💧',
            'medicine' => '💊',
            'shelter'  => '🏠',
            'clothing' => '👕',
            'rescue'   => '🚑',
            default    => '📦',
        };
    }
}
