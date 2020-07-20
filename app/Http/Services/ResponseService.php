<?php


namespace App\Http\Services;


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
    public function jsonResponse($data = null) {
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
}