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
        ];
    }
}
