<?php


namespace App\Http\Repositories;


use App\Models\SocialAccount;

class SocialAccountRepository extends BaseRepository {

    /**
     * UserRepository constructor.
     * @param SocialAccount $socialAccount
     */
    public function __construct(SocialAccount $socialAccount) {
        parent::__construct($socialAccount);
    }

    /**
     * @param $providerUserId
     * @param $provider
     * @return mixed
     */
    public function getUserAccount($providerUserId, $provider) {
        return $this->model->firstWhere([
            'provider' => $provider,
            'provider_user_id' => $providerUserId
        ]);
    }
}
