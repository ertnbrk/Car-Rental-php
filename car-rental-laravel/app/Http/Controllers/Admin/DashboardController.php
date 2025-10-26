<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\ContactMessage;
use App\Models\Order;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index(): View
    {
        // Get statistics
        $stats = [
            'total_cars' => Car::count(),
            'available_cars' => Car::available()->count(),
            'total_orders' => Order::count(),
            'active_orders' => Order::active()->count(),
            'pending_orders' => Order::pending()->count(),
            'total_users' => User::where('role', 'user')->count(),
            'unread_messages' => ContactMessage::unread()->count(),
            'revenue_this_month' => Order::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->where('status', '!=', 'cancelled')
                ->sum('total_price'),
        ];

        // Get recent orders
        $recentOrders = Order::with(['user', 'car'])
            ->latest()
            ->take(10)
            ->get();

        // Get recent contact messages
        $recentMessages = ContactMessage::latest()
            ->take(5)
            ->get();

        // Get low stock cars
        $lowStockCars = Car::where('stock', '<=', 2)
            ->where('stock', '>', 0)
            ->where('is_active', true)
            ->get();

        // Get out of stock cars
        $outOfStockCars = Car::where('stock', 0)
            ->where('is_active', true)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentOrders',
            'recentMessages',
            'lowStockCars',
            'outOfStockCars'
        ));
    }
}
