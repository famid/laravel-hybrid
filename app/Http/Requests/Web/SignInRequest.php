<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\EmailOrUsernameValidation;

class SignInRequest extends FormRequest
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
            'email' => ['required', 'string', 'max:255', new EmailOrUsernameValidation()],
            'password' => 'required',
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
            'password.required' => __('Password field can not be empty'),
        ];
    }
}
