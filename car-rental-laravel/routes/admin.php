<?php

use App\Http\Controllers\Admin\CarController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| These routes are for the admin panel and require authentication and
| admin role. They are prefixed with /admin and use the 'admin' middleware.
|
*/

Route::middleware(['auth', 'can:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Cars Management
    Route::resource('cars', CarController::class);
    Route::post('cars/{id}/restore', [CarController::class, 'restore'])->name('cars.restore');

    // Orders Management
    // Route::resource('orders', OrderController::class)->only(['index', 'show', 'update']);

    // Offers Management
    // Route::resource('offers', OfferController::class);

    // Pages Management
    // Route::resource('pages', PageController::class);

    // Testimonials Management
    // Route::resource('testimonials', TestimonialController::class);

    // Team Management
    // Route::resource('team', TeamController::class);

    // Slider Management
    // Route::resource('sliders', SliderController::class);

    // Contact Messages
    // Route::get('contacts', [ContactMessageController::class, 'index'])->name('contacts.index');
    // Route::get('contacts/{contactMessage}', [ContactMessageController::class, 'show'])->name('contacts.show');
    // Route::post('contacts/{contactMessage}/read', [ContactMessageController::class, 'markAsRead'])->name('contacts.read');

    // Settings
    // Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    // Route::post('settings', [SettingsController::class, 'update'])->name('settings.update');
});
