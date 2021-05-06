<?php


namespace App\Http\Services\Auth\Web;


use App\Http\Services\Auth\BaseSocialRegisterService;
use App\Http\Services\Boilerplate\BaseService;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;

class SocialRegisterService extends BaseService {

    /**
     * @var BaseSocialRegisterService
     */
    protected $baseSocialRegisterService;

    /**
     * SocialRegisterService constructor.
     * @param BaseSocialRegisterService $baseSocialRegisterService
     */
    public function __construct(BaseSocialRegisterService $baseSocialRegisterService) {
        $this->baseSocialRegisterService = $baseSocialRegisterService;
    }

    /**
     * @param string $provider
     * @return array
     */
    public function socialRegistration(string $provider): array {
        try {
            $providerUser = Socialite::driver($provider)->stateless()->user();
            DB::beginTransaction();
            $userResponse = $this->baseSocialRegisterService->getUser(
                $providerUser->getEmail(),
                empty(!$providerUser->getName()) ? $providerUser->getName() :$providerUser->getNickname(),
                USER_ROLE
            );
            if(!$userResponse['success']) throw new Exception($userResponse["message"]);
            $hasAccount = $this->baseSocialRegisterService->checkUserHasAccount(
                $providerUser->getId(),
                $provider
            );
            if(!$hasAccount) {
                $this->baseSocialRegisterService->createSocialAccountUser(
                    $providerUser->getId(),
                    $provider,
                    $providerUser->token,
                    $userResponse['data']->id
                );
            }
            DB::commit();

            return $this->loginAttempt($userResponse["data"]);
        } catch (Exception $e) {
            DB::rollBack();

            return $this->response()->error();
        }
    }

    /**
     * @param $user
     * @return array
     */
    private function loginAttempt($user): array {
        Auth::login($user);

        return $this->response()->success('you are successfully signIn');
    }
}
