<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

#[Fillable([
    'event_id', 'user_id', 'registration_date', 'attendance_status',
    'attendance_checked_at', 'attendance_checked_by', 'notes'
])]
class EventParticipant extends Model
{
    use HasFactory;

    protected $table = 'event_participants';

    /**
     * The attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'registration_date' => 'datetime',
            'attendance_checked_at' => 'datetime',
        ];
    }

    /**
     * Event this participation belongs to
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * User participating in the event
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Admin who checked attendance
     */
    public function attendanceChecker(): BelongsTo
    {
        return $this->belongsTo(User::class, 'attendance_checked_by');
    }

    /**
     * Check if participant is present
     */
    public function isPresent(): bool
    {
        return $this->attendance_status === 'present';
    }

    /**
     * Check if participant is absent
     */
    public function isAbsent(): bool
    {
        return $this->attendance_status === 'absent';
    }

    /**
     * Mark as present
     */
    public function markPresent(User $checker): void
    {
        $this->update([
            'attendance_status' => 'present',
            'attendance_checked_at' => Carbon::now(),
            'attendance_checked_by' => $checker->id,
        ]);
    }

    /**
     * Mark as absent
     */
    public function markAbsent(User $checker): void
    {
        $this->update([
            'attendance_status' => 'absent',
            'attendance_checked_at' => Carbon::now(),
            'attendance_checked_by' => $checker->id,
        ]);
    }

    /**
     * Scope for present participants
     */
    public function scopePresent($query)
    {
        return $query->where('attendance_status', 'present');
    }

    /**
     * Scope for absent participants
     */
    public function scopeAbsent($query)
    {
        return $query->where('attendance_status', 'absent');
    }
}
