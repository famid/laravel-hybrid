<?php


namespace App\Http\Services\web\Auth;


use App\Http\Services\BaseService;
use Illuminate\Support\Facades\Auth;
use Exception;

class LoginService extends  BaseService {

    /**
     * @param object $request
     * @return array
     */
    public function signInProcess(object $request) : array {
        try {
            $credentials = $this->credentials($request->except('_token'));
            $valid = Auth::attempt($credentials);
            if (!$valid) return $this->jsonResponse()->error();

            return $this->jsonResponse()->success('Congratulations! You have signed in successfully.');
        } catch (Exception $e) {

            return $this->jsonResponse()->error();
        }
    }

    /**
     * @param array $data
     * @return array
     */
    private function credentials(array $data) : array {

        return filter_var($data['email'], FILTER_VALIDATE_EMAIL) ?
            ['email' => $data['email'], 'password' => $data['password']] :
            ['user_name' => $data['email'], 'password' => $data['password']];

    }
}

