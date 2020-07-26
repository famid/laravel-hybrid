<?php

namespace App\Http\Requests\Api;


use App\Http\Requests\Boilerplate\BaseValidation;

class VerifyEmailRequest extends BaseValidation {
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
            'email_verification_code' => 'required',
        ];
    }


    /**
     * @return array
     */
    public function messages()
    {
        return [
            'email_verification_code.required' => __('verification_code can not be empty'),
            //'email_verification_code.numeric' => __('Code field must be numeric'),
            'email.required' => __('Email field can not be empty'),
            'email.email' => __('Invalid email address'),
        ];
    }
}
