<?php


namespace App\Http\Services\Auth\Api;


use App\Http\Services\Auth\BaseSocialRegisterService;
use App\Http\Services\Boilerplate\BaseService;
use App\Http\Services\MobileDeviceService;
use App\Http\Services\UserService;
use Illuminate\Support\Facades\DB;
use Exception;

class SudoSocialRegisterService extends BaseService {

    /**
     * @var BaseSocialRegisterService
     */
    protected $baseSocialRegisterService;

    /**
     * @var MobileDeviceService
     */
    private $mobileDeviceService;

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * SocialRegisterService constructor.
     * @param BaseSocialRegisterService $baseSocialRegisterService
     * @param MobileDeviceService $mobileDeviceService
     * @param UserService $userService
     */
    public function __construct(BaseSocialRegisterService $baseSocialRegisterService,
                                MobileDeviceService $mobileDeviceService,
                                UserService $userService) {
        $this->baseSocialRegisterService = $baseSocialRegisterService;
        $this->mobileDeviceService = $mobileDeviceService;
        $this->userService = $userService;
    }

    /**
     * @param object $request
     * @return array
     */
    public function socialRegistration(object $request): array {
        try {
            DB::beginTransaction();
            $userResponse =  $this->baseSocialRegisterService->getUser(
                $request->email,
                $request->username,
                USER_ROLE
            );
            if(!$userResponse['success']) throw new Exception($userResponse["message"]);
            $hasAccount = $this->baseSocialRegisterService->checkUserHasAccount(
                $request->userProviderId,
                $request->provider
            );
            if(!$hasAccount) {
                $this->baseSocialRegisterService->createSocialAccountUser(
                    $request->userProviderId,
                    $request->provider,
                    $request->token,
                    $userResponse['data']->id
                );
            }
            $mobileDeviceResponse = $this->mobileDeviceService->saveClientDeviceAndGetToken(
                $userResponse["data"],
                $request
            );
            if (!$mobileDeviceResponse['success']) throw new Exception($mobileDeviceResponse['message']);
            DB::commit();

            return $this->getSocialResponse($userResponse["data"], $mobileDeviceResponse['data']);
        } catch (Exception $e) {
            DB::rollBack();

            return $this->response()->error();
        }
    }

    /**
     * @param object $user
     * @param string $token
     * @return array
     */
    private function getSocialResponse(object $user, string $token): array {
        return !$this->userService->checkUserEmailIsVerified($user) ?
            $this->response()->error('please verify your email'):
            $this->socialAuthenticateApiResponse ($user, $token,__('successfully signIn'));
    }
}