<?php


namespace App\Http\Services;


use App\Http\Repository\OAuthAccessTokenRepository;
use App\Http\Services\Boilerplate\BaseService;

class OAuthAccessTokenService extends BaseService {

    public function __construct(OAuthAccessTokenRepository $accessTokenRepository) {
        $this->repository = $accessTokenRepository;
    }

    /**
     * @param string $tokenId
     * @return bool
     */
    public function delete(string $tokenId) {
        $deleteResponse = $this->repository->deleteWhere(['id' => $tokenId]);

        return $deleteResponse > 0;
    }
}
