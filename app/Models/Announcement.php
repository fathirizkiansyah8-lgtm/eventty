<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

#[Fillable([
    'title', 'content', 'target', 'target_filter', 'status',
    'publish_date', 'created_by', 'priority', 'is_pinned'
])]
class Announcement extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'target_filter' => 'array',
            'publish_date' => 'datetime',
            'is_pinned' => 'boolean',
        ];
    }

    /**
     * User who created this announcement
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Check if announcement is active
     */
    public function isActive(): bool
    {
        return $this->status === 'active' && $this->publish_date <= Carbon::now();
    }

    /**
     * Check if announcement is scheduled
     */
    public function isScheduled(): bool
    {
        return $this->status === 'scheduled' && $this->publish_date > Carbon::now();
    }

    /**
     * Get formatted publish date
     */
    public function getFormattedPublishDateAttribute(): string
    {
        return $this->publish_date->format('d F Y, H:i');
    }

    /**
     * Get priority badge class
     */
    public function getPriorityBadgeClassAttribute(): string
    {
        return match ($this->priority) {
            'high' => 'badge-warning',
            'urgent' => 'badge-danger',
            default => 'badge-info',
        };
    }

    /**
     * Get target audience description
     */
    public function getTargetDescriptionAttribute(): string
    {
        return match ($this->target) {
            'all_students' => 'Semua Siswa',
            'participants' => 'Peserta Event',
            'all_users' => 'Semua Pengguna',
            'specific_class' => 'Kelas Tertentu',
            default => 'Tidak Diketahui',
        };
    }

    /**
     * Scope for active announcements
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
            ->where('publish_date', '<=', Carbon::now());
    }

    /**
     * Scope for pinned announcements
     */
    public function scopePinned($query)
    {
        return $query->where('is_pinned', true);
    }

    /**
     * Scope for high priority announcements
     */
    public function scopeHighPriority($query)
    {
        return $query->whereIn('priority', ['high', 'urgent']);
    }

    /**
     * Scope for target audience
     */
    public function scopeForTarget($query, $target)
    {
        return $query->where('target', $target);
    }
}
