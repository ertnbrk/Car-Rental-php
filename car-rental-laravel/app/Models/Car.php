<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'year',
        'image_path',
        'capacity',
        'doors',
        'luggage',
        'transmission',
        'features',
        'daily_price',
        'stock',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'daily_price' => 'decimal:2',
        'stock' => 'integer',
        'capacity' => 'integer',
        'doors' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Get all orders for this car.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Scope to get only available cars (in stock and active).
     */
    public function scopeAvailable($query)
    {
        return $query->where('stock', '>', 0)
            ->where('is_active', true);
    }

    /**
     * Scope to get active cars.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Check if car is available for booking.
     */
    public function isAvailable(): bool
    {
        return $this->stock > 0 && $this->is_active;
    }

    /**
     * Get formatted price with currency.
     */
    public function getFormattedPriceAttribute(): string
    {
        return '$' . number_format($this->daily_price, 2);
    }

    /**
     * Decrement stock when car is booked.
     */
    public function decrementStock(int $quantity = 1): bool
    {
        if ($this->stock >= $quantity) {
            return $this->decrement('stock', $quantity);
        }
        return false;
    }

    /**
     * Increment stock when booking is cancelled/returned.
     */
    public function incrementStock(int $quantity = 1): bool
    {
        return $this->increment('stock', $quantity);
    }
}
