<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var string
     */
    protected $errorMessage = "Something went wrong";

    /**
     * @param $message
     * @return array
     */
    public function successResponse(string $message="") {

        return ["success" => $message];
    }

    /**
     * @param string $message
     * @return string[]
     */
    public function errorResponse(string $message="") {

        return ["error" => empty($message) ? __($this->errorMessage) : $message];
    }

    /**
     * @param array $serviceResponse
     * @param string|null $successRoute
     * @param string|null $failedRoute
     * @return RedirectResponse
     */
    public function webResponse(array $serviceResponse, string $successRoute = null,
                                string $failedRoute = null){
        $redirection = redirect();
        if (!$serviceResponse['success']) {
            $redirection =!is_null($failedRoute) ? $redirection->route($failedRoute) : $redirection->back();

            return  $redirection->with($this->errorResponse($serviceResponse["message"]));
        }
       $redirection =!is_null($successRoute) ? $redirection->route($successRoute) : $redirection->back();

       return  $redirection->with($this->successResponse($serviceResponse["message"]));
    }
}
