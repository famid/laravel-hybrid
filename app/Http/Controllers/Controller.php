<?php


namespace App\Http\Controllers;


use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\RedirectResponse;

class Controller extends BaseController {

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var string
     */
    protected $errorMessage = "Something went wrong";

    /**
     * @param string $message
     * @param null $data
     * @return array
     */
    public function successResponse(string $message="", $data = null) {
        return [
            "success" => $message,
            'data' => !is_null($data) ? $data : null
        ];
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
    public function webResponse(array $serviceResponse, string $successRoute = null, string $failedRoute = null){
        $redirection = redirect();
        if (!$serviceResponse['success']) {
            $redirection =!is_null($failedRoute) ? $redirection->route($failedRoute) : $redirection->back();

            return  $redirection->with($this->errorResponse($serviceResponse["message"]));
        }
       $redirection =!is_null($successRoute) ? $redirection->route($successRoute) : $redirection->back();

       return  $redirection->with($this->successResponse($serviceResponse["message"],$serviceResponse['data']));
    }
}
