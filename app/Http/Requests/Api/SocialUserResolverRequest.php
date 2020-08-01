<?php


namespace App\Http\Requests\Api;


use App\Http\Requests\Boilerplate\BaseValidation;

class SocialUserResolverRequest extends BaseValidation {

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
    public function rules() {
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

}
