<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // User must be authenticated to create an order
        return $this->user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'car_id' => ['required', 'exists:cars,id'],
            'pickup_location' => ['required', 'string', 'max:120'],
            'return_location' => ['required', 'string', 'max:120'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'notes' => ['nullable', 'string', 'max:500'],
        ];
    }

    /**
     * Get custom attribute names for validator errors.
     */
    public function attributes(): array
    {
        return [
            'car_id' => __('car'),
            'pickup_location' => __('pickup location'),
            'return_location' => __('return location'),
            'start_date' => __('start date'),
            'end_date' => __('end date'),
            'notes' => __('notes'),
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'car_id.required' => __('Please select a car.'),
            'car_id.exists' => __('The selected car is not available.'),
            'start_date.after_or_equal' => __('Start date must be today or later.'),
            'end_date.after' => __('End date must be after start date.'),
        ];
    }
}
