<?php


namespace App\Http\Services;

use App\Http\Repository\PasswordResetRepository;
use App\Http\Repository\UserRepository;
use App\Jobs\SendForgetPasswordEmailJob;
use App\Jobs\SendVerificationEmailJob;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Exception;

class AuthService extends  BaseService {
    protected $userRepository;
    protected $passwordResetRepository;
    public $errorMessage;
    public $errorResponse;
    protected $defaultEmail;
    protected $defaultName;
    protected $logo;

    /**
     * AuthService constructor.
     * @param UserRepository $userRepository
     * @param PasswordResetRepository $passwordResetRepository
     */
    public function __construct(UserRepository $userRepository,
                                PasswordResetRepository $passwordResetRepository) {
        $this->userRepository = $userRepository;
        $this->passwordResetRepository = $passwordResetRepository;
        $this->errorMessage = __('Something went wrong');
        $this->errorResponse = ['success' => false, 'message' => $this->errorMessage, 'data' => []];
        $this->defaultEmail = config('email.defaultEmail');
        $this->defaultName = config('email.defaultName');
        $this->logo = asset(config('defaultemailcredentials.logo'));
    }

    /**
     * @param Request $request
     * @return array
     */
    public function signUp(Request $request) :array {
        try {
           $user = $this->createUser($request);
           if (!$user['success']) return $user;
            dispatch(new SendVerificationEmailJob(
                $user['data']['randNo'],

                $user['data']['user']

            ))->onQueue('email-send');

            return [
                'success' => true,
                'message' => __("Successfully Signed up! \n Please verify your account")
            ];
        } catch (Exception $exception) {

            return $this->errorResponse;
        }
    }

    /**
     * @param $request
     * @return array
     */
    protected function createUser($request) :array {
        $validationResponse = $this->validateUserEmailAndPhone($request->email, $request->phone);
        if ($validationResponse['success']) return $validationResponse;

        $insert = $this->preparedCreateUserData($request);
        $user = $this->userRepository->create($insert);

        return !$user ? $this->errorResponse :
            [
                'success' => true,
                'data' => ['user' => $user , 'randNo' => $insert['email_verification_code']]
            ];
    }

    /**
     * @param $email
     * @param $phone
     * @return array|bool[]
     */
    private function validateUserEmailAndPhone($email, $phone) :array{
        $hasUserEmail = $this->userEmailExists($email);

        if ($hasUserEmail['success']) return $hasUserEmail;
        $hasUserPhoneResponse = $this->userPhoneExists($phone);

        if ($hasUserPhoneResponse['success']) return $hasUserPhoneResponse;

        return ['success' => false];
    }

    /**
     * @param $email
     * @return array
     */
    private function userEmailExists($email) :array {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $where = ['email' => $email];
        } else {
            $where = ['username' => $email];
        }
        $user = $this->userRepository->getUser($where);

        return empty($user) ? ['success' => false, 'message' =>  __('User not found')]:
            ['success' => true ,'user' => $user,'message' => __('This email is already used')];
    }

    /**
     * @param $phone
     * @return array
     */
    private function userPhoneExists($phone) :array {
        $where = ['phone' => $phone];
        $phone = $this->userRepository->getUser($where);

        return empty($user) ? ['success' => false, 'message' =>  __('User not found')]:
            ['success' => true ,'user' => $phone, 'message' => __('This phone number is already used')];
    }

    /**
     * @param $request
     * @return array
     */
    private function preparedCreateUserData($request) :array {
        $randNo = randomNumber(6);

        return [
            'email' => $request->email,
            'phone_code' => $request->phone_code,
            'phone' => $request->phone,
            'password' => Hash::make($request->get('password')),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'role' => USER_ROLE,
            'status' => USER_PENDING_STATUS,
            'email_verification_code' => $randNo,
        ];
    }

    /**
     * @param $request
     * @return array
     */
    public function signInProcess($request) :array {
        try {
            $credentials = $this->credentials($request->except('_token'));
            $valid = Auth::attempt($credentials);
            if (!$valid) return $this->errorResponse;
            $routeName= $this->getRouteName(Auth::user());

            return [
                'success' => true,
                'message' => __('Congratulations! You have signed in successfully.'),
                'routeName' => $routeName
            ];
        } catch (Exception $e) {

            return $this->errorResponse;
        }
    }

    /**
     * @param $data
     * @return array
     */
    private function credentials($data) {

        return filter_var($data['email'], FILTER_VALIDATE_EMAIL) ?
            ['email' => $data['email'], 'password' => $data['password']] :
            ['user_name' => $data['email'], 'password' => $data['password']];

    }

    /**
     * @param $user
     * @return bool|string
     */
    private function getRouteName ($user) {

        return ($user->role === ADMIN_ROLE  ? 'admin.dashboard' :
            ($user->role === USER_ROLE  ? 'user.dashboard' :
                'login'));
    }

    /**
     * @param $request
     * @return array
     */
    public function sendForgetPasswordEmail($request) :array {
        $validateEmailResponse = $this->validateForgetPasswordEmail($request->email);

        if(!$validateEmailResponse) return $validateEmailResponse;
        $randNo = randomNumber(6);
        try {
            dispatch(new SendForgetPasswordEmailJob(
                $randNo, $this->defaultName,
                $this->logo,
                $validateEmailResponse['user'],
                $this->defaultEmail
            ));
         return $this->storePasswordResetCode($validateEmailResponse['user'],$randNo);
        } catch (Exception $exception) {

            return $this->errorResponse;
        }
    }

    /**
     * @param $email
     * @return array
     */
    private function validateForgetPasswordEmail($email) :array {
        $userExistenceResponse = $this->userEmailExists($email);

        if (!$userExistenceResponse ['success']) return $userExistenceResponse ;
        $user = $userExistenceResponse ['user'];
        if ($user->role == ADMIN_ROLE) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                return [
                    'success' => false,
                    'message' =>  __('Please enter your username instead of email')
                ];
            }
        }

        return ['success' => true, 'user' => $user];
    }

    /**
     * @param $user
     * @param $randNo
     * @return array
     */
    private function storePasswordResetCode($user, $randNo) :array{
        $storePasswordResetResponse = $this->passwordResetRepository->storePasswordResetCode(
            $user->id, $randNo);

        return !$storePasswordResetResponse ? $this->errorResponse :
            ['success' => true, 'message' =>  __('Code has been sent to ') . ' ' . $user->email];
    }

    /**
     * @param $request
     * @return array
     */
    public function resetPasswordProcess ($request) {
        try {
            $passwordResetCodeResponse= $this->getPasswordResetCode($request->reset_password_code);

            if(!$passwordResetCodeResponse['success']) return $passwordResetCodeResponse;
            $passwordResetCode = $passwordResetCodeResponse['passwordResetCode'];
            $user = $this->userRepository->firstWhere(['id' => $passwordResetCode->user_id]);
            if (empty($user)) {

                return ['success' => false, 'message' => __('No user found')];
            }

            return $this->resetPassword($user->id,$request->new_password, $passwordResetCode->id);
        } catch (Exception $e) {

            return $this->errorResponse;
        }

    }


    /**
     * @param int $userId
     * @param string $newPassword
     * @param int $passwordResetCodeId
     * @return array
     */
    private function resetPassword(int $userId,string $newPassword, int $passwordResetCodeId) : array {
        try {
            DB::beginTransaction();
            if (!$this->updatePassword($userId,$newPassword)) throw new Exception($this->errorResponse);
            $updatePasswordResetStatus = $this->passwordResetRepository->updateStatus(
                $passwordResetCodeId, ACTIVE_STATUS);
            if (!$updatePasswordResetStatus) throw new Exception($this->errorResponse);
            DB::commit();

            return ['success' => true, 'message' => __('Password is reset successfully')];
        } catch (Exception $e) {
            DB::rollBack();

            return $this->errorResponse;
        }
    }

    /**
     * @param $resetPasswordCode
     * @return array
     */
    private function getPasswordResetCode ($resetPasswordCode) :array {
        $validateResponse = $this->validatePasswordResetCode($resetPasswordCode);
        if (!$validateResponse['success']) return $validateResponse;
        $passwordResetCode = $validateResponse['passwordResetCode'];
        $totalDuration = Carbon::now()->diffInMinutes($passwordResetCode->created_at);

        return  $totalDuration > EXPIRE_TIME_OF_FORGET_PASSWORD_CODE ?
            ['success' => false, 'message' => __('Your code has been expired. Please give your code with in') . EXPIRE_TIME_OF_FORGET_PASSWORD_CODE . __('minutes')] :
            ['success' => true , 'passwordResetCode' => $passwordResetCode];
    }

    /**
     * @param $resetPasswordCode
     * @return array
     */
    private function validatePasswordResetCode($resetPasswordCode) {
        $passwordResetCode = $this->passwordResetRepository->getPasswordResetCode($resetPasswordCode);
        $latestResetCode = $this->passwordResetRepository->getUserLatestResetCode($passwordResetCode->user_id);
        $resetCodeIsCorrect = empty($latestResetCode) || empty($passwordResetCode) ||
            $latestResetCode->verification_code != $resetPasswordCode;

        return !$resetCodeIsCorrect ?
            ['success' => false, 'message' => __('Your given reset password code is incorrect')] :
            ['success' => true, 'passwordResetCode' => $passwordResetCode];
    }

    /**
     * @param $request
     * @return array
     */
    public function changePassword($request) {
        try {
            $user = Auth::user();
            if (!Hash::check($request->old_password, $user->password)) {

                return ['success' => false, 'message' => __('Your given old password is incorrect')];
            }

            return !$this->updatePassword($user->id,$request->new_password) ? $this->errorResponse :
            ['success' => true, 'message' => __('Password is changed successfully')];
        } catch (Exception $e) {

            return $this->errorResponse;
        }
    }

    /**
     * @param $userId
     * @param $newPassword
     * @return bool
     */
    private function updatePassword($userId, $newPassword) {
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

}

/**
 * @param $request
 * @return array
 */
/*private function userEmailAndPhoneExists($request) :array {
    //$where = ['email' => $request->email, 'social_network_type' => $request->social_network_type];
    $where = ['email' => $request->email];

    $hasEmail = $this->userRepository->getUser($where);
    if (!empty($hasEmail)) {

        return ['success' => false, 'message' => __('This email is already used')];
    }
    $where = ['phone' => $request->phone];
    $hasPhone = $this->userRepository->getUser($where);
    if (!empty($hasPhone)) {

        return ['success' => false, 'message' => __('This phone number is already used')];
    }

    return ['success' => true, 'data' => null];
}*/

/**
 * @param $request
 * @return array
 */
/*public function forgetPasswordProcess($request) :array {
    try {
        $passwordResetCode = $this->validatePasswordResetProcess($request->reset_password_code);
        if (!$passwordResetCode['success']) return $passwordResetCode;

        return $this->resetPassword($request->new_password, $passwordResetCode->id);
    } catch (Exception $e) {

        return $this->errorResponse;
    }
}*/
/**
 * @param string $reset_password_code
 * @return array
 */
/* private function validatePasswordResetProcess(string $reset_password_code) :array {
     $passwordResetCodeResponse = $this->getPasswordResetCode($reset_password_code);

     if(!$passwordResetCodeResponse['success']) return $passwordResetCodeResponse;
     $passwordResetCode = $passwordResetCodeResponse['passwordResetCode'];
     $user = $this->userRepository->getUserById($passwordResetCode->user_id);
     if (empty($user)) {

         return ['success' => false, 'message' => __('No user found')];
     }

     return ['success' => true, 'passwordResetCode' => $passwordResetCode];
 }*/
