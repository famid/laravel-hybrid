<?php


namespace App\Http\Services\Auth\Web;


use App\Http\Services\Boilerplate\BaseService;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\UserService;
use Exception;

class LoginService extends BaseService {

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
    public function signIn(object $request) : array {
        try {
            $credentials = $this->getCredentials($request->only('email','password'));
            if(!Auth::attempt($credentials))
                return $this->response()->error('User not found,please try again');

            return !$this->userService->checkUserEmailIsVerified(Auth::user()) ?
                $this->response()->error("Your account is not verified. Please verify your account."):
                $this->response()->success('Congratulations! You have signed in successfully.');
        } catch (Exception $e) {

            return $this->response()->error();
        }
    }

    /**
     * @param array $data
     * @return array
     */
    private function getCredentials(array $data) : array {
        return filter_var($data['email'], FILTER_VALIDATE_EMAIL) ? [
            'email' => $data['email'],
            'password' => $data['password']
        ] : [
            'username' => $data['email'],
            'password' => $data['password']
        ];
    }
}

