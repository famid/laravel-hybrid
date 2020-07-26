<?php

namespace App\Http\Controllers\Api\Auth;


use App\Http\Requests\Api\PasswordChangeRequest;
use App\Http\Services\Auth\PasswordAndVerification\ResetPasswordService;
use App\Http\Requests\Api\ResetPasswordRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;


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
     * @param ResetPasswordRequest $request
     * @return JsonResponse
     */
    public function resetPassword(ResetPasswordRequest $request) {
        $response = $this->resetPasswordService->resetPasswordProcess($request);

        return response()->json($response);
    }


    public function passwordChangeProcess(PasswordChangeRequest $request) {
        $response = $this->resetPasswordService->changePassword($request);

        return response()->json($response);
    }
}
