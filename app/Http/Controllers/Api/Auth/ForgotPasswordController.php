<?php


namespace App\Http\Controllers\Api\Auth;


use App\Http\Services\Auth\PasswordAndVerification\ForgotPasswordService;
use App\Http\Requests\Api\ForgetPasswordRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

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
     * @param ForgetPasswordRequest $request
     * @return JsonResponse
     */
    public function forgetPasswordEmailSendProcess(ForgetPasswordRequest $request) {
        return response()->json($this->forgotPasswordService->sendForgetPasswordEmail($request));
    }
}
