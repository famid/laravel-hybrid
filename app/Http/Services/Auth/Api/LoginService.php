<?php


namespace App\Http\Services\Auth\Api;


use App\Http\Services\Boilerplate\BaseService;
use App\Http\Services\MobileDeviceService;
use App\Http\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Exception;

class LoginService extends BaseService {

    /**
     * @var MobileDeviceService
     */
    private $mobileDeviceService;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * LoginService constructor.
     * @param UserService $userService
     * @param MobileDeviceService $mobileDeviceService
     */
    public function __construct(UserService $userService, MobileDeviceService $mobileDeviceService) {
        $this->userService = $userService;
        $this->mobileDeviceService = $mobileDeviceService;
    }

    /**
     * @param object $request
     * @return array
     */
    public function signIn(object $request): array {
        try {
            $signInResponse = $this->signInProcess($request);
            if (!$signInResponse["success"]) return $signInResponse;

            $tokenResponse =  $this->mobileDeviceService->saveClientDeviceAndGetToken(Auth::user(), $request);

            return !$tokenResponse['success'] ?
                $tokenResponse :
                $this->authenticateApiResponse($tokenResponse['data'], Auth::user(), $signInResponse['message']);
        } catch (Exception $e) {

            return $this->response()->error();
        }
    }

    /**
     * @param $request
     * @return array
     */
    protected function signInProcess($request): array {
        $credentials = $this->getCredentials($request->only('email','password'));
        if(!Auth::attempt($credentials))
            return $this->response()->error('User not found,please try again or login as social user');

        return !$this->userService->checkUserEmailIsVerified(Auth::user()) ?
            $this->response()->error("Your account is not verified. Please verify your account."):
            $this->response()->success('Congratulations! You have signed in successfully.');
    }

    /**
     * @param array $data
     * @return array
     */
    private function getCredentials(array $data): array {
        return filter_var($data['email'], FILTER_VALIDATE_EMAIL) ? [
            'email' => $data['email'],
            'password' => $data['password']
        ] : [
            'username' => $data['email'],
            'password' => $data['password']
        ];
    }
}
