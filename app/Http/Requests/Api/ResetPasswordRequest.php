<?php

namespace App\Http\Requests\Api;


use App\Http\Requests\Boilerplate\BaseValidation;
use App\Rules\EmailOrUsernameValidation;

class ResetPasswordRequest extends BaseValidation
{
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
            'email' =>  ['required', 'string', 'max:255', new EmailOrUsernameValidation()],
            'reset_password_code' => 'required',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|same:new_password'
        ];
    }

    /**
     * @return array
     */
    public function messages(): array {
        return [
            'email.required' => __('Email field can not be empty'),
            'email.string' => __('Email field can not be empty'),
            'email.max:255' => __('Email field can not be empty'),
            'reset_password_code.required' => __('Reset password code can not be empty'),
            'new_password.required' => __('New password can not be empty'),
            'new_password.min' => __('New password must be al least 8 characters'),
            'confirm_password.required' => __('Confirm password can not be empty'),
            'confirm_password.same' => __('New password and confirm password are not same'),
        ];
    }
}
