<?php


namespace App\Http\Controllers\Api\Auth;


use App\Http\Services\Auth\Api\SocialRegisterService;
use App\Http\Requests\Api\SocialUserResolverRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class SocialRegisterController extends Controller {

    /**
     * @var SocialRegisterService
     */
    protected $socialRegister;

    /**
     * SocialRegisterController constructor.
     * @param SocialRegisterService $socialRegister
     */
    public function __construct(SocialRegisterService $socialRegister) {
        $this->socialRegister = $socialRegister;
    }

    /**
     * @param SocialUserResolverRequest $request
     * @return JsonResponse
     */
    public function socialSignUp(SocialUserResolverRequest $request): JsonResponse {
        return response()->json($this->socialRegister->socialRegistration($request));
    }
}
