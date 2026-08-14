<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_id',
        'event_id',
        'user_id',
        'certificate_path',
        'certificate_number',
        'issued_date',
        'is_downloaded',
        'downloaded_at',
    ];

    protected $casts = [
        'issued_date' => 'datetime',
        'downloaded_at' => 'datetime',
        'is_downloaded' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships

    /**
     * Get the registration for this certificate
     */
    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    /**
     * Get the event for this certificate
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Get the user who received this certificate
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
