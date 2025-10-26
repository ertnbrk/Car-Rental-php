<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CarStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Only admins can create cars (checked by middleware)
        return $this->user()?->isAdmin() ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'year' => ['required', 'digits:4', 'integer', 'min:2000', 'max:' . (date('Y') + 1)],
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'], // 2MB max
            'capacity' => ['required', 'integer', 'min:1', 'max:50'],
            'doors' => ['nullable', 'integer', 'min:2', 'max:6'],
            'luggage' => ['nullable', 'string', 'max:50'],
            'transmission' => ['required', 'in:automatic,manual'],
            'features' => ['nullable', 'string', 'max:1000'],
            'daily_price' => ['required', 'numeric', 'min:0', 'max:999999.99'],
            'stock' => ['required', 'integer', 'min:0', 'max:1000'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }

    /**
     * Get custom attribute names for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name' => __('car name'),
            'year' => __('year'),
            'image' => __('image'),
            'capacity' => __('passenger capacity'),
            'doors' => __('number of doors'),
            'luggage' => __('luggage capacity'),
            'transmission' => __('transmission type'),
            'features' => __('features'),
            'daily_price' => __('daily price'),
            'stock' => __('stock quantity'),
            'is_active' => __('active status'),
        ];
    }
}
