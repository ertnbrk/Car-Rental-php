<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\FleetController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group.
|
*/

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/fleet', [FleetController::class, 'index'])->name('fleet.index');
Route::get('/fleet/{car}', [FleetController::class, 'show'])->name('fleet.show');

Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/page/{page:slug}', [PageController::class, 'show'])->name('pages.show');

// Order routes (guests can create orders)
Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

// Authenticated order routes
Route::middleware('auth')->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
});

// Include auth routes (Laravel Breeze/Fortify)
require __DIR__ . '/auth.php';

// Include admin routes
require __DIR__ . '/admin.php';
