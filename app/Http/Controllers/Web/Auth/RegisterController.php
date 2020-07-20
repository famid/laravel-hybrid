<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\SignUpRequest;
use App\Http\Services\web\Auth\RegisterService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RegisterController extends Controller {
    /**
     * @var RegisterService
     */
    protected $registerService;

    /**
     * RegisterController constructor.
     * @param RegisterService $registerService
     */
    public function __construct(RegisterService $registerService) {
        $this->registerService = $registerService;
    }

    /**
     * @return Application|Factory|View
     */
    public function signUp() {

        return view('auth.register');
    }

    /**
     * @param SignUpRequest $request
     * @return RedirectResponse
     */
    public function signUpProcess(SignUpRequest $request) {
        $response = $this->registerService->signUp($request);

        return !$response['success'] ?  redirect()->back()->with($this->errorResponse()) :
            redirect()->route('singIn')->with($this->successResponse($response['message']));
    }
}
