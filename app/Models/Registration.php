<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_id',
        'registration_date',
        'registration_number',
        'payment_status',
        'status',
    ];

    protected $casts = [
        'registration_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships

    /**
     * Get the user who registered
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the event this registration is for
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Get the attendance record for this registration
     */
    public function attendance()
    {
        return $this->hasOne(Attendance::class);
    }

    /**
     * Get the certificate for this registration
     */
    public function certificate()
    {
        return $this->hasOne(Certificate::class);
    }
}
