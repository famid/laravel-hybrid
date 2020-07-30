<?php


namespace App\Http\Controllers\Web\Auth;


use App\Http\Services\Auth\Password\VerificationService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
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
     * @param $token
     * @return RedirectResponse
     */
    public function verifyEmailProcess($token) {
        return $this->webResponse($this->verificationService->verifyEmailByLink($token),'web.auth.sign_in');
    }
}
