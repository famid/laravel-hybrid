<?php


namespace App\Http\Services;


use App\Http\Repository\UserRepository;
use App\Http\Services\Boilerplate\BaseService;
use App\Jobs\SendVerificationEmailJob;
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

    public function prepareUserData(object $request, int $emailVerificationCode = null) : array {
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

    public function prepareSocialUserData(object $providerUser) :array {
        return [
            'email' => $providerUser->getEmail(),
            'username' => empty(!$providerUser->getName()) ? $providerUser->getName()
                :$providerUser->getNickname(),
            'role' => USER_ROLE,
            'status' => ACTIVE_STATUS,
            'email_verification_code' => randomNumber(6),
        ];
    }

    /**
     * @param array $userData
     * @return array
     */
    public function create(array $userData) : array {
        try {
            $user = $this->repository->create($userData);
            if(!$user) return $this->response()->error();
            dispatch(new SendVerificationEmailJob($user->email_verification_code, $user))
                ->onQueue('email-send');

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
    public function userEmailExists(string $email) :array {
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
    public function checkUserEmailIsVerified(object $user) :bool {
        return is_null($user->email_verification_code) && $user->email_verified == ACTIVE_STATUS;
    }

}
