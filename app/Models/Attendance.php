<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_id',
        'event_id',
        'user_id',
        'qr_code_token',
        'check_in_time',
        'check_out_time',
        'status',
    ];

    protected $casts = [
        'check_in_time' => 'datetime',
        'check_out_time' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships

    /**
     * Get the registration for this attendance
     */
    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    /**
     * Get the event for this attendance
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Get the user for this attendance
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
