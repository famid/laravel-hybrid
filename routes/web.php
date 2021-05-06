<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
require base_path('routes/web/auth/auth.php');
require base_path('routes/web/admin/admin.php');
require base_path('routes/web/user/user.php');
// ------------------------------ Test routes ------------------------------
Route::get('/test', 'TestController@test')->name('test');
Route::get('/test-redirect/{id}', 'TestController@testRedirect')->name('test.redirect');
// ------------------------------ End Of Test Routes -----------------------

Route::get('/', "Web\Auth\LoginController@signIn")->name('web.auth.sign_in');





