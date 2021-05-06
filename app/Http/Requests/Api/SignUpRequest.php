<?php


namespace App\Http\Requests\Api;


use App\Http\Requests\Boilerplate\BaseValidation;

class SignUpRequest extends BaseValidation {

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
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'phone_code' => 'required',
            'phone' => 'required|numeric|digits:10|unique:users,phone',
            'role' => 'required|in:' . implode(",", ['USER', 'ADMIN']),
            'password' => 'required|min:6|confirmed',
            'device_type' => 'required|in:' . implode(",", ['android', 'ios']),
            'device_token' => 'required',
        ];
    }

    /**
     * @return array
     */
    public function messages(): array {
        return [
            'first_name.required' => __('First Name field can not be empty'),
            'last_name.required' => __('Last Name field can not be empty'),
            'username.required' => __('UserName field can not be empty'),
            'email.required' => __('Email field can not be empty'),
            'email.email' => __('Invalid email address'),
            'phone_code.required' => __('Phone Code field can not be empty'),
            'phone.required' => __('Phone field can not be empty'),
            'phone.digits' => __('The phone will have only 10 digits'),
            'password.required' => __('Password field can not be empty'),
            'password.min' => __('Password length must be at least 8 characters.'),
            'password.confirmed' => __('Password and confirm password is not matched'),
            'role.required' => __('Role can not be empty'),
            'device_type.required' => __('Device type is required'),
            'device_type.in' => __('Device type is invalid'),
            'device_token.required' => __('Device token is required'),
        ];
    }
}
