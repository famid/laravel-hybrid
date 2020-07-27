<?php


namespace App\Http\Controllers\Web\Auth;


use App\Http\Services\Auth\PasswordAndVerification\ForgotPasswordService;
use App\Http\Requests\Web\ForgetPasswordRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ForgotPasswordController extends Controller {

    /**
     * @var ForgotPasswordService
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
    public function forgetPassword() {
        return view('auth.forget_password_email');
    }

    /**
     * @param ForgetPasswordRequest $request
     * @return RedirectResponse
     */
    public function forgetPasswordEmailSendProcess(ForgetPasswordRequest $request) {
        return $this->webResponse(
            $this->forgotPasswordService->sendForgetPasswordEmail($request),
            'web.auth.reset_password'
        );
    }
}
