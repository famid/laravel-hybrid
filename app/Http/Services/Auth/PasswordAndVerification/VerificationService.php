<?php


namespace App\Http\Services\Auth\PasswordAndVerification;


use App\Http\Repository\UserRepository;
use App\Http\Services\UserService;
use App\Http\Services\BaseService;
use Exception;

class VerificationService extends BaseService {

    /**
     * @var
     */
    protected $userRepository;

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * VerificationService constructor.
     * @param UserRepository $userRepository
     * @param UserService $userService
     */
    public function __construct(UserRepository $userRepository,UserService $userService) {
        $this->userRepository = $userRepository;
        $this->userService = $userService;
    }

    /**
     * @param object $request
     * @return array
     */

    public function verifyEmailByCode (object $request) :array {
        try {
            $userResponse = $this->userService->userEmailExists($request->email);
            $user = $userResponse['data'];
            $emailVerifiedResponse = $this->userService->checkUserEmailIsVerified($user);

            if ($emailVerifiedResponse) return $this->response()->error('your Email is already verified');

            return $user->email_verification_code != $request->email_verification_code ?
                $this->response()->error('Invalid verification code.') :
                $this->updateEmailVerificationCodeAndStatus($user);
        } catch (Exception $e) {

            Return $this->response()->error();
        }
    }

    /**
     * @param object $user
     * @return array
     */
    private function updateEmailVerificationCodeAndStatus(object $user) :array {
        $updateStatusResponse = $this->userRepository->updateWhere([
            'id' => $user->id,
            'email_verified' => PENDING_STATUS
        ],[
            'email_verification_code' => null,'email_verified' => ACTIVE_STATUS
        ]);

        return !$updateStatusResponse ?
            $this->response()->error():
            $this->response()->success('Your Email is Verified');
    }

    /**
     * @param $id
     * @return array
     */
    public function verifyEmailByLink($id) {
        $user = $this->userRepository->find(decrypt($id));
        if(!isset($user)) return $this->response()->error();
        $emailVerifiedResponse = $this->userService->checkUserEmailIsVerified($user);

        return !$emailVerifiedResponse ?
            $this->updateEmailVerificationCodeAndStatus($user) :
            $this->response()->error('your Email is already verified');
    }

}
