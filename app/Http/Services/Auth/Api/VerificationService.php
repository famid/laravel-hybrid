<?php


namespace App\Http\Services\Auth\Api;


use App\Http\Services\Boilerplate\BaseService;
use App\Jobs\SendVerificationEmailJob;
use App\Http\Services\UserService;
use Exception;

class VerificationService extends BaseService {

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * VerificationService constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    /**
     * here user will be send code to verify their email
     *
     * @param object $request
     * @return array
     */

    public function verifyEmailProcess (object $request): array {
        try {
            $userResponse = $this->userService->validateUserEmail($request->email);
            if(!$userResponse['success']) return $userResponse;
            $user = $userResponse['data'];

            return $user->email_verification_code != $request->email_verification_code ?
                $this->response()->error('Invalid verification code.') :
                $this->userService->updateEmailVerificationCodeAndStatus($user,ACTIVE_STATUS);
        } catch (Exception $e) {

            Return $this->response()->error();
        }
    }

    /**
     * @param object $request
     * @return array
     */
    public function resendEmailVerificationCode(object $request): array {
        try {
            $userResponse = $this->userService->validateUserEmail($request->email);
            if(!$userResponse['success']) return $userResponse;
            $emailVerificationCode = randomNumber(6);
            $updateResponse = $this->userService->updateEmailVerificationCodeAndStatus(
                $userResponse['data'],
                PENDING_STATUS,
                $emailVerificationCode
            );
            if(!$updateResponse['success']) return $updateResponse;
            dispatch(new SendVerificationEmailJob($emailVerificationCode, $userResponse['data']))
                ->onQueue('email-send');

            return $this->response()->success('Email verification code is resend');
        } catch (Exception $e) {

            return $this->response()->error();
        }
    }
}
