<?php


namespace App\Http\Requests\Api;


use App\Http\Requests\Boilerplate\BaseValidation;

class SocialUserResolverRequest extends BaseValidation {

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
            'grant_type' => 'required',
            'client_id' => 'required',
            'client_secret' => 'required',
            'provider' => 'required',
            'social_token' => 'required',
            'device_type' => 'required|in:' . implode(",", ['android', 'ios']),
            'device_token' => 'required',
        ];
    }

    public function messages(): array {
        return [
            'grant_typ.required' => __('grant_typ can not be empty'),
            'client_id.required' => __('client_id field can not be empty'),
            'client_secret.required' => __('client_secret field can not be empty'),
            'provider.required' => __('provider field can not be empty'),
            'social_token.required' => __('social_token field can not be empty'),
            'device_type.required' => __('device_type field can not be empty'),
            'device_token.required' => __('device_token field can not be empty'),

        ];
    }

}
