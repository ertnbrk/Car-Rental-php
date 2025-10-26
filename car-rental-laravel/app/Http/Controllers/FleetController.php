<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Services\Fx\FxService;
use App\Services\Offers\OfferService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FleetController extends Controller
{
    public function __construct(
        private FxService $fxService,
        private OfferService $offerService
    ) {}

    /**
     * Display the fleet listing page.
     */
    public function index(Request $request): View
    {
        // Get query parameters for filtering
        $filters = $request->only(['transmission', 'capacity', 'min_price', 'max_price', 'search']);

        // Build query
        $query = Car::available();

        // Apply filters
        if (!empty($filters['transmission'])) {
            $query->where('transmission', $filters['transmission']);
        }

        if (!empty($filters['capacity'])) {
            $query->where('capacity', '>=', $filters['capacity']);
        }

        if (!empty($filters['min_price'])) {
            $query->where('daily_price', '>=', $filters['min_price']);
        }

        if (!empty($filters['max_price'])) {
            $query->where('daily_price', '<=', $filters['max_price']);
        }

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('features', 'like', '%' . $filters['search'] . '%');
            });
        }

        // Paginate results
        $cars = $query->orderBy('name')->paginate(12)->withQueryString();

        // Get FX rates
        $fxRates = $this->fxService->getAllLatestRates();

        // Get user's discount if logged in
        $userDiscount = 0;
        if (auth()->check()) {
            $userDiscount = $this->offerService->discountPercentForUser(auth()->user());
        }

        return view('fleet.index', compact('cars', 'fxRates', 'userDiscount', 'filters'));
    }

    /**
     * Show a specific car's details.
     */
    public function show(Car $car): View
    {
        // Get FX rates
        $fxRates = $this->fxService->getAllLatestRates();

        // Get user's discount if logged in
        $userDiscount = 0;
        if (auth()->check()) {
            $userDiscount = $this->offerService->discountPercentForUser(auth()->user());
        }

        // Get similar cars
        $similarCars = Car::available()
            ->where('id', '!=', $car->id)
            ->where('capacity', $car->capacity)
            ->take(4)
            ->get();

        return view('fleet.show', compact('car', 'fxRates', 'userDiscount', 'similarCars'));
    }
}
