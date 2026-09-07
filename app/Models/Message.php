<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['sender_id', 'receiver_id', 'body', 'read_at'])]
class Message extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'read_at' => 'datetime',
        ];
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function isRead(): bool
    {
        return $this->read_at !== null;
    }

    public function isUnread(): bool
    {
        return $this->read_at === null;
    }

    /**
     * Get conversation thread between two users, ordered by time
     */
    public static function conversation(int $userA, int $userB)
    {
        return self::where(function ($q) use ($userA, $userB) {
                $q->where('sender_id', $userA)->where('receiver_id', $userB);
            })
            ->orWhere(function ($q) use ($userA, $userB) {
                $q->where('sender_id', $userB)->where('receiver_id', $userA);
            })
            ->orderBy('created_at', 'asc');
    }
}
