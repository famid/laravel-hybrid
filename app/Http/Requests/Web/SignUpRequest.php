<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class SignUpRequest extends FormRequest
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
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'phone_code' => 'required',
            'phone' => 'required|unique:users,phone',
            'password' => 'required|min:6|confirmed',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'first_name.required' => __('first name field can not be empty'),
            'last_name.required' => __('Last name field can not be empty'),
            'username.required' => __('Username field can not be empty'),
            'password.required' => __('Password field can not be empty'),
            'password.min' => __('Password length must be at least 8 characters.'),
            'password.confirmed' => __('Password and confirm password is not matched'),
            'email.required' => __('Email field can not be empty'),
            'phone_code.required' => __('Phone Code field can not be empty'),
            'phone.required' => __('Phone field can not be empty'),
            'role.required' => __('Role can not be empty'),
            'email.email' => __('Invalid email address'),
        ];
    }
}
