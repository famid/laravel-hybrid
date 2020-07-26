<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Services\Auth\Api\LoginService;
use App\Http\Requests\Api\SignInRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;


class LoginController extends Controller {
    /**
     * @var LoginService
     */
    protected $loginService;

    /**
     * LoginController constructor.
     * @param LoginService $loginService
     */
    public function __construct(LoginService $loginService) {
        $this->loginService = $loginService;
    }

    /**
     * @param SignInRequest $request
     * @return JsonResponse
     */
    public function signInProcess(SignInRequest $request) {

        return response()->json($this->loginService->signInProcess($request));
    }

}
