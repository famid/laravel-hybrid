<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\PasswordChangeRequest;
use App\Http\Requests\Web\ResetPasswordRequest;
use App\Http\Services\web\Auth\ResetPasswordService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ResetPasswordController extends Controller {
    /**
     * @var
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
     * @return Application|Factory|View
     */
    public function resetPasswordView() {

        return view('auth.reset_password');
    }


    /**
     * @param ResetPasswordRequest $request
     * @return RedirectResponse
     */
    public function resetPassword(ResetPasswordRequest $request) {
        $response = $this->resetPasswordService->resetPasswordProcess($request);

        return !$response['success'] ?  redirect()->back()->with(['error' => $response['message']]) :
            redirect()->route('admin.dashboard')->with(['success' => $response['message']]);


    }

    /**
     * @param PasswordChangeRequest $request
     * @return RedirectResponse
     */
    public function passwordChangeProcess(PasswordChangeRequest $request) {
        $response = $this->resetPasswordService->changePassword($request);

        return !$response['success'] ? redirect()->back()->with(['error' => $response['message']]) :
            redirect()->back()->with(['success' => $response['message']]);

    }
}
