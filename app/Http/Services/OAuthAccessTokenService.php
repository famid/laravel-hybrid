<?php


namespace App\Http\Services;


use App\Http\Repositories\OAuthAccessTokenRepository;
use App\Http\Services\Boilerplate\BaseService;

class OAuthAccessTokenService extends BaseService {

    /**
     * OAuthAccessTokenService constructor.
     * @param OAuthAccessTokenRepository $accessTokenRepository
     */
    public function __construct(OAuthAccessTokenRepository $accessTokenRepository) {
        $this->repository = $accessTokenRepository;
    }

    /**
     * @param string $tokenId
     * @return bool
     */
    public function delete(string $tokenId): bool {
        return $this->repository->deleteWhere(['id' => $tokenId]) > 0;
    }
}
