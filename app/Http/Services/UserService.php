<?php


namespace App\Http\Services;


use App\Http\Repository\UserRepository;
use App\Jobs\SendVerificationEmailJob;
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
     * @param array $userData
     * @return array
     */
    public function create(array $userData) : array {
        try {
            $user = $this->repository->create($userData);
            if(!$user) return $this->jsonResponse()->error();
            dispatch(new SendVerificationEmailJob($user->email_verification_code, $user))
                ->onQueue('email-send');

            return $this->jsonResponse($user)
                ->success("Successfully Signed up! \n Please verify your account");
        } catch (Exception $e) {

            return $this->jsonResponse()->error();
        }
    }

    /**
     * @param string $email
     * @return array
     */
    public function userEmailExists(string $email) :array {
        try {
            $user = $this->repository->getUser(['email' => $email]);

            return empty($user) ? $this->jsonResponse()->error() :
                $this->jsonResponse($user)->success();
        } catch (Exception $e) {

            return $this->jsonResponse()->error();
        }
    }

}