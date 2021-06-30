<?php


namespace App\Http\Services\Auth;


use App\Http\Repositories\SocialAccountRepository;
use App\Http\Services\Boilerplate\BaseService;
use App\Http\Services\UserService;

class BaseSocialRegisterService extends BaseService {

    /**
     * @var SocialAccountRepository
     */
    protected $socialAccountRepository;

    /**
     * @var UserService
     */
    protected $userService;

    public function __construct(SocialAccountRepository $socialAccountRepository, UserService $userService) {
        $this->socialAccountRepository = $socialAccountRepository;
        $this->userService = $userService;
    }

    /**
     * @param string $userProviderId
     * @param string $provider
     * @return bool
     */
    public function checkUserHasAccount (string $userProviderId, string $provider): bool {
        return !is_null($this->socialAccountRepository->getUserAccount($userProviderId, $provider));
    }

    /**
     * @param string $providerUserId
     * @param string $provider
     * @param string $token
     * @param int $userId
     */
    public function createSocialAccountUser (string $providerUserId, string $provider,
                                             string $token, int $userId): void {
        $this->socialAccountRepository->create($this->_prepareSocialAccount(
            $providerUserId,
            $provider,
            $token,
            $userId
        ));
    }

    /**
     * @param string $email
     * @param string $userName
     * @param $role
     * @return array
     */
    public function getUser(string $email, string $userName, $role): array {
        $userEmailResponse = $this->userService->userEmailExists($email);

        return $userEmailResponse['success'] ?
            $userEmailResponse :
            $this->userService->create($this->prepareSocialUserData($email,$userName,$role));
    }

    /**
     * @param string $email
     * @param string $userName
     * @param int $role
     * @return array
     */
    private function prepareSocialUserData(string $email, string $userName, int $role): array {
        return [
            'email' => $email,
            'username' => $userName,
            'role' => $role
        ];
    }

    /**
     * @param string $providerUserId
     * @param string $provider
     * @param string $token
     * @param int $userId
     * @return array
     */
    private function _prepareSocialAccount(string $providerUserId, string $provider,
                                           string $token, int $userId): array {
        return [
            'provider_user_id' => $providerUserId,
            'provider' => $provider,
            'token' => $token,
            'user_id' => $userId
        ];
    }
}