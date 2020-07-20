<?php

namespace App\Http\Controllers\Web\Auth;


use App\Http\Services\web\Auth\SocialRegisterService;
use Illuminate\Http\RedirectResponse as RedirectResponseAlias;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
    public function redirectToProvider($provider) {

        return Socialite::driver($provider)->redirect();
    }

    /**
     * @param $provider
     * @return RedirectResponseAlias
     */
    public function handleProviderCallback($provider){
        $response = $this->socialRegisterService->socialRegistration($provider);

        return !$response ? redirect()->back()->with($this->errorResponse()) :
            redirect()->route('admin.dashboard')->with($this->successResponse($response["message"]));
    }
}
