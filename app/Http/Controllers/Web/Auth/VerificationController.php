<?php


namespace App\Http\Controllers\Web\Auth;


use App\Http\Controllers\Controller;
use App\Http\Requests\Web\VerifyEmailRequest;
use App\Http\Services\web\Auth\VerificationService;
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
        $response = $this->verificationService->verifyEmailProcess($request);

        return !$response ?
            redirect()->back()->with($this->errorResponse($response["message"])) :
            redirect()->route('admin.dashboard')
                ->with($this->successResponse($response["message"]));
    }

}