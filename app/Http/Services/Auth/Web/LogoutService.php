<?php


namespace App\Http\Services\Auth\Web;


use App\Http\Services\Boilerplate\BaseService;
use Illuminate\Support\Facades\Auth;
use Exception;

class LogoutService extends BaseService {

    /**
     * @return array
     */
    public function logout(): array {
        try {
            Auth::logout();
            session()->flush();

            return $this->response()->success('successfully sign out');
        } catch (Exception $e) {

            return $this->response()->error();
        }
    }
}
