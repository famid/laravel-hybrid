<?php


namespace App\Http\Services\Auth\Api;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Services\BaseService;
use App\Http\Services\UserService;
use Exception;


class LoginService extends BaseService {
    /**
     * @var UserService
     */
    protected $userService;
    /**
     * @var object
     */
    private $request;
    /**
     * @var mixed
     */
    private $user;

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
            $this->request = $request;
            $validateUserResponse = $this->getValidateUser();
            if (!$validateUserResponse['success']) return $validateUserResponse;
            $this->user = $validateUserResponse['data'];
//            $credentials = $this->request->only('email','password');
//            if(!Auth::attempt($credentials) ) return $this->response()->error();
//            $this->user = Auth::user();

            return !$this->userService->checkUserEmailIsVerified($this->user) ?
                $this->error("Your account is not verified. Please verify your account."):
                $this->getSignInApiResponse();
        } catch (Exception $e) {

            return $this->response()->error();
        }
    }

    /**
     * @return array
     */
    private function getValidateUser() :array {
        $userResponse = $this->userService->userEmailExists($this->request->email);
        if(!$userResponse['success']) return $userResponse;

        return !Hash::check($this->request->password, $userResponse['data']->password) ?
            $this->response()->error('Your given Password is incorrect') : $userResponse;
    }

    /**
     * @param string $token
     * @return array
     */
    private function _prepareSignInResponse(string $token) : array {

        return [
            'email_verified' => true,
            'access_token' => $token,
            'access_type' => "Bearer",
            'user_data' => [
                'name' => $this->user->first_name . ' ' . $this->user->last_name,
                'email' => $this->user->email,
                'phone' => $this->user->phone
            ]
        ];
    }

    /**
     * @return array
     */
    private function getSignInApiResponse() :array {
        $getTokenResponse = $this->userService->getTokenAndStoreMobileDeviceData($this->user, $this->request);

        return !$getTokenResponse['success']  ? $getTokenResponse :
            $this->_prepareSignInResponse($getTokenResponse['data']);
    }

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