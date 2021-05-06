<?php


namespace App\Http\Controllers\Web\Auth;


use Illuminate\Http\RedirectResponse as RedirectResponseAlias;
use Illuminate\Contracts\Foundation\Application;
use App\Http\Services\Auth\Web\LogoutService;
use App\Http\Services\Auth\Web\LoginService;
use App\Http\Requests\Web\SignInRequest;
use Illuminate\Contracts\View\Factory;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class LoginController extends Controller {

    /**
     * @var LoginService
     */
    protected $loginService;

    /**
     * @var LogoutService
     */
    private $logoutService;

    /**
     * LoginController constructor.
     * @param LoginService $loginService
     * @param LogoutService $logoutService
     */
    public function __construct(LoginService $loginService, LogoutService $logoutService) {
        $this->loginService = $loginService;
        $this->logoutService = $logoutService;
    }

    /**
     * @return Application|Factory|View
     */
    public function signIn() {
        return view('auth.login');
    }

    /**
     * @param SignInRequest $request
     * @return RedirectResponseAlias
     */
    public function signInProcess(SignInRequest $request): RedirectResponseAlias {
        return $this->webResponse($this->loginService->signIn($request), 'web.admin.dashboard');
    }

    /**
     * @return RedirectResponseAlias
     */
    public function signOut(): RedirectResponseAlias {
        return $this->webResponse($this->logoutService->logout(), 'web.auth.sign_in');
    }
}
