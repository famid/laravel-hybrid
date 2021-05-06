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
     * @return array
     */
    public function successResponse(string $message=""): array {
        return [
            "success" => $message
        ];
    }

    /**
     * @param string $message
     * @return string[]
     */
    public function errorResponse(string $message=""): array {
        return ["error" => empty($message) ? __($this->errorMessage) : $message];
    }

    /**
     *
     *
     *
     *
     *
     *
     *
     *
     * ------------------------------------------------------------------------------------------------------------
     * If serviceResponse[success] == false
     * if the route is given redirect to the route, or redirect back
     *
     * If serviceResponse[success] == true
     * if the route is given redirect to the route, or redirect back
     * -----------------------------------------------------------------------------------------------------------
     *
     * @param array $serviceResponse
     * @param string|null $successRoute
     * @param string|null $failedRoute
     * @param array|null $successRouteParameter
     * @param array|null $failedRouteParameter
     * @return RedirectResponse
     */
    public function webResponse(array $serviceResponse, string $successRoute = null, string $failedRoute = null
        , array $successRouteParameter = [], array $failedRouteParameter = []): RedirectResponse {
        $redirection = redirect();

        if (!$serviceResponse['success']) {
            $redirection =!is_null($failedRoute) ?
                $redirection->route($failedRoute, $failedRouteParameter) :
                $redirection->back();

            return  $redirection->with($this->errorResponse($serviceResponse["message"]));
        }

        $redirection =!is_null($successRoute) ?
            $redirection->route($successRoute, $successRouteParameter) :
            $redirection->back();

        return  $redirection->with($this->successResponse($serviceResponse["message"]));
    }
}
