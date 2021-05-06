<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class EmailOrUsernameValidation implements Rule {

    /**
     * Custom message for both email and username validation
     *
     * @var string
     */
    private $message;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool {
        return (filter_var($value, FILTER_VALIDATE_EMAIL)) ?
            $this->emailValidation($value) :
            $this->usernameValidation($value);
    }

    /**
     * @param string $value
     * @return bool
     */
    private function emailValidation(string $value): bool {
        $userEmailExist = User::where('email', $value)->first();
        $this->message = is_null($userEmailExist) ? __("The email does not exists!") : '';

        return !is_null($userEmailExist);
    }

    /**
     * @param string $value
     * @return bool
     */
    private function usernameValidation(string $value): bool {
        // is not a valid email, so it should be username
        $userNameExist = User::where('username', $value)->first();
        $this->message = is_null($userNameExist) ? __("The email or username does not exists!") : '';

        return !is_null($userNameExist);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string {
        return $this->message;
    }
}
