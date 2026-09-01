<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

#[Fillable([
    'user_id', 'event_id', 'certificate_type', 'certificate_number',
    'certificate_path', 'issued_date', 'status', 'issued_by', 'description'
])]
class Certificate extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'issued_date' => 'date',
        ];
    }

    /**
     * User who owns this certificate
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Event this certificate is for
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Admin who issued this certificate
     */
    public function issuer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'issued_by');
    }

    /**
     * Generate unique certificate number
     */
    public static function generateCertificateNumber(): string
    {
        $year = Carbon::now()->year;
        $count = self::whereYear('created_at', $year)->count() + 1;
        return 'CERT-' . $year . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Get full certificate URL
     */
    public function getCertificateUrlAttribute(): ?string
    {
        return $this->certificate_path ? asset('storage/' . $this->certificate_path) : null;
    }

    /**
     * Check if certificate is issued
     */
    public function isIssued(): bool
    {
        return $this->status === 'issued';
    }

    /**
     * Check if certificate is revoked
     */
    public function isRevoked(): bool
    {
        return $this->status === 'revoked';
    }

    /**
     * Get formatted certificate type
     */
    public function getFormattedTypeAttribute(): string
    {
        return ucfirst(str_replace('_', ' ', $this->certificate_type));
    }

    /**
     * Scope for issued certificates
     */
    public function scopeIssued($query)
    {
        return $query->where('status', 'issued');
    }

    /**
     * Boot method to generate certificate number
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($certificate) {
            if (!$certificate->certificate_number) {
                $certificate->certificate_number = self::generateCertificateNumber();
            }
        });
    }
}
