<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateShopRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'merchant_id' => ['required', 'exists:merchants,id'],
            'address' => ['required', 'max:255'],
            'schedule' => ['required', 'max:255'],
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
        ];
    }
}
