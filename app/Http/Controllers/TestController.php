<?php


namespace App\Http\Controllers;


class TestController extends Controller {

    public function test() {
        try {
             return $this->webResponse(false, "Failed");
//            return $this->webResponse(true, "Success", 'test.redirect');
        } catch (\Exception $e) {
            return $this->webResponse(false, $e->getMessage());
        }
    }

    public function testRedirect() {
        return "OK";
    }
}