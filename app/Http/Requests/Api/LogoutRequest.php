<?php

namespace App\Http\Requests\Api;


use App\Http\Requests\Boilerplate\BaseValidation;

class LogoutRequest extends BaseValidation {
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
            'device_type' => 'required|in:' . implode(",", ['android', 'ios']),
            'device_token' => 'required'
        ];
    }

    /**
     * @return array
     */
    public function messages(): array {
        return [
            'device_type.required' => __('Device type is required'),
            'device_type.in' => __('Device type is invalid'),
            'device_token.required' => __('Device token is required'),
        ];
    }
}
