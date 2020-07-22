<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use App\Http\Services\Auth\web\LoginService;
use App\Http\Requests\Web\SignInRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller {
    /**
     * @var LoginService
     */
    protected $loginService;

    /**
     * LoginController constructor.
     * @param LoginService $loginService
     */
    public function __construct(LoginService $loginService) {
        $this->loginService = $loginService;
    }

    /**
     * @return Application|Factory|View
     */
    public function signIn() {

        return view('auth.login');
    }

    /**
     * @param SignInRequest $request
     * @return RedirectResponse
     */
    public function signInProcess(SignInRequest $request) {
        $response = $this->loginService->signInProcess($request);

        return $this->webResponse($response, 'admin.dashboard');
    }

    /**
     * @return RedirectResponse
     */
    public function signOut() {
        Auth::logout();
        session()->flush();

        return redirect()->route('signIn');
    }
}
