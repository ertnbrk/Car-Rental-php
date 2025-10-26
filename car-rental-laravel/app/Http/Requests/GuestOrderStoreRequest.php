<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuestOrderStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Guests can place orders
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'car_id' => ['required', 'exists:cars,id'],
            'pickup_location' => ['required', 'string', 'max:120'],
            'return_location' => ['required', 'string', 'max:120'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'notes' => ['nullable', 'string', 'max:500'],
        ];

        // If user is not logged in, require guest information
        if (!auth()->check()) {
            $rules['customer_name'] = ['required', 'string', 'max:100'];
            $rules['customer_email'] = ['required', 'email', 'max:100'];
            $rules['customer_phone'] = ['required', 'string', 'max:20'];
            $rules['customer_id_number'] = ['nullable', 'string', 'max:20']; // TC or ID number
        }

        return $rules;
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
            'customer_name' => __('full name'),
            'customer_email' => __('email'),
            'customer_phone' => __('phone number'),
            'customer_id_number' => __('ID number'),
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
            'customer_name.required' => __('Please enter your full name.'),
            'customer_email.required' => __('Please enter your email address.'),
            'customer_phone.required' => __('Please enter your phone number.'),
        ];
    }
}
