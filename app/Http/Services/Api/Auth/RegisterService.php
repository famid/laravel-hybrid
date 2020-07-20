<?php


namespace App\Http\Services\Api\Auth;


use App\Http\Repository\MobileDeviceRepository;
use App\Http\Services\BaseService;
use App\Http\Services\UserService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Exception;

class RegisterService extends BaseService {
    /**
     * @var UserService
     */
    protected $userService;
    /**
     * @var MobileDeviceRepository
     */
    protected $mobileDeviceRepository;


    /**
     * RegisterService constructor.
     * @param UserService $userService
     * @param MobileDeviceRepository $mobileDeviceRepository
     */
    public function __construct(UserService $userService, MobileDeviceRepository $mobileDeviceRepository) {
        $this->userService = $userService;
        $this->mobileDeviceRepository = $mobileDeviceRepository;
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

            return $this->jsonResponse()->error();
        }
    }

    /**
     * @param object $request
     * @return array
     */
    private function createUser(object $request) :array {
        $createUserResponse = $this->userService->create($this->preparedCreateUserData($request));

        if (!$createUserResponse['success']) return $createUserResponse;
        $storeMobileDeviceResponse = $this->storeMobileDeviceInfo(
            $createUserResponse['data']->id,
            $request->device_type,
            $request->device_token
        );

        if (!$storeMobileDeviceResponse) return $this->jsonResponse()->error();
        $createTokenResponse = $this->accessToken($createUserResponse['data'],$request->get('email'));

        if (!$createTokenResponse['success']) return $createTokenResponse;

        return $this->jsonResponse($this->preparedApiResponse($createTokenResponse['data'],
            $createUserResponse['data']))
            ->success('Successfully Signed up! \n Please verify your account');
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
     * @param string $token
     * @param object $user
     * @return array
     */
    private function preparedApiResponse (string $token, object $user) :array {
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

    /**
     * @param $userId
     * @param $deviceType
     * @param $deviceToken
     * @return bool
     */
    private function storeMobileDeviceInfo($userId, $deviceType, $deviceToken) :bool {
        $storeMobileDeviceResponse = $this->mobileDeviceRepository->createOrUpdate([
            'user_id' => $userId,
            'device_type' => $deviceType,
            'device_token' => $deviceToken
        ]);

        return (!$storeMobileDeviceResponse || isset($storeMobileDeviceResponse)) ? false : true;
    }

    /**
     * @param object $user
     * @param $email
     * @return array
     */
    private function accessToken(object $user,  $email) :array {
       $token = $user->createToken($email)->accessToken;

        return empty($token) ? $this->jsonResponse()->error() :
            $this->jsonResponse($token)->success();
    }
}