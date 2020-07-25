<?php


namespace App\Http\Services\Auth\web;


use Illuminate\Support\Facades\Auth;
use App\Http\Services\BaseService;
use App\Http\Services\UserService;
use Exception;

class LoginService extends  BaseService {

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * LoginService constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }
    /**
     * @param object $request
     * @return array
     */
    public function signInProcess(object $request) : array {
        try {
            $credentials = $this->credentials($request->except('_token'));
            if(!Auth::attempt($credentials) ) return $this->response()->error();
            $user = Auth::user();

            return !$this->userService->checkUserEmailIsVerified($user) ?
                $this->error("Your account is not verified. Please verify your account."):
                $this->response()->success('Congratulations! You have signed in successfully.');
        } catch (Exception $e) {

            return $this->response()->error();
        }
    }

    /**
     * @param array $data
     * @return array
     */
    private function credentials(array $data) : array {

        return filter_var($data['email'], FILTER_VALIDATE_EMAIL) ?
            ['email' => $data['email'], 'password' => $data['password']] :
            ['user_name' => $data['email'], 'password' => $data['password']];

    }
}

