<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentTransaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'donation_id',
        'stripe_payment_intent_id',
        'stripe_charge_id',
        'amount',
        'status',
        'payment_method_details',
        'receipt_url',
        'error_message',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'payment_method_details' => 'array',
    ];

    /**
     * Get the donation that owns the payment transaction.
     */
    public function donation(): BelongsTo
    {
        return $this->belongsTo(Donation::class);
    }

    /**
     * Scope a query to only include successful transactions.
     */
    public function scopeSuccessful($query)
    {
        return $query->where('status', 'succeeded');
    }

    /**
     * Scope a query to only include failed transactions.
     */
    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    /**
     * Check if transaction was successful
     */
    public function isSuccessful(): bool
    {
        return $this->status === 'succeeded';
    }

    /**
     * Check if transaction failed
     */
    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }
}
