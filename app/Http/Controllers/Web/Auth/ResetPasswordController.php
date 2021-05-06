<?php


namespace App\Http\Controllers\Web\Auth;


use App\Http\Services\Auth\Password\ResetPasswordService;
use App\Http\Requests\Web\PasswordChangeRequest;
use Illuminate\Contracts\Foundation\Application;
use App\Http\Requests\Web\ResetPasswordRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ResetPasswordController extends Controller {

    /**
     * @var ResetPasswordService
     */
    protected $resetPasswordService;

    /**
     * ResetPasswordController constructor.
     * @param ResetPasswordService $resetPasswordService
     */
    public function __construct(ResetPasswordService $resetPasswordService) {
        $this->resetPasswordService = $resetPasswordService;
    }

    /**
     * @param string $email
     * @return Application|Factory|View
     */
    public function resetPassword(string $email) {
        return view('auth.reset_password',['email' => $email]);
    }

    /**
     * @param ResetPasswordRequest $request
     * @return RedirectResponse
     */
    public function resetPasswordProcess(ResetPasswordRequest $request): RedirectResponse {
        return $this->webResponse(
            $this->resetPasswordService->resetPasswordProcess($request),
            'web.auth.sign_in',
            'web.auth.forget_password'
        );
    }

    /**
     * @param PasswordChangeRequest $request
     * @return RedirectResponse
     */
    public function passwordChangeProcess(PasswordChangeRequest $request): RedirectResponse {
        return $this->webResponse($this->resetPasswordService->changePassword($request));
    }
}
