<?php


namespace App\Http\Requests\Boilerplate;


use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class BaseValidation extends FormRequest {

    /**
     * @param Validator $validator
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator) {
        $errors = '';
        if ($validator->fails()) {
            $e = $validator->errors()->all();
            foreach ($e as $error) {
                $errors = $errors . $error . "\n";
            }
        }
        $json = [
            'success' => false,
            'message' => $errors,
            'data' => []
        ];
        $response = new JsonResponse($json, 200);

        throw (new ValidationException($validator, $response))
            ->errorBag($this->errorBag)->redirectTo($this->getRedirectUrl());
    }
}
