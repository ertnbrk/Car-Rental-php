<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CarStoreRequest;
use App\Http\Requests\Admin\CarUpdateRequest;
use App\Models\Car;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CarController extends Controller
{
    /**
     * Display a listing of cars.
     */
    public function index(): View
    {
        $cars = Car::withTrashed()
            ->with('orders')
            ->latest()
            ->paginate(20);

        return view('admin.cars.index', compact('cars'));
    }

    /**
     * Show the form for creating a new car.
     */
    public function create(): View
    {
        return view('admin.cars.create');
    }

    /**
     * Store a newly created car.
     */
    public function store(CarStoreRequest $request): RedirectResponse
    {
        try {
            $data = $request->validated();

            // Handle image upload
            if ($request->hasFile('image')) {
                $data['image_path'] = $request->file('image')->store('cars', 'public');
            }

            $car = Car::create($data);

            Log::info('Car created', [
                'car_id' => $car->id,
                'admin_id' => auth()->id(),
            ]);

            return redirect()
                ->route('admin.cars.index')
                ->with('success', __('Car created successfully.'));

        } catch (\Exception $e) {
            Log::error('Failed to create car', [
                'error' => $e->getMessage(),
                'admin_id' => auth()->id(),
            ]);

            return back()
                ->withErrors(['error' => __('Failed to create car.')])
                ->withInput();
        }
    }

    /**
     * Display the specified car.
     */
    public function show(Car $car): View
    {
        $car->load(['orders' => function ($query) {
            $query->latest()->take(10);
        }]);

        return view('admin.cars.show', compact('car'));
    }

    /**
     * Show the form for editing the specified car.
     */
    public function edit(Car $car): View
    {
        return view('admin.cars.edit', compact('car'));
    }

    /**
     * Update the specified car.
     */
    public function update(CarUpdateRequest $request, Car $car): RedirectResponse
    {
        try {
            $data = $request->validated();

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image
                if ($car->image_path) {
                    Storage::disk('public')->delete($car->image_path);
                }

                $data['image_path'] = $request->file('image')->store('cars', 'public');
            }

            $car->update($data);

            Log::info('Car updated', [
                'car_id' => $car->id,
                'admin_id' => auth()->id(),
            ]);

            return redirect()
                ->route('admin.cars.show', $car)
                ->with('success', __('Car updated successfully.'));

        } catch (\Exception $e) {
            Log::error('Failed to update car', [
                'error' => $e->getMessage(),
                'car_id' => $car->id,
                'admin_id' => auth()->id(),
            ]);

            return back()
                ->withErrors(['error' => __('Failed to update car.')])
                ->withInput();
        }
    }

    /**
     * Remove the specified car (soft delete).
     */
    public function destroy(Car $car): RedirectResponse
    {
        try {
            // Check if car has active orders
            if ($car->orders()->active()->exists()) {
                return back()->withErrors([
                    'error' => __('Cannot delete car with active orders.')
                ]);
            }

            $car->delete();

            Log::info('Car deleted', [
                'car_id' => $car->id,
                'admin_id' => auth()->id(),
            ]);

            return redirect()
                ->route('admin.cars.index')
                ->with('success', __('Car deleted successfully.'));

        } catch (\Exception $e) {
            Log::error('Failed to delete car', [
                'error' => $e->getMessage(),
                'car_id' => $car->id,
                'admin_id' => auth()->id(),
            ]);

            return back()->withErrors(['error' => __('Failed to delete car.')]);
        }
    }

    /**
     * Restore a soft-deleted car.
     */
    public function restore(int $id): RedirectResponse
    {
        try {
            $car = Car::withTrashed()->findOrFail($id);
            $car->restore();

            Log::info('Car restored', [
                'car_id' => $car->id,
                'admin_id' => auth()->id(),
            ]);

            return redirect()
                ->route('admin.cars.show', $car)
                ->with('success', __('Car restored successfully.'));

        } catch (\Exception $e) {
            Log::error('Failed to restore car', [
                'error' => $e->getMessage(),
                'car_id' => $id,
                'admin_id' => auth()->id(),
            ]);

            return back()->withErrors(['error' => __('Failed to restore car.')]);
        }
    }
}
