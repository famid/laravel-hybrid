<?php


namespace App\Http\Repositories;


use App\Models\User;

class UserRepository extends BaseRepository  {

    /**
     * UserRepository constructor.
     * @param User $user
     */
    public function __construct(User $user) {
        parent::__construct($user);
    }

    /**
     * @param $where
     * @return mixed
     */
    public function getUser($where) {
        return $this->model->where($where)->orderBy('id', 'ASC')->first();
    }
}
