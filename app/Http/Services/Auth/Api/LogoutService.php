<?php


namespace App\Http\Services\Auth\Api;


use App\Http\Services\Boilerplate\BaseService;
use App\Http\Services\MobileDeviceService;
use App\Http\Services\OAuthAccessTokenService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;

class LogoutService extends BaseService {

    /**
     * @var MobileDeviceService
     */
    private $mobileDeviceService;
    /**
     * @var OAuthAccessTokenService
     */
    private $accessTokenService;

    public function __construct(OAuthAccessTokenService $accessTokenService, MobileDeviceService $mobileDeviceService) {
        $this->accessTokenService = $accessTokenService;
        $this->mobileDeviceService = $mobileDeviceService;
    }

    /**
     * @param object $request
     * @return array
     */
    public function logout(object $request) :array {
        try {
            $token = $request->user()->token();
            if (empty($token)) return $this->response()->error();
            DB::beginTransaction();
            $deleteToken = $this->accessTokenService->delete($token->id);
            $deleteDevice = $this->mobileDeviceService->deleteMobileDeviceInfo(Auth::id());
            if (!$deleteToken || !$deleteDevice) throw new Exception();

            DB::commit();

            return $this->response()->success('Logged out successfully');
        } catch (Exception $e) {
            DB::rollBack();

            return $this->response()->error();
        }
    }
}
