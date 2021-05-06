<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class VerifyEmailRequest extends FormRequest
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
            'email' => 'required|email|exists:users,email',
            'email_verification_code' => 'required',
        ];
    }


    /**
     * @return array
     */
    public function messages(): array {
        return [
            'email_verification_code.required' => __('verification_code can not be empty'),
            'email.required' => __('Email field can not be empty'),
            'email.email' => __('Invalid email address'),
        ];
    }
}
