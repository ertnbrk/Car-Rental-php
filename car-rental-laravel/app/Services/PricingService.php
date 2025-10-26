<?php

namespace App\Services;

use Carbon\Carbon;

/**
 * Service for handling pricing calculations for car rentals.
 */
class PricingService
{
    /**
     * Calculate the number of rental days.
     *
     * @param Carbon|string $startDate
     * @param Carbon|string $endDate
     * @return int Minimum 1 day
     */
    public function rentalDays($startDate, $endDate): int
    {
        $start = $startDate instanceof Carbon ? $startDate : Carbon::parse($startDate);
        $end = $endDate instanceof Carbon ? $endDate : Carbon::parse($endDate);

        return max(1, $start->diffInDays($end));
    }

    /**
     * Compute total pricing with discount.
     *
     * @param float $dailyPrice Daily rental price
     * @param int $days Number of rental days
     * @param int $discountPercent Discount percentage (0-100)
     * @param string $currency Currency code (USD, EUR, TRY, etc.)
     * @return object Object containing subtotal, discount, and total
     */
    public function computeTotals(
        float $dailyPrice,
        int $days,
        int $discountPercent = 0,
        string $currency = 'USD'
    ): object {
        $subtotal = $dailyPrice * $days;
        $discountAmount = round($subtotal * ($discountPercent / 100), 2);
        $total = max(0, $subtotal - $discountAmount);

        return (object) [
            'currency' => $currency,
            'daily_price' => round($dailyPrice, 2),
            'days' => $days,
            'subtotal' => round($subtotal, 2),
            'discount_percent' => $discountPercent,
            'discount_amount' => $discountAmount,
            'total' => $total,
        ];
    }

    /**
     * Calculate price with tax.
     *
     * @param float $price Base price
     * @param float $taxPercent Tax percentage (e.g., 18 for 18% VAT)
     * @return object Object containing base, tax, and total
     */
    public function calculateWithTax(float $price, float $taxPercent = 18): object
    {
        $taxAmount = round($price * ($taxPercent / 100), 2);
        $total = $price + $taxAmount;

        return (object) [
            'base_price' => round($price, 2),
            'tax_percent' => $taxPercent,
            'tax_amount' => $taxAmount,
            'total' => round($total, 2),
        ];
    }

    /**
     * Format price with currency symbol.
     *
     * @param float $amount Amount to format
     * @param string $currency Currency code
     * @return string Formatted price string
     */
    public function formatPrice(float $amount, string $currency = 'USD'): string
    {
        $symbols = [
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            'TRY' => '₺',
        ];

        $symbol = $symbols[$currency] ?? $currency . ' ';
        return $symbol . number_format($amount, 2);
    }

    /**
     * Calculate early booking discount.
     *
     * @param Carbon|string $bookingDate Date of booking
     * @param Carbon|string $startDate Start date of rental
     * @param int $daysAhead Days in advance for discount (e.g., 30)
     * @param int $discountPercent Discount percentage to apply
     * @return int Discount percentage if eligible, 0 otherwise
     */
    public function earlyBookingDiscount(
        $bookingDate,
        $startDate,
        int $daysAhead = 30,
        int $discountPercent = 10
    ): int {
        $booking = $bookingDate instanceof Carbon ? $bookingDate : Carbon::parse($bookingDate);
        $start = $startDate instanceof Carbon ? $startDate : Carbon::parse($startDate);

        $daysInAdvance = $booking->diffInDays($start);

        return $daysInAdvance >= $daysAhead ? $discountPercent : 0;
    }

    /**
     * Calculate long-term rental discount.
     *
     * @param int $days Number of rental days
     * @return int Discount percentage based on duration
     */
    public function longTermDiscount(int $days): int
    {
        if ($days >= 30) {
            return 20; // 20% for monthly rentals
        } elseif ($days >= 14) {
            return 15; // 15% for 2+ weeks
        } elseif ($days >= 7) {
            return 10; // 10% for weekly rentals
        }

        return 0;
    }
}
