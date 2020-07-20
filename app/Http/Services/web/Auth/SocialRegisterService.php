<?php


namespace App\Http\Services\web\Auth;


use App\Http\Services\BaseService;
use App\Http\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Repository\SocialAccountRepository;
use Exception;

class SocialRegisterService extends BaseService {

    /**
     * @var SocialAccountRepository
     */
    protected $socialAccountRepository;
    /**
     * @var UserService
     */
    protected $userService;

    /**
     * SocialRegisterService constructor.
     * @param SocialAccountRepository $socialAccountRepository
     * @param UserService $userService
     */
    public function __construct(SocialAccountRepository $socialAccountRepository, UserService $userService) {
        $this->socialAccountRepository = $socialAccountRepository;
        $this->userService = $userService;
    }

    /**
     * @param string $provider
     * @return array
     */
    public function socialRegistration(string $provider) :array {
        try {
            $providerUser = Socialite::driver($provider)->stateless()->user();
            DB::beginTransaction();
            $userResponse = $this->getUser($providerUser);
            if(!$userResponse['success']) throw new Exception($userResponse["message"]);
            $hasAccount = $this->checkUserHasAccount($providerUser, $provider);
            if(!$hasAccount) $this->createSocialAccountUser(
                $providerUser,
                $provider,
                $userResponse['data']
            );
            DB::commit();

            return $this->loginAttempt($userResponse["data"]);
        } catch (Exception $e) {
            DB::rollBack();

            return $this->jsonResponse()->error();
        }
    }

    /**
     * @param object $providerUser
     * @param string $provider
     * @return bool
     */
    public function checkUserHasAccount (object $providerUser, string $provider) : bool {
        return $this->socialAccountRepository->getUserAccount($providerUser->getId(), $provider);
    }

    /**
     * @param object $providerUser
     * @param string $provider
     * @param $user
     * @return void
     */
    private function createSocialAccountUser (object $providerUser, string $provider, $user) :void {
        $this->socialAccountRepository->create($this->_prepareSocialAccount(
            $providerUser->getId(),
            $provider,
            $providerUser->token,
            $user->id
        ));
    }

    /**
     * @param $user
     * @return array
     */
    private function loginAttempt($user) {
        Auth::login($user);

        return $this->jsonResponse()->success('you are successfully signIn');
    }

    /**
     * @param object $providerUser
     * @return array
     */
    private function getUser (object $providerUser) :array {
        $userEmailResponse = $this->userService->userEmailExists($providerUser->getEmail());
        return $userEmailResponse['success'] ? $userEmailResponse :
            $this->userService->create($this->preparedCreateUserData($providerUser));
    }

    /**
     * @param object $providerUser
     * @return array
     */
    private function preparedCreateUserData(object $providerUser) :array {

        return [
            'email' => $providerUser->getEmail(),
            'username' => empty(!$providerUser->getName()) ? $providerUser->getName()
                :$providerUser->getNickname(),
            'role' => USER_ROLE,
            'status' => ACTIVE_STATUS,
            'email_verification_code' => randomNumber(6),
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
                                           string $token, int $userId) : array {
        return [
            'provider_user_id' => $providerUserId,
            'provider' => $provider,
            'token' => $token,
            'user_id' => $userId
        ];
    }
}