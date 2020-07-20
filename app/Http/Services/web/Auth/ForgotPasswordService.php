<?php


namespace App\Http\Services\web\Auth;


use App\Http\Repository\PasswordResetRepository;
use App\Http\Services\BaseService;
use App\Http\Services\UserService;
use App\Jobs\SendForgetPasswordEmailJob;
use Exception;

class ForgotPasswordService extends BaseService {
    /**
     * @var UserService
     */
    protected $userService;
    /**
     * @var PasswordResetRepository
     */
    protected $passwordResetRepository;

    /**
     * ForgotPasswordService constructor.
     * @param UserService $userService
     * @param PasswordResetRepository $passwordResetRepository
     */
    public function __construct(UserService $userService, PasswordResetRepository $passwordResetRepository) {
        $this->userService = $userService;
        $this->passwordResetRepository = $passwordResetRepository;
    }

    /**
     * @param object $request
     * @return array
     */
    public function sendForgetPasswordEmail(object $request) : array {
        try {
            $userResponse = $this->userService->userEmailExists($request->email);

            if (!$userResponse) return $userResponse;
            $randNo = randomNumber(6);
            dispatch(new SendForgetPasswordEmailJob($randNo, $userResponse['data']));

            return $this->storePasswordResetCode($userResponse['data'],$randNo);
        } catch (Exception $e) {

            return $this->jsonResponse()->error();
        }
    }

    /**
     * @param object $user
     * @param int $randNo
     * @return array
     */
    private function storePasswordResetCode(object $user, int $randNo) : array {
        $storePasswordResetResponse = $this->passwordResetRepository->
        storePasswordResetCode($user->id, $randNo);

        return !$storePasswordResetResponse ? $this->jsonResponse()->error() :
            $this->jsonResponse()->success('Code has been sent to ' . ' ' . $user->email);
    }

}