<?php


namespace App\Http\Controllers;


use Symfony\Component\HttpFoundation\Request;

class TestController extends Controller {

    public function test() {
        try {
            $b = 'http://localhost:8000/test-redirect/'.encrypt('fuck you fucker');

            $a = '<a href = "'.$b.'">' .$b. '</a>';

             return $a;
//            return $this->webResponse(true, "Success", 'test.redirect');
        } catch (\Exception $e) {
            return $this->webResponse(false, $e->getMessage());
        }
    }

    public function testRedirect($id) {
        return decrypt($id);
    }
}