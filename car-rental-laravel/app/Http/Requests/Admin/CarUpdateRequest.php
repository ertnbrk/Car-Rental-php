<?php

namespace App\Http\Requests\Admin;

class CarUpdateRequest extends CarStoreRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = parent::rules();

        // Make image optional for updates
        $rules['image'] = ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'];

        return $rules;
    }
}
