<?php


namespace App\Http\Controllers\Web\Auth;


use Illuminate\Http\RedirectResponse as RedirectResponseAlias;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Http\Services\Auth\Web\SocialRegisterService;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;

class SocialRegisterController extends Controller {

    /**
     * @var SocialRegisterService
     */
    protected $socialRegisterService;

    /**
     * SocialRegisterController constructor.
     * @param SocialRegisterService $socialRegisterService
     */
    public function __construct(SocialRegisterService $socialRegisterService) {
        $this->socialRegisterService = $socialRegisterService;
    }

    /**
     * @param $provider
     * @return RedirectResponse
     */
    public function redirectToProvider($provider): RedirectResponse {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * @param $provider
     * @return RedirectResponseAlias
     */
    public function handleProviderCallback($provider): RedirectResponseAlias {
        return $this->webResponse($this->socialRegisterService->socialRegistration($provider), 'web.admin.dashboard');
    }
}
