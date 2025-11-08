<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Campaign extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'logo',
        'cover_image',
        'title',
        'subtitle',
        'goal_text',
        'impact_text',
        'goal_amount',
        'is_active',
        'is_default',
        'start_date',
        'end_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'goal_amount' => 'decimal:2',
        'is_active' => 'boolean',
        'is_default' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Get the donations for the campaign.
     */
    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
    }

    /**
     * Get total donations for this campaign
     */
    public function getTotalDonationsAttribute(): float
    {
        return $this->donations()
            ->where('payment_status', 'completed')
            ->sum('amount');
    }

    /**
     * Get donation count for this campaign
     */
    public function getDonationCountAttribute(): int
    {
        return $this->donations()
            ->where('payment_status', 'completed')
            ->count();
    }

    /**
     * Get progress percentage
     */
    public function getProgressPercentageAttribute(): float
    {
        if (!$this->goal_amount || $this->goal_amount == 0) {
            return 0;
        }
        
        $percentage = ($this->total_donations / $this->goal_amount) * 100;
        return min($percentage, 100); // Cap at 100%
    }

    /**
     * Get the default active campaign
     */
    public static function getDefault()
    {
        return static::where('is_default', true)
            ->where('is_active', true)
            ->first();
    }

    /**
     * Scope to get only active campaigns
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Generate slug from name
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($campaign) {
            if (!$campaign->slug) {
                $campaign->slug = Str::slug($campaign->name);
            }
        });

        static::updating(function ($campaign) {
            if ($campaign->isDirty('name') && !$campaign->isDirty('slug')) {
                $campaign->slug = Str::slug($campaign->name);
            }
        });
    }
}
