<?php


namespace App\Http\Services\Auth\Web;


use App\Http\Services\Boilerplate\BaseService;
use App\Http\Services\UserService;
use App\Jobs\SendVerificationEmailJob;

class RegisterService extends BaseService {

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * RegisterService constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    /**
     * @param object $request
     * @return array
     */
    public function signUp(object $request): array {
        $createUserResponse = $this->userService->create($this->userService->prepareUserData($request));
        if (!$createUserResponse['success']) return $createUserResponse;

        dispatch(new SendVerificationEmailJob(
                $createUserResponse['data']->email_verification_code,
                $createUserResponse['data'])
        )->onQueue('email-send');

        return $createUserResponse;
    }
}

