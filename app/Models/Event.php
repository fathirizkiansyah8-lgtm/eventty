<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category',
        'location',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'capacity',
        'current_participants_count',
        'organizer_id',
        'status',
        'thumbnail_image_path',
        'certificate_template_path',
        'is_paid',
        'price',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'is_paid' => 'boolean',
        'price' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships

    /**
     * Get the organizer of this event
     */
    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    /**
     * Get all registrations for this event
     */
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    /**
     * Get all attendance records for this event
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Get all certificates for this event
     */
    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    /**
     * Get all registered users
     */
    public function registeredUsers()
    {
        return $this->belongsToMany(User::class, 'registrations')
            ->withPivot('id', 'registration_number', 'payment_status', 'status', 'registration_date')
            ->withTimestamps();
    }

    /**
     * Get all notifications for this event
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}
