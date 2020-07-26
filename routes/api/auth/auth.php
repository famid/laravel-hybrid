<?php
/*
    * ---------------------------------------------------------------------------------------------------------
    * AUTHENTICATION API
    * ---------------------------------------------------------------------------------------------------------
    * */
Route::group(['namespace' => 'Api\Auth'] , function () {
    Route::post('sign-up', "RegisterController@signUp")->name('api.SignUp');
    Route::post('sign-in', "LoginController@signInProcess")->name('api.SignIn');
    Route::post('verify-email', "VerificationController@verifyEmailProcess")->name('api.verifyEmailProcess');
    Route::post('forget-password-email-send', "ForgotPasswordController@forgetPasswordEmailSendProcess")
        ->name('api.forgetPasswordEmailSendProcess');
    Route::post('reset-password-code', "ResetPasswordController@resetPassword")->name('api.resetPassword');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('sign-out', 'Api\Auth\LoginController@signOut')->name('api.signOut');
});