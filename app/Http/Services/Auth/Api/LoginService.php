<?php


namespace App\Http\Services\Auth\Api;


use App\Http\Services\Auth\AuthenticationService;
use App\Http\Services\MobileDeviceService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;

class LoginService extends AuthenticationService {

    /**
     * LoginService constructor.
     * @param MobileDeviceService $mobileDeviceService
     */
    public function __construct(MobileDeviceService $mobileDeviceService) {
        parent::__construct($mobileDeviceService);
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
                $this->getSignInApiResponse(Auth::user(), $request);
        } catch (Exception $e) {

            return $this->response()->error();
        }
    }

    /**
     * @param object $user
     * @param string $token
     * @return array
     */
    private function _prepareSignInResponse(object $user, string $token) : array {

        return [
            'email_verified' => true,
            'access_token' => $token,
            'access_type' => "Bearer",
            'user_data' => [
                'name' => $user->first_name . ' ' . $user->last_name,
                'email' => $user->email,
                'phone' => $user->phone
            ]
        ];
    }

    /**
     * @param object $user
     * @param object $request
     * @return array
     */
    private function getSignInApiResponse(object $user, object $request) :array {
        $getTokenResponse = $this->getTokenAndStoreMobileDeviceData($user, $request);

        return !$getTokenResponse['success']  ? $getTokenResponse :
            $this->_prepareSignInResponse($user, $getTokenResponse['data']);
    }

    /**
     * @param object $request
     * @return array
     */
    public function logout(object $request) :array {
        try {
            $token = $request->user()->token();
            if (empty($token)) return $this->response()->error();
            DB::table('oauth_access_tokens')->where('id', $token->id)->delete();

            return $this->response()->success('Logged out successfully');
        } catch (Exception $e) {

            return $this->response()->error();
        }
    }

}
