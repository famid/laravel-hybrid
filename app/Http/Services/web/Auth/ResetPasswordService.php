<?php


namespace App\Http\Services\web\Auth;


use App\Http\Repository\PasswordResetRepository;
use App\Http\Repository\UserRepository;
use App\Http\Services\BaseService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ResetPasswordService extends BaseService {
    /**
     * @var UserRepository
     */
    protected $userRepository;
    /**
     * @var PasswordResetRepository
     */
    protected $passwordResetRepository;


    /**
     * ResetPasswordService constructor.
     * @param UserRepository $userRepository
     * @param PasswordResetRepository $passwordResetRepository
     */
    public function __construct(UserRepository $userRepository,
                                PasswordResetRepository $passwordResetRepository) {
        $this->userRepository = $userRepository;
        $this->passwordResetRepository = $passwordResetRepository;
    }

    /**
     * this method first get the password_reset id then  get the user id then call password reset
     *
     * method
     * @param object $request
     * @return array
     */
    public function resetPasswordProcess (object $request) {
        try {
            $passwordResetCodeResponse= $this->getPasswordResetCode($request->reset_password_code);
            if(!$passwordResetCodeResponse['success']) return $passwordResetCodeResponse;
            $passwordResetCode = $passwordResetCodeResponse['data'];
            $user = $this->userRepository->firstWhere(['id' => $passwordResetCode->user_id]);

            return empty($user) ? $this->jsonResponse()->error('No user found'):
                $this->resetPassword($user->id,$request->new_password, $passwordResetCode->id);
        } catch (Exception $e) {

            return $this->jsonResponse()->error();
        }

    }

    /**
     * @param int $resetPasswordCodeFromUser
     * @return array
     */
    private function getPasswordResetCode (int $resetPasswordCodeFromUser) :array {
        $validatePasswordResetCodeFromUser = $this->passwordResetCodeIsCorrect($resetPasswordCodeFromUser);

        if (!$validatePasswordResetCodeFromUser['success']) return $validatePasswordResetCodeFromUser;
        $passwordResetCode = $validatePasswordResetCodeFromUser['data'];
        $codeExpiredResponse = $this->checkPasswordResetCodeIsExpired($passwordResetCode->created_at);

        return !$codeExpiredResponse['success'] ? $codeExpiredResponse:
            $this->jsonResponse($passwordResetCode)->success();
    }

    /**
     * @param int $resetPasswordCodeFromUser
     * @return array
     */
    private function passwordResetCodeIsCorrect(int $resetPasswordCodeFromUser) :array {
        $passwordResetCode = $this->passwordResetRepository->getPasswordResetCode($resetPasswordCodeFromUser);

        if (is_null($passwordResetCode)) return $this->jsonResponse()->error('This code is already used once');
        $latestResetCode = $this->passwordResetRepository->getUserLatestResetCode($passwordResetCode->user_id);
        $resetCodeIsNotCorrect = empty($latestResetCode) || empty($passwordResetCode) ||
            $latestResetCode->verification_code != $resetPasswordCodeFromUser;

        return $resetCodeIsNotCorrect ?
            $this->jsonResponse()->error('Your given reset password code is incorrect') :
            $this->jsonResponse($passwordResetCode)->success();
    }

    /**
     * @param $createAt
     * @return array
     */
    private function checkPasswordResetCodeIsExpired ($createAt) :array {
        $totalDuration = Carbon::now()->diffInMinutes($createAt);

        return $totalDuration > EXPIRE_TIME_OF_FORGET_PASSWORD_CODE ?
            $this->jsonResponse()->error('Your code has been expired. Please give your code with in'):
            $this->jsonResponse()->success();
    }

    /**
     * This method first update the password in user table and then update the status(active status)
     * in password_reset table
     *
     * @param int $userId
     * @param string $newPassword
     * @param int $passwordResetCodeId
     * @return array
     */
    private function resetPassword(int $userId, string $newPassword, int $passwordResetCodeId) : array {
        try {
            DB::beginTransaction();
            if (!$this->updatePassword($userId,$newPassword)) throw new Exception
            ($this->jsonResponse()->error());
            $updatePasswordResetStatus = $this->passwordResetRepository->updatePasswordResetStatus(
                $passwordResetCodeId, ACTIVE_STATUS);
            if (!$updatePasswordResetStatus) throw new Exception($this->jsonResponse()->error());
            DB::commit();

            return $this->jsonResponse()->success('Password is reset successfully');
        } catch (Exception $e) {
            DB::rollBack();

            return $this->jsonResponse()->error();
        }
    }

    /**
     * @param int $userId
     * @param string $newPassword
     * @return bool
     */
    private function updatePassword(int $userId, string $newPassword) {
        try {
            $updatePasswordResponse = $this->userRepository->updateWhere(
                ['id' => $userId],
                ['password' => Hash::make($newPassword)]
            );

            return !$updatePasswordResponse ? false : true;
        } catch (Exception $e) {

            return false;
        }
    }

    /**
     * @param object $request
     * @return array
     */
    public function changePassword(object $request) {
        try {
            $user = (object) Auth::user();
            if (!Hash::check($request->old_password, $user->password)) return $this->jsonResponse()
                ->error('Your given old password is incorrect');

            return !$this->updatePassword($user->id,$request->new_password) ? $this->jsonResponse()->error() :
                $this->jsonResponse()->success('Password is changed successfully');
        } catch (Exception $e) {

            return $this->jsonResponse()->error();
        }
    }

}