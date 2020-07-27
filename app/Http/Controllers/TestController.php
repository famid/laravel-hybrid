<?php


namespace App\Http\Controllers;


use Symfony\Component\HttpFoundation\Request;

class TestController extends Controller {

    public function test() {
      return view('auth.forget_password_email');
    }

    public function testRedirect($id) {
        return decrypt($id);
    }
}