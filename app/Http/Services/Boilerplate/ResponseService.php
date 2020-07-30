<?php


namespace App\Http\Services\Boilerplate;


abstract class ResponseService {
    /**
     * @var array
     */
    public $response = [
        "success" => null,
        "message" => "",
        "data" => null
    ];

    /**
     * @var string
     */
    public $errorMessage = 'Something went wrong';

    /**
     * @param null $data
     * @return ResponseService
     */
    public function response($data = null) {
        $this->response["data"] = $data;
        return $this;
    }

    /**
     * @param $message
     * @return array
     */
    public function success($message="") {
        $this->response["success"] = true;
        $this->response["message"] = __($message);

        return $this->response;
    }

    /**
     * @param $message
     * @return array
     */
    public function error($message="") {
        $this->response["success"] = false;
        $this->response["message"] = empty($message) ?
            __($this->errorMessage) :
            __($message);

        return $this->response;
    }

    /**
     * @param object $user
     * @param string $token
     * @param string $message
     * @return array
     */
    public function authenticateApiResponse(object $user, string $token, string $message) {
        $authData = [
            'email_verified' => $user->email_verified == 1,
            'access_token' => $token,
            'access_type' => "Bearer",
            'user_data' => [
                'name' => $user->first_name . ' ' . $user->last_name,
                'email' => $user->email,
                'username' => $user->username,
                'phone' => $user->phone
            ]
        ];

        return $this->response($authData)->success($message);
    }
}
