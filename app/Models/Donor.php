<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Donor extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'street_address',
        'city',
        'state',
        'zip',
    ];

    /**
     * Get the donations for the donor.
     */
    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
    }

    /**
     * Get donor by email or phone
     */
    public static function findByEmailOrPhone(string $email = null, string $phone = null)
    {
        return static::where('email', $email)
            ->orWhere('phone', $phone)
            ->first();
    }

    /**
     * Get total donation amount for this donor
     */
    public function getTotalDonationsAttribute(): float
    {
        return $this->donations()
            ->where('payment_status', 'completed')
            ->sum('amount');
    }

    /**
     * Get donation count for this donor
     */
    public function getDonationCountAttribute(): int
    {
        return $this->donations()
            ->where('payment_status', 'completed')
            ->count();
    }
}
