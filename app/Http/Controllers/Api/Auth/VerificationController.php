<?php

namespace App\Http\Controllers\Api\Auth;


use App\Http\Requests\Api\VerifyEmailRequest;
use App\Http\Controllers\Controller;
use App\Http\Services\Auth\PasswordAndVerification\VerificationService;
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
    public function verifyEmailProcess(VerifyEmailRequest $request) {

        return response()->json($this->verificationService->verifyEmailByCode($request));
    }

}
