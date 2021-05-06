<?php


namespace App\Http\Controllers\Api\Auth;


use App\Http\Requests\Api\ForgetPasswordRequest;
use App\Http\Services\Auth\Api\VerificationService;
use App\Http\Requests\Api\VerifyEmailRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

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
     * @param VerifyEmailRequest $request
     * @return JsonResponse
     */
    public function verifyEmailProcess(VerifyEmailRequest $request): JsonResponse {
        return response()->json($this->verificationService->verifyEmailProcess($request));
    }

    /**
     * @param ForgetPasswordRequest $request
     * @return JsonResponse
     */
    public function resendEmailVerificationCode(ForgetPasswordRequest $request): JsonResponse {
        return response()->json($this->verificationService->resendEmailVerificationCode($request));
    }
}
