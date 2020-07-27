<?php


namespace App\Http\Controllers\Api\Auth;


use App\Http\Services\Auth\PasswordAndVerification\ResetPasswordService;
use App\Http\Requests\Api\PasswordChangeRequest;
use App\Http\Requests\Api\ResetPasswordRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class ResetPasswordController extends Controller {

    /**
     * @var ResetPasswordService
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
    public function resetPasswordProcess(ResetPasswordRequest $request) {
        return response()->json($this->resetPasswordService->resetPasswordProcess($request));
    }

    /**
     * @param PasswordChangeRequest $request
     * @return JsonResponse
     */
    public function passwordChangeProcess(PasswordChangeRequest $request) {
       return response()->json($this->resetPasswordService->changePassword($request));
    }
}
