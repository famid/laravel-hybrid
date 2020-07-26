<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use App\Http\Services\Auth\web\RegisterService;
use App\Http\Requests\Web\SignUpRequest;
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
    public function signUpProcess(SignUpRequest $request)  {
        $response = $this->registerService->signUp($request);

        return $this->webResponse($response, 'signIn');
    }
}
