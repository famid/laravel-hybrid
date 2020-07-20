<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\SignInRequest;
use App\Http\Services\web\Auth\LoginService;
use Illuminate\Contracts\Foundation\Application;
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

        return !$response ? redirect()->back()->with($this->errorResponse()) :
            redirect()->route('admin.dashboard')->with($this->successResponse
            ($response["message"]));
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
