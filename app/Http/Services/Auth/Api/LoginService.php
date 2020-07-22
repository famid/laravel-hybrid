<?php


namespace App\Http\Services\Auth\Api;


use App\Http\Services\BaseService;
use App\Http\Services\UserService;
use Illuminate\Support\Facades\Hash;
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
    public function signInProcess(object $request) : array {
        try {
            $getValidateUser = $this->getValidateUser($request);

            if (!$getValidateUser['success']) return $getValidateUser;
            $getTokenResponse = $this->userService->getTokenAndStoreMobileDeviceData(
                $getValidateUser['data'],
                $request
            );

            return !$getTokenResponse['success'] ? $getTokenResponse:
                $this->getSignInApiResponse($getValidateUser['data'],$getTokenResponse['data']);
        } catch (Exception $e) {

            return $this->response()->error();
        }
    }

    /**
     * @param object $request
     * @return array
     */
    private function getValidateUser(object $request) :array {
        $userResponse = $this->userService->userEmailExists($request->email);

        if(!$userResponse['success']) return $userResponse;

        return !Hash::check($request->password, $userResponse['data']->password) ?
            $this->response()->error('Your given Password is incorrect'): $userResponse;
    }

    /**
     * @param object $user
     * @param string $token
     * @return array
     */
    private function prepareSignInResponse(object $user, string $token) : array {
        return [
            'email_verified' => $user->email_verified,
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
     * @param string $token
     * @return array
     */
    private function getSignInApiResponse(object $user, string $token) :array {
        return $this->response($this->prepareSignInResponse($user, $token))
            ->success(
                !$this->checkUserEmailIsVerified($user) ?
                    "Your account is not verified. Please verify your account." :
                    "Successfully Signed in!"
            );
    }

    /**
     * @param object $user
     * @return bool
     */
    public function checkUserEmailIsVerified(object $user) :bool {

        return !is_null($user->email_verification_code) || $user->status != USER_ACTIVE_STATUS;
    }

}