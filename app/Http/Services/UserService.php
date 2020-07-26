<?php


namespace App\Http\Services;


use App\Http\Repository\MobileDeviceRepository;
use App\Http\Repository\UserRepository;
use App\Jobs\SendVerificationEmailJob;
use Exception;

class UserService extends BaseService {
    /**
     * @var UserRepository
     */
    protected $userRepository;
    /**
     * @var MobileDeviceRepository
     */
    protected $mobileDeviceRepository;

    /**
     * UserService constructor.
     * @param UserRepository $userRepository
     * @param MobileDeviceRepository $mobileDeviceRepository
     */
    public function __construct(UserRepository $userRepository, MobileDeviceRepository $mobileDeviceRepository) {
        $this->userRepository = $userRepository;
        $this->mobileDeviceRepository = $mobileDeviceRepository;
    }

    /**
     * @param array $userData
     * @return array
     */
    public function create(array $userData) : array {
        try {
            $user = $this->userRepository->create($userData);
            if(!$user) return $this->response()->error();
            dispatch(new SendVerificationEmailJob($user->email_verification_code, $user))
                ->onQueue('email-send');

            return $this->response($user)
                ->success("Successfully Signed up! \n Please verify your account");
        } catch (Exception $e) {

            return $this->response()->error();
        }
    }

    /**
     * @param string $email
     * @return array
     */
    public function userEmailExists(string $email) :array {
        try {
            $user = $this->userRepository->getUser(['email' => $email]);

            return empty($user) ?
                $this->response()->error() :
                $this->response($user)->success();
        } catch (Exception $e) {

            return $this->response()->error();
        }
    }

    /**
     * @param object $user
     * @param object $request
     * @return array
     */
    public function getTokenAndStoreMobileDeviceData(object $user, object $request) :array {
        $createTokenResponse = $this->accessToken($user,$request->get('email'));

        if (!$createTokenResponse['success']) return $createTokenResponse;
        $storeMobileDeviceResponse = $this->updateOrCreateMobileDeviceInfo(
            $user->id,
            $request->device_type,
            $request->device_token
        );

        return !$storeMobileDeviceResponse ? $this->response()->error() :
            $this->response($createTokenResponse['data'])->success();
    }
    /**
     * @param int $userId
     * @param string $deviceType
     * @param string $deviceToken
     * @return bool
     */
    public function updateOrCreateMobileDeviceInfo(int $userId, string $deviceType, string $deviceToken) :bool {
        $storeMobileDeviceResponse = $this->mobileDeviceRepository->updateOrCreate(
            ['user_id' => $userId], ['device_type' => $deviceType, 'device_token' => $deviceToken]
        );

        return (!$storeMobileDeviceResponse || !isset($storeMobileDeviceResponse));
    }

    /**
     * @param object $user
     * @param $email
     * @return array
     */
    public function accessToken(object $user,  $email) :array {
        $token = $user->createToken($email)->accessToken;

        return empty($token) ? $this->response()->error() :
            $this->response($token)->success();
    }

    /**
     * @param object $user
     * @return bool
     */
    public function checkUserEmailIsVerified(object $user) :bool {

        return is_null($user->email_verification_code) && $user->email_verified == ACTIVE_STATUS;
    }


}
