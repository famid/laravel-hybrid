<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseValidation;

class ForgetPasswordRequest extends BaseValidation
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

            'email' => 'required|email|exists:users,email',
        ];
    }

    public function messages()
    {
        return [

            'email.required' => __('Email field can not be empty'),
        ];
    }
}
