<?php


namespace App\Http\Controllers\Api\Auth;


use App\Http\Services\Auth\Api\RegisterService;
use App\Http\Requests\Api\SignUpRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

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
     * @param SignUpRequest $request
     * @return JsonResponse
     */
    public function signUpProcess(SignUpRequest $request): JsonResponse {
        return response()->json($this->registerService->signUp($request));
    }
}
