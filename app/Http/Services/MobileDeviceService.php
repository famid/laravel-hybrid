<?php


namespace App\Http\Services;


use App\Http\Repositories\MobileDeviceRepository;
use App\Http\Services\Boilerplate\BaseService;

class MobileDeviceService extends BaseService {
    /**
     * MobileDeviceService constructor.
     * @param MobileDeviceRepository $mobileDeviceRepository
     */
    public function __construct(MobileDeviceRepository $mobileDeviceRepository) {
        $this->repository = $mobileDeviceRepository;
    }

    /**
     * @param object $user
     * @param object $request
     * @param string $message
     * @return array
     */
    public function saveClientDeviceAndBuildResponse(object $user, object $request, string $message): array {
        $createTokenResponse = $user->createToken($request->email)->accessToken;
        if (empty($createTokenResponse)) return $this->response()->error();
        $storeMobileDeviceResponse = $this->updateOrCreateMobileDeviceInfo(
            $user->id,
            $request->device_type,
            $request->device_token
        );

        return !$storeMobileDeviceResponse ? $this->response()->error() :
            $this->authenticateApiResponse($createTokenResponse, $user, $message);
    }

    /**
     * @param int $userId
     * @param string $deviceType
     * @param string $deviceToken
     * @return bool
     */
    public function updateOrCreateMobileDeviceInfo(int $userId, string $deviceType, string $deviceToken): bool {
        $storeMobileDeviceResponse = $this->repository->updateOrCreate(
            ['user_id' => $userId], ['device_type' => $deviceType, 'device_token' => $deviceToken]
        );

        return isset($storeMobileDeviceResponse);
    }

    /**
     * @param int $userId
     * @param $deviceType
     * @param $deviceToken
     * @return bool
     */
    public function deleteMobileDeviceInfo(int $userId,$deviceType,$deviceToken): bool {
        $deleteResponse = $this->repository->deleteWhere([
            'user_id' => $userId,
            'device_type' => $deviceType,
            'device_token' => $deviceToken
        ]);

        return $deleteResponse > 0;
    }

    /**
     * @param object $user
     * @param object $request
     * @return array
     */
    public function saveClientDeviceAndGetToken(object $user, object $request): array {
        $createTokenResponse = $user->createToken($request->email)->accessToken;
        if (empty($createTokenResponse)) return $this->response()->error();
        $storeMobileDeviceResponse = $this->updateOrCreateMobileDeviceInfo(
            $user->id,
            $request->device_type,
            $request->device_token
        );

        return !$storeMobileDeviceResponse ?
            $this->response()->error() :
            $this->response($createTokenResponse)->success();
    }
}
