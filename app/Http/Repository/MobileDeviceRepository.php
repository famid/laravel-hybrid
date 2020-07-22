<?php


namespace App\Http\Repository;


use App\Models\MobileDevice;

class MobileDeviceRepository extends BaseRepository
{
    protected $model;

    /**
     * MobileDeviceRepository constructor.
     * @param MobileDevice $mobileDevice
     */
    public function __construct(MobileDevice $mobileDevice) {
        parent::__construct($mobileDevice);
    }
}