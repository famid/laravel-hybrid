<?php


namespace App\Http\Repository;


use App\Models\PasswordReset;

class PasswordResetRepository
{
    protected $model;

    /**
     * UserRepository constructor.
     * @param PasswordReset $passwordReset
     */
    public function __construct(PasswordReset $passwordReset) {
        $this->model = $passwordReset;
    }

    /**
     * @param $id
     * @param $status
     * @return mixed
     */
    public function updatePasswordResetStatus(int $id, $status) {

        return $this->model::where('id',$id)->update(['status' => $status]);
    }

    /**
     * @param $userId
     * @param $verificationCode
     * @return mixed
     */
    public function storePasswordResetCode ($userId, $verificationCode) {

        return  $this->model::create([
            'user_id' => $userId,
            'verification_code' => $verificationCode
        ]);
    }

    /**
     * @param $resetPasswordCode
     * @return mixed
     */
    public function getPasswordResetCode ($resetPasswordCode) {

        return $this->model::where(
            ['verification_code' => $resetPasswordCode, 'status' => PENDING_STATUS])
            ->first();
    }

    /**
     * @param int $userId
     * @return mixed
     */
    public function getUserLatestResetCode (int $userId) {

        return $this->model::where(
            ['user_id' => $userId, 'status' => PENDING_STATUS])
            ->orderBy('id', 'desc')
            ->first();
    }

}