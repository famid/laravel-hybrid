<?php


namespace App\Http\Controllers\Api\Auth;


use App\Http\Services\Auth\Api\LogoutService;
use App\Http\Services\Auth\Api\LoginService;
use App\Http\Requests\Api\SignInRequest;
use App\Http\Requests\Api\LogoutRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller {

    /**
     * @var LoginService
     */
    protected $loginService;

    /**
     * @var LogoutService
     */
    private $logoutService;

    /**
     * LoginController constructor.
     * @param LoginService $loginService
     * @param LogoutService $logoutService
     */
    public function __construct(LoginService $loginService, LogoutService $logoutService) {
        $this->loginService = $loginService;
        $this->logoutService = $logoutService;
    }

    /**
     * @param SignInRequest $request
     * @return JsonResponse
     */
    public function signInProcess(SignInRequest $request): JsonResponse {
        return response()->json($this->loginService->signIn($request));
    }

    /**
     * @param LogoutRequest $request
     * @return JsonResponse
     */
    public function signOut(LogoutRequest $request): JsonResponse {
        return response()->json($this->logoutService->logout($request));
    }
}
