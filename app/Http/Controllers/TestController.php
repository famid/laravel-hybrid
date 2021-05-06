<?php


namespace App\Http\Controllers;


use Symfony\Component\HttpFoundation\Request;

class TestController extends Controller {

    public function test() {
      return view('auth.forget_password_email');
    }

    public function testRedirect(Request $request) {
        $data = [
            'success' => true,
            "message" => "OK",
            "data" => [
                "id" => 1,
                "name" => "Lewra leson",
                "lewra" => "leson"
            ]
        ];
        return $this->webResponse(
            $data,
            'success.route',
            null,
            ['id' => $data["data"]["id"]],
            ['id' => $request->id]
        );
    }
}