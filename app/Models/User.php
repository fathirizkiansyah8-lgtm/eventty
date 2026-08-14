<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

#[Fillable(['name', 'email', 'password', 'phone', 'profile_photo_path', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationships

    /**
     * Get events organized by this user
     */
    public function organizedEvents()
    {
        return $this->hasMany(Event::class, 'organizer_id');
    }

    /**
     * Get registrations for this user
     */
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    /**
     * Get attendance records for this user
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Get certificates for this user
     */
    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    /**
     * Get notifications for this user
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * Get events where user is registered
     */
    public function registeredEvents()
    {
        return $this->belongsToMany(Event::class, 'registrations')
            ->withPivot('id', 'registration_number', 'payment_status', 'status', 'registration_date')
            ->withTimestamps();
    }
}
