<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

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
            'role' => 'required|in:' . implode(",", ['USER', 'ADMIN']),
            'password' => 'required|min:6|confirmed',
            'device_type' => 'required|in:' . implode(",", ['android', 'ios']),
            'device_token' => 'required',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'first_name.required' => __('First Name field can not be empty'),
            'last_name.required' => __('Last Name field can not be empty'),
            'username.required' => __('UserName field can not be empty'),
            'password.required' => __('Password field can not be empty'),
            'password.min' => __('Password length must be at least 8 characters.'),
            'password.confirmed' => __('Password and confirm password is not matched'),
            'email.required' => __('Email field can not be empty'),
            'phone_code.required' => __('Phone Code field can not be empty'),
            'phone.required' => __('Phone field can not be empty'),
            'role.required' => __('Role can not be empty'),
            'email.email' => __('Invalid email address'),
            'device_type.required' => __('Device type is required'),
            'device_type.in' => __('Device type is invalid'),
            'device_token.required' => __('Device token is required'),
        ];
    }

    /**
     * @param Validator $validator
     * @throws ValidationException
     */
    public function failedValidation(Validator $validator)
    {
        if ($this->header('accept') == "application/json") {
            $errors = '';
            if ($validator->fails()) {
                $e = $validator->errors()->all();
                foreach ($e as $error) {
                    $errors .= $error . "\n";
                }
            }
            $json = [
                'success' => false,
                'message' => $errors,
                'data' => null
            ];
            $response = new JsonResponse($json, 422);

            throw (new ValidationException($validator, $response))->errorBag($this->errorBag)->redirectTo($this->getRedirectUrl());
        } else {
            throw (new ValidationException($validator))
                ->errorBag($this->errorBag)
                ->redirectTo($this->getRedirectUrl());
        }
    }
}
