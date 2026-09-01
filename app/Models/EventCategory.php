<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'description', 'color', 'icon'])]
class EventCategory extends Model
{
    use HasFactory;

    /**
     * Events in this category
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'category_id');
    }

    /**
     * Get events count for this category
     */
    public function getEventsCountAttribute(): int
    {
        return $this->events()->count();
    }

    /**
     * Get active events count for this category
     */
    public function getActiveEventsCountAttribute(): int
    {
        return $this->events()->whereIn('status', ['open', 'closed'])->count();
    }
}
