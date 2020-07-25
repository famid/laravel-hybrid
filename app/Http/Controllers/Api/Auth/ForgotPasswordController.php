<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Services\Auth\web\ForgotPasswordService;
use App\Http\Requests\Api\ForgetPasswordRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

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
     * @param ForgetPasswordRequest $request
     * @return JsonResponse
     */
    public function forgetPasswordEmailSendProcess(ForgetPasswordRequest $request) {
        $response = $this->forgotPasswordService->sendForgetPasswordEmail($request);

        return response()->json($response);

    }
}
