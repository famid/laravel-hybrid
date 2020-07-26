<?php

namespace App\Http\Requests\Web;

use App\Rules\EmailOrUsernameValidation;
use Illuminate\Foundation\Http\FormRequest;

class SignInRequest extends FormRequest
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
            'email' => ['required', 'string', 'max:255', new EmailOrUsernameValidation()],
            'password' => 'required|min:8',
        ];
    }
    /**
     * @return array
     */
    public function messages()
    {
        return [
            'password.required' => __('Password field can not be empty'),
            'password.min' => __('Password length must be at least 8 characters.'),
            'password.confirmed' => __('Password and confirm password is not matched'),
            'email.required' => __('Email field can not be empty'),
            'email.string' => __('Email field can not be empty'),
            'email.max:255' => __('Email field can not be empty')
        ];
    }
}
