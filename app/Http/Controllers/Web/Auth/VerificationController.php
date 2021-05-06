<?php


namespace App\Http\Controllers\Web\Auth;


use App\Http\Services\Auth\Web\VerificationService;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;

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
     * @param $encryptUserId
     * @return RedirectResponse
     */
    public function verifyEmailProcess($encryptUserId): RedirectResponse {
        return $this->webResponse($this->verificationService->verifyEmailProcess($encryptUserId),'web.auth.sign_in');
    }
}
