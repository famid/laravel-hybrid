<?php


namespace App\Http\Services;


use App\Http\Services\Boilerplate\BaseService;
use App\Http\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Exception;

class UserService extends BaseService {

    /**
     * UserService constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository) {
        $this->repository = $userRepository;
    }

    /**
     * @param object $request
     * @param int|null $emailVerificationCode
     * @return array
     */
    public function prepareUserData(object $request, int $emailVerificationCode = null): array {
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
            'email_verification_code' => $emailVerificationCode
        ];
    }

    /**
     * @param object $providerUser
     * @return array
     */
    public function prepareSocialUserData(object $providerUser): array {
        return [
            'email' => $providerUser->getEmail(),
            'username' => empty(!$providerUser->getName()) ? $providerUser->getName()
                :$providerUser->getNickname(),
            'role' => USER_ROLE,
            'status' => ACTIVE_STATUS,
        ];
    }

    /**
     * @param array $userData
     * @return array
     */
    public function create(array $userData): array {
        try {
            $user = $this->repository->create($userData);
            if(!$user) return $this->response()->error();

            return $this->response($user)
                ->success("Successfully Signed up! \n Please verify your account");
        } catch (Exception $e) {

            return $this->response()->error();
        }
    }

    /**
     * @param string $email
     * @return array
     */
    public function userEmailExists(string $email): array {
        try {
            $user = $this->repository->getUser(['email' => $email]);

            return empty($user) ?
                $this->response()->error() :
                $this->response($user)->success();
        } catch (Exception $e) {

            return $this->response()->error();
        }
    }

    /**
     * @param object $user
     * @return bool
     */
    public function checkUserEmailIsVerified(object $user): bool {
        return $user->role == ADMIN_ROLE ||
            (is_null($user->email_verification_code) && $user->email_verified == ACTIVE_STATUS);
    }

    /**
     * @param int $userId
     * @param string $newPassword
     * @return bool
     */
    public function updatePassword(int $userId, string $newPassword): bool {
        try {
            $updatePasswordResponse = $this->repository->updateWhere([
                'id' => $userId
            ], [
                'password' => Hash::make($newPassword)
            ]);

            return $updatePasswordResponse == 1;
        } catch (Exception $e) {

            return false;
        }
    }

    /**
     * @param object $user
     * @param null $emailVerificationCode
     * @param $status
     * @return array
     */
    public function updateEmailVerificationCodeAndStatus(object $user,$status,$emailVerificationCode = null): array {
        try {
            $updateStatusResponse = $this->repository->updateWhere([
                'id' => $user->id,
                'email_verified' => PENDING_STATUS
            ],[
                'email_verification_code' => $emailVerificationCode,
                'email_verified' => $status
            ]);

            return !$updateStatusResponse ?
                $this->response()->error():
                $this->response()->success('Your email has been successfully verified');
        } catch (Exception $e) {

            return $this->response()->error();
        }
    }

    /**
     * @param int $id
     * @return array
     */
    public function getUserById (int $id): array {
        $user = $this->repository->find($id);

        return !isset($user) ? $this->response()->error() :
            $this->response($user)->success();
    }

    /**
     * @param string $email
     * @return array
     */
    public function validateUserEmail(string $email): array {
        $userResponse = $this->userEmailExists($email);
        if (!$userResponse['success']) return $userResponse;
        $emailVerifiedResponse = $this->checkUserEmailIsVerified($userResponse['data']);

        return $emailVerifiedResponse ?
            $this->response()->error('your Email is already verified'):
            $this->response($userResponse['data'])->success();
    }
}
