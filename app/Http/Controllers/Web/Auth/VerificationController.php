<?php


namespace App\Http\Controllers\Web\Auth;



use App\Http\Services\Auth\web\VerificationService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class VerificationController extends Controller {


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
        return $this->webResponse($this->verificationService->verifyEmailProcess($token),'web.auth.sign_in');
    }
}
