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

// ------------------------------ Test routes ------------------------------
Route::get('/test', 'TestController@test')->name('test');
Route::get('/test-redirect', 'TestController@testRedirect')->name('test.redirect');
// ------------------------------ End Of Test Routes -----------------------




Route::get('/', "Web\Auth\LoginController@signIn")->name('signIn');

Route::group(['middleware' => ['admin'],'namespace' => 'Web\Admin\Dashboard'], function() {

    Route::get('admin-dashboard', "DashboardController@dashboard")->name('admin.dashboard');

});
Route::group(['middleware' => ['verifyEmail'],'namespace' => 'Web\User\Dashboard'], function() {

    Route::get('user-dashboard', "DashboardController@dashboard")->name('user.dashboard');

});

Route::group(['middleware' => 'auth'], function () {
//    Route::get('password-change', 'AuthController@passwordChange')->name('passwordChange');
//    Route::post('password-change-process', 'AuthController@passwordChangeProcess')->name('passwordChangeProcess');
    Route::get('sign-out', 'Web\Auth\LoginController@signOut')->name('signOut');
});


Route::group(['namespace' => 'Web\Auth'] , function () {
    Route::get('sign-up', "RegisterController@signUp")
        ->name('signUp');

    Route::post('sign-up-process', "RegisterController@signUpProcess")
        ->name('signUpProcess');

    Route::get('sign-in', "LoginController@signIn")
        ->name('signIn');

    Route::post('sign-in-process', "LoginController@signInProcess")
        ->name('signInProcess');

    Route::get('email-verification-view', "VerificationController@emailVerificationView")
        ->name('emailVerificationView');

    Route::post('verify-email-process', "VerificationController@verifyEmailProcess")
        ->name('verifyEmailProcess');

    Route::get('forget-password', "ForgotPasswordController@forgetPasswordView")
        ->name('forgetPasswordView');

    Route::post('forget-password-email-send', "ForgotPasswordController@forgetPasswordEmailSendProcess")
        ->name('forgetPasswordEmailSendProcess');

    Route::get('reset-password-view', "ResetPasswordController@resetPasswordView")
        ->name('resetPasswordView');

    Route::post('reset-password-code', "ResetPasswordController@resetPassword")
        ->name('resetPassword');

    Route::get('sign-in-with-provider/{provider}', 'SocialRegisterController@redirectToProvider')
        ->name('redirectToProvider');
    Route::get('/provider/{provider}/callback', 'SocialRegisterController@handleProviderCallback');

});