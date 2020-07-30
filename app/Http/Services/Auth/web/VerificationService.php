<?php


namespace App\Http\Services\Auth\web;


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
     * @param object $request
     * @return array
     */
    public function resendEmailVerificationCode(object $request) :array {
        try {
            $userResponse = $this->userService->validateUserEmail($request->email);
            if(!$userResponse['success']) return $userResponse;
            dispatch(new SendVerificationEmailJob(
                    $userResponse['data']->email_verification_code,
                    $userResponse['data'])
            )->onQueue('email-send');

            return $this->response()->success('Email verification code is resend');
        } catch (Exception $e) {

            return $this->response()->error();
        }
    }

    /**
     * here user verify their email by link
     *
     * @param $id
     * @return array
     */
    public function verifyEmailProcess($id) {
        try {
            $userResponse = $this->userService->getUserById(decrypt($id));
            $emailVerifiedResponse = $this->userService->checkUserEmailIsVerified($userResponse['data']);

            return !$emailVerifiedResponse ?
                $this->userService->updateEmailVerificationCodeAndStatus($userResponse['data'],ACTIVE_STATUS) :
                $this->response()->error('your Email is already verified');
        } catch (Exception $e) {

            return $this->response()->error();
        }
    }
}
