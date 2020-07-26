<?php


namespace App\Http\Services\Auth;


use App\Http\Services\BaseService;
use App\Http\Services\MobileDeviceService;
use Illuminate\Support\Facades\Auth;

class AuthenticationService extends BaseService {

    /**
     * @var MobileDeviceService
     */
    protected $mobileDeviceService;

    /**
     * LoginService constructor.
     * @param MobileDeviceService $mobileDeviceService
     */
    public function __construct( MobileDeviceService $mobileDeviceService) {
        $this->mobileDeviceService = $mobileDeviceService;
    }

    /**
     * @param $request
     * @return array
     */
    protected function signInProcess($request) {
        $credentials = $this->credentials($request->only('email','password'));
        if(!Auth::attempt($credentials)) return $this->response()->error();;
        $user = Auth::user();

        return !$this->checkUserEmailIsVerified($user) ?
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

    /**
     * @param object $user
     * @param object $request
     * @return array
     */
    public function getTokenAndStoreMobileDeviceData(object $user, object $request) :array {
        $createTokenResponse = $this->accessToken($user,$request->get('email'));

        if (!$createTokenResponse['success']) return $createTokenResponse;
        $storeMobileDeviceResponse = $this->mobileDeviceService->updateOrCreateMobileDeviceInfo(
            $user->id,
            $request->device_type,
            $request->device_token
        );

        return !$storeMobileDeviceResponse ? $this->response()->error() :
            $this->response($createTokenResponse['data'])->success();
    }

    /**
     * @param object $user
     * @return bool
     */
    public function checkUserEmailIsVerified(object $user) :bool {

        return is_null($user->email_verification_code) && $user->email_verified == ACTIVE_STATUS;
    }

    /**
     * @param object $user
     * @param $email
     * @return array
     */
    private function accessToken(object $user,  $email) :array {
        $token = $user->createToken($email)->accessToken;

        return empty($token) ? $this->response()->error() :
            $this->response($token)->success();
    }

}
