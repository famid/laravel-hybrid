<?php


namespace App\Http\Services\Auth\Api;


use App\Http\Services\Boilerplate\BaseService;
use App\Http\Services\MobileDeviceService;
use App\Http\Services\UserService;
use Illuminate\Support\Facades\DB;
use Exception;

class RegisterService extends BaseService {

    /**
     * @var UserService
     */
    protected $userService;
    /**
     * @var MobileDeviceService
     */
    private $mobileDeviceService;

    /**
     * RegisterService constructor.
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
    public function signUp(object $request) : array {
        try {
            DB::beginTransaction();
            $createUserResponse = $this->userService->create(
                $this->userService->prepareUserData($request, randomNumber(6))
            );
            if (!$createUserResponse['success']) throw new Exception($createUserResponse['message']);
            $mobileDeviceResponse = $this->mobileDeviceService->saveClientDeviceAndBuildResponse(
                $createUserResponse["data"],
                $request,
                __("Sign up successful")
            );
            if (!$mobileDeviceResponse['success']) throw new Exception($mobileDeviceResponse['message']);
            DB::commit();

            return $mobileDeviceResponse;
        } catch (Exception $e) {
            DB::rollBack();

            return $this->response()->error();
        }
    }
}
