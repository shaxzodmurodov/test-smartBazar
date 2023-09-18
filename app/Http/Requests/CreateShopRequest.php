<?php

namespace App\Http\Requests;

use App\Models\Merchant;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class CreateShopRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'merchant_id' => ['required', 'exists:merchants,id'],
            'address'     => ['required', 'max:255'],
            'schedule'    => ['required', 'max:255'],
            'latitude'    => ['required', 'numeric'],
            'longitude'   => ['required', 'numeric'],
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function (Validator $validator) {
            $merchant_accepted = Merchant::query()
                ->where('id', $this->input('merchant_id'))
                ->where('user_id', auth()->id())
                ->exists();
            if (!$merchant_accepted) {
                $validator->errors()->add('merchant_not_available', trans('errors.merchant_not_available'));
            }
        });
    }
}
