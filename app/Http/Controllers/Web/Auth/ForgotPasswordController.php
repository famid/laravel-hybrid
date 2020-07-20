<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\ForgetPasswordRequest;
use App\Http\Services\web\Auth\ForgotPasswordService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ForgotPasswordController extends Controller
{
    /**
     * @var
     */
    protected $forgotPasswordService;

    /**
     * ForgotPasswordController constructor.
     * @param ForgotPasswordService $forgotPasswordService
     */
    public function __construct(ForgotPasswordService $forgotPasswordService) {
        $this->forgotPasswordService = $forgotPasswordService;
    }

    /**
     * @return Application|Factory|View
     */
    public function forgetPasswordView() {

        return view('auth.forget_password_email');
    }

    /**
     * @param ForgetPasswordRequest $request
     * @return RedirectResponse
     */
    public function forgetPasswordEmailSendProcess(ForgetPasswordRequest $request) {
        $response = $this->forgotPasswordService->sendForgetPasswordEmail($request);

        return $this->webResponse($response, 'resetPasswordView');

    }
}
