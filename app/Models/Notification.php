<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_id',
        'type',
        'title',
        'message',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships

    /**
     * Get the user who received this notification
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the event associated with this notification
     */
    public function event()
    {
        return $this->belongsTo(Event::class)->nullable();
    }
}
