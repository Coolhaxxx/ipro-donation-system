<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Donation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'donor_id',
        'campaign_id',
        'amount',
        'donation_type',
        'payment_method',
        'payment_status',
        'check_number',
        'check_photo',
        'bank_name',
        'account_number',
        'routing_number',
        'transaction_id',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'decimal:2',
    ];

    /**
     * Get the campaign that owns the donation.
     */
    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    /**
     * Get the donor that owns the donation.
     */
    public function donor(): BelongsTo
    {
        return $this->belongsTo(Donor::class);
    }

    /**
     * Get the payment transaction associated with the donation.
     */
    public function paymentTransaction(): HasOne
    {
        return $this->hasOne(PaymentTransaction::class);
    }

    /**
     * Scope a query to only include completed donations.
     */
    public function scopeCompleted($query)
    {
        return $query->where('payment_status', 'completed');
    }

    /**
     * Scope a query to only include pending donations.
     */
    public function scopePending($query)
    {
        return $query->where('payment_status', 'pending');
    }

    /**
     * Scope a query to filter by donation type.
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('donation_type', $type);
    }

    /**
     * Scope a query to filter by payment method.
     */
    public function scopeByPaymentMethod($query, string $method)
    {
        return $query->where('payment_method', $method);
    }

    /**
     * Get formatted amount with currency symbol
     */
    public function getFormattedAmountAttribute(): string
    {
        return '$' . number_format($this->amount, 2);
    }

    /**
     * Get human-readable donation type
     */
    public function getDonationTypeNameAttribute(): string
    {
        return match($this->donation_type) {
            'zakat' => 'Zakat',
            'sadaqah' => 'Sadaqah',
            'general' => 'General Donation',
            default => ucfirst($this->donation_type),
        };
    }

    /**
     * Get human-readable payment method
     */
    public function getPaymentMethodNameAttribute(): string
    {
        return match($this->payment_method) {
            'cash' => 'Cash',
            'check' => 'Check',
            'online' => 'Online Payment',
            default => ucfirst($this->payment_method),
        };
    }
}
