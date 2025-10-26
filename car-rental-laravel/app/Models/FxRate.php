<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FxRate extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'currency_code',
        'rate',
        'base_currency',
        'rate_date',
        'source',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'rate' => 'decimal:6',
        'rate_date' => 'date',
    ];

    /**
     * Scope to get latest rates.
     */
    public function scopeLatest($query)
    {
        return $query->where('rate_date', function ($q) {
            $q->selectRaw('MAX(rate_date)')
                ->from('fx_rates')
                ->whereColumn('currency_code', 'fx_rates.currency_code');
        });
    }

    /**
     * Scope to get rate for specific currency.
     */
    public function scopeForCurrency($query, string $currencyCode)
    {
        return $query->where('currency_code', strtoupper($currencyCode));
    }

    /**
     * Scope to get rate for specific date.
     */
    public function scopeForDate($query, $date)
    {
        return $query->where('rate_date', $date);
    }

    /**
     * Get rate from specific source.
     */
    public function scopeFromSource($query, string $source)
    {
        return $query->where('source', $source);
    }

    /**
     * Get the latest rate for a currency.
     */
    public static function getLatestRate(string $currencyCode, string $source = 'TCMB'): ?float
    {
        $rate = static::forCurrency($currencyCode)
            ->fromSource($source)
            ->latest('rate_date')
            ->first();

        return $rate ? (float) $rate->rate : null;
    }

    /**
     * Convert amount from one currency to another.
     */
    public static function convert(float $amount, string $fromCurrency, string $toCurrency): ?float
    {
        if ($fromCurrency === $toCurrency) {
            return $amount;
        }

        $fromRate = static::getLatestRate($fromCurrency);
        $toRate = static::getLatestRate($toCurrency);

        if (!$fromRate || !$toRate) {
            return null;
        }

        // Convert to base currency (TRY), then to target currency
        $amountInBase = $amount * $fromRate;
        return $amountInBase / $toRate;
    }
}
