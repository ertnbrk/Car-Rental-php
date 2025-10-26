<?php

namespace App\Services\Offers;

use App\Models\Offer;
use App\Models\User;
use Illuminate\Support\Facades\Log;

/**
 * Service for handling offers and discount logic.
 */
class OfferService
{
    /**
     * Get the active offer.
     *
     * @return Offer|null Active offer or null if none found
     */
    public function getActiveOffer(): ?Offer
    {
        return Offer::active()->first();
    }

    /**
     * Calculate discount percentage for a user based on their order count.
     *
     * @param User $user User to calculate discount for
     * @return int Discount percentage (0-100)
     */
    public function discountPercentForUser(User $user): int
    {
        $offer = $this->getActiveOffer();

        if (!$offer) {
            return 0;
        }

        $orderCount = $user->orders()->count();

        // Check if user qualifies based on nth order rule
        if ($offer->nth_order > 0 && $orderCount > 0 && $orderCount % $offer->nth_order === 0) {
            Log::info('User qualifies for discount offer', [
                'user_id' => $user->id,
                'order_count' => $orderCount,
                'discount_percent' => $offer->discount_percent,
            ]);

            return $offer->discount_percent;
        }

        return 0;
    }

    /**
     * Check if user qualifies for any active offer.
     *
     * @param User $user User to check
     * @return bool True if user qualifies
     */
    public function userQualifies(User $user): bool
    {
        return $this->discountPercentForUser($user) > 0;
    }

    /**
     * Get offer details for a user.
     *
     * @param User $user User to get offer for
     * @return object|null Object with offer details or null
     */
    public function getOfferForUser(User $user): ?object
    {
        $discountPercent = $this->discountPercentForUser($user);

        if ($discountPercent === 0) {
            return null;
        }

        $offer = $this->getActiveOffer();

        return (object) [
            'title' => $offer->title,
            'description' => $offer->description,
            'discount_percent' => $discountPercent,
            'order_count' => $user->orders()->count(),
            'nth_order' => $offer->nth_order,
        ];
    }

    /**
     * Calculate orders until next discount.
     *
     * @param User $user User to calculate for
     * @return int Number of orders until next discount, 0 if no active offer
     */
    public function ordersUntilNextDiscount(User $user): int
    {
        $offer = $this->getActiveOffer();

        if (!$offer || $offer->nth_order === 0) {
            return 0;
        }

        $orderCount = $user->orders()->count();
        $remainder = $orderCount % $offer->nth_order;

        return $remainder === 0 ? $offer->nth_order : $offer->nth_order - $remainder;
    }

    /**
     * Apply offer to price calculation.
     *
     * @param float $price Original price
     * @param int $discountPercent Discount percentage
     * @return object Object with original, discount, and final price
     */
    public function applyDiscount(float $price, int $discountPercent): object
    {
        $discountAmount = round($price * ($discountPercent / 100), 2);
        $finalPrice = max(0, $price - $discountAmount);

        return (object) [
            'original_price' => round($price, 2),
            'discount_percent' => $discountPercent,
            'discount_amount' => $discountAmount,
            'final_price' => $finalPrice,
        ];
    }

    /**
     * Check if offer is valid for given dates.
     *
     * @param Offer $offer Offer to check
     * @param string|null $startDate Start date to check
     * @param string|null $endDate End date to check
     * @return bool True if offer is valid for the dates
     */
    public function isValidForDates(Offer $offer, ?string $startDate = null, ?string $endDate = null): bool
    {
        if (!$offer->isValid()) {
            return false;
        }

        // If no dates provided, just check if offer is generally valid
        if (!$startDate || !$endDate) {
            return true;
        }

        $start = \Carbon\Carbon::parse($startDate);
        $end = \Carbon\Carbon::parse($endDate);

        // Check if offer valid_from/valid_until overlap with rental dates
        if ($offer->valid_from && $offer->valid_from->isAfter($end)) {
            return false;
        }

        if ($offer->valid_until && $offer->valid_until->isBefore($start)) {
            return false;
        }

        return true;
    }
}
