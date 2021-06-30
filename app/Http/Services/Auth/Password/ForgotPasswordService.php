<?php


namespace App\Http\Services\Auth\Password;


use App\Http\Repositories\PasswordResetRepository;
use App\Http\Services\Boilerplate\BaseService;
use App\Jobs\SendForgetPasswordEmailJob;
use App\Http\Services\UserService;
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
    public function sendForgetPasswordEmail(object $request): array {
        try {
            $userResponse = $this->userService->userEmailExists($request->email);
            if (!$userResponse['success']) return $userResponse;
            if(is_null($userResponse['data']->password))
                return $this->response()->error("you are only a social user you don't have any password");
            $randNo = randomNumber(6);
            dispatch(new SendForgetPasswordEmailJob($randNo, $userResponse['data']));

            return $this->savePasswordResetCode($userResponse['data'], $randNo);
        } catch (Exception $e) {

            return $this->response()->error();
        }
    }

    /**
     * @param object $user
     * @param int $randNo
     * @return array
     */
    private function savePasswordResetCode(object $user, int $randNo): array {
        $storePasswordResetResponse = $this->passwordResetRepository->create(
            [
                'user_id' => $user->id,
                'verification_code' => $randNo
            ]
        );

        return !$storePasswordResetResponse ? $this->response()->error() :
            $this->response($user->email)->success('Code has been sent to ' . ' ' . $user->email);
    }
}
