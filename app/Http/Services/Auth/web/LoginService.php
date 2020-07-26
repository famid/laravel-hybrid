<?php


namespace App\Http\Services\Auth\web;


use App\Http\Services\Auth\AuthenticationService;
use App\Http\Services\UserService;
use Exception;

class LoginService extends AuthenticationService {

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * LoginService constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService) {
        parent::__construct($userService);
    }
    /**
     * @param object $request
     * @return array
     */
    public function signIn(object $request) : array {
        try {
            return $this->signInProcess($request);
        } catch (Exception $e) {

            return $this->response()->error();
        }
    }
}

