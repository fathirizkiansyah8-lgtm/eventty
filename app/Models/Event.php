<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

#[Fillable([
    'name', 'description', 'category_id', 'date', 'start_time', 'end_time',
    'location', 'organizer', 'quota', 'registered_count', 'banner_path', 'status', 'created_by'
])]
class Event extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'date' => 'date',
            'start_time' => 'datetime:H:i',
            'end_time' => 'datetime:H:i',
            'quota' => 'integer',
            'registered_count' => 'integer',
        ];
    }

    /**
     * Category of this event
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(EventCategory::class, 'category_id');
    }

    /**
     * User who created this event
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Participants of this event
     */
    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'event_participants')
            ->withPivot(['registration_date', 'attendance_status', 'attendance_checked_at', 'attendance_checked_by', 'notes'])
            ->withTimestamps();
    }

    /**
     * Certificates issued for this event
     */
    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }

    /**
     * Check if event is full
     */
    public function isFull(): bool
    {
        return $this->quota > 0 && $this->registered_count >= $this->quota;
    }

    /**
     * Check if user is registered for this event
     */
    public function isUserRegistered(User $user): bool
    {
        return $this->participants()->where('user_id', $user->id)->exists();
    }

    /**
     * Get remaining slots
     */
    public function getRemainingSlots(): int
    {
        return max(0, $this->quota - $this->registered_count);
    }

    /**
     * Check if event is upcoming
     */
    public function isUpcoming(): bool
    {
        return $this->date >= Carbon::today();
    }

    /**
     * Check if event is past
     */
    public function isPast(): bool
    {
        return $this->date < Carbon::today();
    }

    /**
     * Get full banner URL
     */
    public function getBannerUrlAttribute(): string
    {
        return $this->banner_path ? asset('storage/' . $this->banner_path) : asset('images/default-event.png');
    }

    /**
     * Get formatted date
     */
    public function getFormattedDateAttribute(): string
    {
        return $this->date->format('d F Y');
    }

    /**
     * Get formatted time range
     */
    public function getFormattedTimeAttribute(): string
    {
        return $this->start_time->format('H:i') . ' - ' . $this->end_time->format('H:i');
    }

    /**
     * Get days until event
     */
    public function getDaysUntilEventAttribute(): int
    {
        return Carbon::today()->diffInDays($this->date, false);
    }

    /**
     * Scope for active events
     */
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['open', 'closed']);
    }

    /**
     * Scope for upcoming events
     */
    public function scopeUpcoming($query)
    {
        return $query->where('date', '>=', Carbon::today());
    }

    /**
     * Increment registered count
     */
    public function incrementRegisteredCount(): void
    {
        $this->increment('registered_count');
    }

    /**
     * Decrement registered count
     */
    public function decrementRegisteredCount(): void
    {
        $this->decrement('registered_count');
    }
}
