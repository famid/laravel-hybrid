<?php


namespace App\Http\Services\Auth\Password;


use App\Http\Repositories\PasswordResetRepository;
use App\Http\Services\Boilerplate\BaseService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Http\Services\UserService;
use Carbon\Carbon;
use Exception;

class ResetPasswordService extends BaseService {

    /**
     * @var PasswordResetRepository
     */
    protected $passwordResetRepository;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * ResetPasswordService constructor.
     * @param UserService $userService
     * @param PasswordResetRepository $passwordResetRepository
     */
    public function __construct(UserService $userService, PasswordResetRepository $passwordResetRepository) {
        $this->userService = $userService;
        $this->passwordResetRepository = $passwordResetRepository;
    }

    /**
     * this method first check user email is exists or not by calling the method "userEmailExists" if exists
     * then set user id then check the user given password reset code is correct by calling the method
     * "getPasswordResetCode"  if it's correct then reset the password by calling the method "resetPassword"
     *
     * @param object $request
     * @return array
     */
    public function resetPasswordProcess (object $request): array {
        try {
            $userResponse = $this->userService->userEmailExists($request->email);
            if (!$userResponse['success']) return $userResponse;
            $userId = $userResponse['data']->id;
            $passwordResetCodeResponse= $this->getPasswordResetCode($userId,(int)$request->reset_password_code);

            return !$passwordResetCodeResponse['success'] ? $passwordResetCodeResponse :
                $this->resetPassword($userId,$request->new_password, $passwordResetCodeResponse['data']->id);
        } catch (Exception $e) {

            return $this->response()->error();
        }
    }

    /*
     * @param int $userId
     * @param int $resetPasswordCodeFromUser
     * @return array
     */
    private function getPasswordResetCode (int $userId, int $resetPasswordCodeFromUser): array {
        $validatePasswordResetCodeFromUser = $this->passwordResetCodeIsCorrect(
            $userId,
            $resetPasswordCodeFromUser
        );
        if (!$validatePasswordResetCodeFromUser['success']) return $validatePasswordResetCodeFromUser;
        $passwordResetCode = $validatePasswordResetCodeFromUser['data'];
        $codeExpiredResponse = $this->checkPasswordResetCodeIsExpired($passwordResetCode->created_at);

        return !$codeExpiredResponse['success'] ? $codeExpiredResponse:
            $this->response($passwordResetCode)->success();
    }

    /**
     * first query for user given reset password code  is exits in database  after
     * fetch the latest reset password code for user  by user id then
     * check  reset password code from user  is match with latest reset password code
     *
     * @param int $userId
     * @param int $resetPasswordCodeFromUser
     * @return array
     */
    private function passwordResetCodeIsCorrect(int $userId,int $resetPasswordCodeFromUser): array {
        $passwordResetCode = $this->passwordResetRepository->firstWhere(
            [
                'user_id' => $userId,
                'verification_code' => $resetPasswordCodeFromUser,
                'status' => PENDING_STATUS
            ]
        );
        if (is_null($passwordResetCode)) return $this->response()->error('This code is already used once');
        $latestResetCode = $this->passwordResetRepository->getUserLatestResetCode($userId);
        $resetCodeIsNotCorrect = empty($latestResetCode) || empty($passwordResetCode) ||
            $latestResetCode->verification_code != $resetPasswordCodeFromUser;

        return $resetCodeIsNotCorrect ?
            $this->response()->error('Your given reset password code is incorrect') :
            $this->response($passwordResetCode)->success();
    }

    /**
     * @param $createAt
     * @return array
     */
    private function checkPasswordResetCodeIsExpired ($createAt): array {
        $totalDuration = Carbon::now()->diffInMinutes($createAt);

        return $totalDuration > EXPIRE_TIME_OF_FORGET_PASSWORD_CODE ?
            $this->response()->error('Your code has been expired. Please give your code with in 10 minutes'):
            $this->response()->success();
    }

    /**
     * This method first update the password in user table and then update the status(set active status)
     * in password_reset table
     *
     * @param int $userId
     * @param string $newPassword
     * @param int $passwordResetCodeId
     * @return array
     */
    private function resetPassword(int $userId, string $newPassword, int $passwordResetCodeId): array {
        try {
            DB::beginTransaction();
            if (!$this->userService->updatePassword($userId,$newPassword)) throw new Exception(
                $this->response()->error());
            $updatePasswordResetStatus = $this->passwordResetRepository->updateWhere(
                ['id' => $passwordResetCodeId],
                ['status' => ACTIVE_STATUS]
            );
            if (!$updatePasswordResetStatus) throw new Exception($this->response()->error());
            DB::commit();

            return $this->response()->success('Password is reset successfully');
        } catch (Exception $e) {
            DB::rollBack();

            return $this->response()->error();
        }
    }

    /**
     * @param object $request
     * @return array
     */
    public function changePassword(object $request): array {
        try {
            $user = (object) Auth::user();
            if (!Hash::check($request->old_password, $user->password)) return $this->response()
                ->error('Your given old password is incorrect');

            return !$this->userService->updatePassword($user->id,$request->new_password) ?
                $this->response()->error() :
                $this->response()->success('Password is changed successfully');
        } catch (Exception $e) {

            return $this->response()->error();
        }
    }
}
