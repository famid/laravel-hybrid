<?php


namespace App\Http\Services\Auth\Api;


use App\Http\Services\Auth\BaseLoginService;
use App\Http\Services\MobileDeviceService;
use App\Http\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Exception;

class LoginService extends BaseLoginService {

    /**
     * @var MobileDeviceService
     */
    private $mobileDeviceService;

    /**
     * LoginService constructor.
     * @param UserService $userService
     * @param MobileDeviceService $mobileDeviceService
     */
    public function __construct(UserService $userService, MobileDeviceService $mobileDeviceService) {
        parent::__construct($userService);
        $this->mobileDeviceService = $mobileDeviceService;
    }

    /**
     * @param object $request
     * @return array
     */
    public function signIn(object $request) : array {
        try {
            $signInResponse = $this->signInProcess($request);

            return !$signInResponse["success"] ?
                $signInResponse :
                $this->mobileDeviceService->saveClientDeviceAndBuildResponse(
                    Auth::user(),
                    $request,
                    __("Sign in successful")
                );
        } catch (Exception $e) {

            return $this->response()->error();
        }
    }
}
