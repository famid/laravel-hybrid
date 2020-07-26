<?php


namespace App\Http\Services\Auth;


use App\Http\Services\BaseService;
use App\Http\Services\UserService;
use Illuminate\Support\Facades\Auth;

class AuthenticationService extends BaseService {

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
     * @param $request
     * @return array
     */
    protected function signInProcess($request) {
        $credentials = $this->credentials($request->only('email','password'));
        if(!Auth::attempt($credentials)) return $this->response()->error();;
        $user = Auth::user();

        return !$this->userService->checkUserEmailIsVerified($user) ?
            $this->response()->error("Your account is not verified. Please verify your account."):
            $this->response()->success('Congratulations! You have signed in successfully.');
    }

    /**
     * @param array $data
     * @return array
     */
    private function credentials(array $data) : array {

        return filter_var($data['email'], FILTER_VALIDATE_EMAIL) ? [
                'email' => $data['email'],
                'password' => $data['password']
        ] : [
            'username' => $data['email'],
            'password' => $data['password']
        ];
    }

}
