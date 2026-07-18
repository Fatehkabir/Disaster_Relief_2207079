<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Donation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'donor_id', 'incident_id', 'title', 'description',
        'category', 'quantity', 'unit', 'status', 'pickup_location',
    ];

    // ── Relationships ────────────────────────────────────────
    public function donor()
    {
        return $this->belongsTo(User::class, 'donor_id')->withTrashed();
    }

    public function incident()
    {
        return $this->belongsTo(Incident::class);
    }

    // ── Accessors ────────────────────────────────────────────
    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pledged'   => '<span class="badge bg-secondary">Pledged</span>',
            'collected' => '<span class="badge bg-info text-dark">Collected</span>',
            'delivered' => '<span class="badge bg-success">Delivered ✓</span>',
            default     => '<span class="badge bg-secondary">Unknown</span>',
        };
    }

    public function getCategoryIconAttribute(): string
    {
        return match ($this->category) {
            'food'              => '🍲',
            'water'             => '💧',
            'medicine'          => '💊',
            'clothing'          => '👕',
            'shelter_materials' => '🏠',
            'hygiene'           => '🧼',
            default             => '📦',
        };
    }
}
