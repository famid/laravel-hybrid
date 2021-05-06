<?php

namespace App\Http\Requests\Api;


use App\Http\Requests\Boilerplate\BaseValidation;

class SignInRequest extends BaseValidation {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array {
        return [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8',
            'device_type' => 'required|in:' . implode(",", ['android', 'ios']),
            'device_token' => 'required',
        ];
    }
    /**
     * @return array
     */
    public function messages(): array {
        return [
            'email.required' => __('Email field can not be empty'),
            'email.email' => __('Invalid email address'),
            'password.required' => __('Password field can not be empty'),
            'password.min' => __('Password length must be at least 8 characters.'),
            'password.confirmed' => __('Password and confirm password is not matched'),
            'device_type.required' => __('Device type is required'),
            'device_type.in' => __('Device type is invalid'),
            'device_token.required' => __('Device token is required'),
        ];
    }
}
