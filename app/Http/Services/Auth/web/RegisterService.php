<?php


namespace App\Http\Services\Auth\web;


use Illuminate\Support\Facades\Hash;
use App\Http\Services\BaseService;
use App\Http\Services\UserService;

class RegisterService extends BaseService {

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @var
     */
    private $request;

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
        $this->request = $request;

        return $this->userService->create($this->preparedCreateUserData());
    }

    /**
     * @return array
     */
    private function preparedCreateUserData() : array {

        return [
            'email' => $this->request->email,
            'phone_code' => $this->request->phone_code,
            'phone' => $this->request->phone,
            'password' => Hash::make($this->request->get('password')),
            'first_name' => $this->request->first_name,
            'last_name' => $this->request->last_name,
            'username' => $this->request->username,
            'role' => USER_ROLE,
            'status' => USER_PENDING_STATUS,
        ];
    }

}

