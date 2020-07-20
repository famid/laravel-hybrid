<?php


namespace App\Http\Repository;


use App\Models\MobileDevice;

class MobileDeviceRepository
{
    protected $model;

    /**
     * MobileDeviceRepository constructor.
     * @param MobileDevice $mobileDevice
     */
    public function __construct(MobileDevice $mobileDevice) {
        $this->model = $mobileDevice;
    }

    /**
     * @param $insert
     * @return mixed
     */
    public function createOrUpdate($insert) {

        return $this->model::create($insert);
    }

}