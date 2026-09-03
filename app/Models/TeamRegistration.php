<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['event_id', 'user_id', 'team_name', 'captain_name', 'members'])]
class TeamRegistration extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'members' => 'array',
        ];
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function captain(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /** Total anggota termasuk kapten */
    public function getTotalMembersAttribute(): int
    {
        return count($this->members ?? []) + 1;
    }
}
