<?php


namespace App\Http\Repositories;


use App\Models\PasswordReset;

class PasswordResetRepository extends BaseRepository {

    /**
     * @var
     */
    protected $model;

    /**
     * UserRepository constructor.
     * @param PasswordReset $passwordReset
     */
    public function __construct(PasswordReset $passwordReset) {
        parent::__construct($passwordReset);
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
