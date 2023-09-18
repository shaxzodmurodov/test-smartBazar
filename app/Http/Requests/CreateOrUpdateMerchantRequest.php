<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class CreateOrUpdateMerchantRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'name' => ['required', 'string', 'max:255'],
            'status' => ['required'],
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function (Validator $validator) {
            if ($this->input('user_id') !== auth()->id()) {
                $validator->errors()->add('not_permitted' , trans('validation.custom.user_id.not_permitted'));
            }
        });
    }
}
