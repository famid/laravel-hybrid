<?php


namespace App\Http\Services\Auth\Api;


use App\Http\Services\Auth\AuthenticationService;
use App\Http\Services\MobileDeviceService;
use App\Http\Services\UserService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Exception;

class RegisterService extends AuthenticationService {

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * RegisterService constructor.
     * @param UserService $userService
     * @param MobileDeviceService $mobileDeviceService
     */
    public function __construct(UserService $userService, MobileDeviceService $mobileDeviceService) {
        Parent::__construct($mobileDeviceService);
        $this->userService = $userService;
    }

    /**
     * @param object $request
     * @return array
     */
    public function signUp(object $request) : array {
        try {
            DB::beginTransaction();
            $response = $this->createUser($request);
            if (!$response["success"]) throw new Exception($response["message"]);
            DB::commit();

            return $response;
        } catch (Exception $e) {
            DB::rollBack();

            return $this->response()->error();
        }
    }

    /**
     * @param object $request
     * @return array
     */
    private function createUser(object $request) :array {
        $createUserResponse = $this->userService->create($this->preparedCreateUserData($request));

        if (!$createUserResponse['success']) return $createUserResponse;
        $getTokenResponse = $this->getTokenAndStoreMobileDeviceData(
            $createUserResponse['data'],
            $request
        );

        return !$getTokenResponse['success'] ?
            $getTokenResponse :
            $this->response($this->preparedApiResponse(
                $createUserResponse['data'],
                $getTokenResponse['data'])
            )->success('Successfully Signed up! \n Please verify your account');
    }

    /**
     * @param object $request
     * @return array
     */
    private function preparedCreateUserData(object $request) : array {

        return [
            'email' => $request->email,
            'phone_code' => $request->phone_code,
            'phone' => $request->phone,
            'password' => Hash::make($request->get('password')),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'role' => USER_ROLE,
            'status' => USER_PENDING_STATUS,
            'email_verification_code' => randomNumber(6),
        ];
    }

    /**
     * @param object $user
     * @param string $token
     * @return array
     */
    private function preparedApiResponse (object $user, string $token) :array {
        return [
            'access_token' => $token,
            'access_type' => "Bearer",
            'user_data' => [
                'name' => $user->first_name . ' ' . $user->last_name,
                'email' => $user->email,
                'username' => $user->username,
                'phone' => $user->phone
            ]
        ];
    }

}
