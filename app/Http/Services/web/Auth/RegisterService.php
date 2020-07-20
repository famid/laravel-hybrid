<?php


namespace App\Http\Services\web\Auth;


use App\Http\Services\BaseService;
use App\Http\Services\UserService;
use Illuminate\Support\Facades\Hash;

class RegisterService extends BaseService {

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * RegisterService constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    /**
     * @param object $request
     * @return array
     */
    public function signUp(object $request) : array {

        return $this->userService->create($this->preparedCreateUserData($request));
    }

    /**
     * @param object $request
     * @return array
     */
    private function preparedCreateUserData(object $request) : array {

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
            'email_verification_code' => randomNumber(6),
        ];
    }

}

