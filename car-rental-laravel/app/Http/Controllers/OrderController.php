<?php

namespace App\Http\Controllers;

use App\Http\Requests\GuestOrderStoreRequest;
use App\Models\Car;
use App\Models\Order;
use App\Models\User;
use App\Services\Offers\OfferService;
use App\Services\PricingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function __construct(
        private PricingService $pricingService,
        private OfferService $offerService
    ) {}

    /**
     * Display the user's orders.
     */
    public function index(): View
    {
        $orders = auth()->user()
            ->orders()
            ->with('car')
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new order.
     */
    public function create(): View
    {
        $carId = request()->integer('car_id');
        $car = null;

        if ($carId) {
            $car = Car::findOrFail($carId);

            if (!$car->isAvailable()) {
                return redirect()
                    ->route('fleet.index')
                    ->withErrors(['error' => __('Selected car is not available.')]);
            }
        }

        // Get user discount if authenticated
        $userDiscount = 0;
        if (auth()->check()) {
            $userDiscount = $this->offerService->discountPercentForUser(auth()->user());
        }

        return view('orders.create', compact('car', 'userDiscount'));
    }

    /**
     * Store a new order with transaction (supports both guest and authenticated users).
     */
    public function store(GuestOrderStoreRequest $request): RedirectResponse
    {
        $user = $request->user();

        try {
            $order = DB::transaction(function () use ($request, $user) {
                // Lock the car row to prevent race conditions
                $car = Car::lockForUpdate()->findOrFail($request->integer('car_id'));

                // Verify car is available
                if (!$car->isAvailable()) {
                    throw new \Exception(__('Selected car is not available.'));
                }

                // Calculate rental details
                $days = $this->pricingService->rentalDays(
                    $request->date('start_date'),
                    $request->date('end_date')
                );

                // Get discount for user (only for authenticated users)
                $discountPercent = 0;
                if ($user) {
                    $discountPercent = $this->offerService->discountPercentForUser($user);
                }

                // Calculate totals
                $totals = $this->pricingService->computeTotals(
                    $car->daily_price,
                    $days,
                    $discountPercent,
                    'USD'
                );

                // Prepare order data
                $orderData = [
                    'car_id' => $car->id,
                    'pickup_location' => $request->string('pickup_location')->value(),
                    'return_location' => $request->string('return_location')->value(),
                    'start_date' => $request->date('start_date'),
                    'end_date' => $request->date('end_date'),
                    'daily_price' => $car->daily_price,
                    'currency' => $totals->currency,
                    'discount_percent' => $discountPercent,
                    'total_price' => $totals->total,
                    'status' => 'pending',
                    'notes' => $request->string('notes')->value(),
                ];

                // Add user information
                if ($user) {
                    // Authenticated user
                    $orderData['user_id'] = $user->id;
                    $orderData['customer_name'] = $user->name;
                    $orderData['customer_phone'] = $user->phone;
                } else {
                    // Guest user - create a guest user account or store guest info
                    $email = $request->string('customer_email')->value();

                    // Check if user exists by email
                    $existingUser = User::where('email', $email)->first();

                    if ($existingUser) {
                        // Use existing user
                        $orderData['user_id'] = $existingUser->id;
                    } else {
                        // Create a guest user
                        $guestUser = User::create([
                            'name' => $request->string('customer_name')->value(),
                            'email' => $email,
                            'password' => bcrypt(str()->random(16)), // Random password
                            'phone' => $request->string('customer_phone')->value(),
                            'role' => 'user',
                        ]);
                        $orderData['user_id'] = $guestUser->id;
                    }

                    $orderData['customer_name'] = $request->string('customer_name')->value();
                    $orderData['customer_phone'] = $request->string('customer_phone')->value();
                }

                // Create order
                $order = Order::create($orderData);

                // Decrement car stock
                if (!$car->decrementStock()) {
                    throw new \Exception(__('Failed to update car availability.'));
                }

                Log::info('Order created successfully', [
                    'order_id' => $order->id,
                    'user_id' => $order->user_id,
                    'car_id' => $car->id,
                    'total_price' => $totals->total,
                    'is_guest' => !$user,
                ]);

                return $order;
            });

            // TODO: Dispatch OrderCreated event for email notification
            // event(new OrderCreated($order));

            return redirect()
                ->route('orders.show', $order)
                ->with('success', __('Order created successfully! We will contact you shortly.'));

        } catch (\Exception $e) {
            Log::error('Failed to create order', [
                'error' => $e->getMessage(),
                'user_id' => $user->id,
            ]);

            return back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Display a specific order.
     */
    public function show(Order $order): View
    {
        // Ensure user can only view their own orders
        if ($order->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $order->load('car', 'user');

        return view('orders.show', compact('order'));
    }

    /**
     * Cancel an order.
     */
    public function cancel(Order $order): RedirectResponse
    {
        // Ensure user can only cancel their own orders
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if (!$order->canBeCancelled()) {
            return back()->withErrors(['error' => __('This order cannot be cancelled.')]);
        }

        try {
            DB::transaction(function () use ($order) {
                // Return stock to car
                $order->car->incrementStock();

                // Mark order as cancelled
                $order->markAsCancelled();

                Log::info('Order cancelled', [
                    'order_id' => $order->id,
                    'user_id' => auth()->id(),
                ]);
            });

            return redirect()
                ->route('orders.index')
                ->with('success', __('Order cancelled successfully.'));

        } catch (\Exception $e) {
            Log::error('Failed to cancel order', [
                'error' => $e->getMessage(),
                'order_id' => $order->id,
            ]);

            return back()->withErrors(['error' => __('Failed to cancel order.')]);
        }
    }
}
