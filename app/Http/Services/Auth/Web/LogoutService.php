<?php


namespace App\Http\Services\Auth\Web;


use App\Http\Services\Boilerplate\BaseService;
use Illuminate\Support\Facades\Auth;
use Exception;

class LogoutService extends BaseService {

    public function logout() {
        try {
            Auth::logout();
            session()->flush();

            return $this->response()->success();
        } catch (Exception $e) {

            return $this->response()->error();
        }
    }
}
