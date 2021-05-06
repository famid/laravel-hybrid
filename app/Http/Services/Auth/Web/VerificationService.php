<?php


namespace App\Http\Services\Auth\Web;


use App\Http\Services\Boilerplate\BaseService;
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
     * user email is verified by link
     *
     * @param string $encryptUserId
     * @return array
     */
    public function verifyEmailProcess(string $encryptUserId): array {
        try {
            $userResponse = $this->userService->getUserById(decrypt($encryptUserId));
            $emailVerifiedResponse = $this->userService->checkUserEmailIsVerified($userResponse['data']);

            return !$emailVerifiedResponse ?
                $this->userService->updateEmailVerificationCodeAndStatus($userResponse['data'],ACTIVE_STATUS) :
                $this->response()->error('your Email is already verified');
        } catch (Exception $e) {

            return $this->response()->error();
        }
    }
}
