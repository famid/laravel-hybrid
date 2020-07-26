<?php


namespace App\Http\Services;


use App\Http\Repository\MobileDeviceRepository;

class MobileDeviceService extends BaseService {
    /**
     * @var MobileDeviceRepository
     */
    protected $mobileDeviceRepository;

    /**
     * MobileDeviceService constructor.
     * @param MobileDeviceRepository $mobileDeviceRepository
     */
    public function __construct(MobileDeviceRepository $mobileDeviceRepository) {
        $this->mobileDeviceRepository = $mobileDeviceRepository;
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
     * @param int $userId
     * @return bool
     */
    public function deleteMobileDeviceInfo(int $userId) :bool {
        $deleteResponse = $this->mobileDeviceRepository->destroy($userId);

        return $deleteResponse > 0;
    }

}