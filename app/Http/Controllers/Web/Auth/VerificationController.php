<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\VerifyEmailRequest;
use App\Http\Services\Auth\PasswordAndVerification\VerificationService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class VerificationController extends Controller {

    /**
     * @var VerificationService
     */
    protected $verificationService;

    /**
     * VerificationController constructor.
     * @param VerificationService $verificationService
     */
    public  function __construct(VerificationService $verificationService) {
        $this->verificationService = $verificationService;
    }

    /**
     * @return Application|Factory|View
     */
    public function emailVerificationView() {

        return view('auth.verify_email');
    }

    /**
     * @param VerifyEmailRequest $request
     * @return RedirectResponse
     */
    public function verifyEmailProcess(VerifyEmailRequest $request) {

        return $this->webResponse($this->verificationService->verifyEmailByCode($request),'signIn');
    }

    public function verifyEmail($id) {

        return $this->webResponse($this->verificationService->verifyEmailByLink($id),'signIn');
    }

}
