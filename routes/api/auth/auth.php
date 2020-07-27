<?php
/*
    * ---------------------------------------------------------------------------------------------------------
    * AUTHENTICATION API
    * ---------------------------------------------------------------------------------------------------------
    * */
Route::group(['namespace' => 'Api\Auth'] , function () {
    Route::post('sign-up-process', "RegisterController@signUpProcess")->name('api.auth.sign_up_process');
    Route::post('sign-in-process', "LoginController@signInProcess")->name('api.auth.sign_in_process');
    Route::post('verify-email-process', "VerificationController@verifyEmailProcess")->name('api.auth.verify_email_process');
    Route::post('forget-password-email-send', "ForgotPasswordController@forgetPasswordEmailSendProcess")
        ->name('api.auth.forget_password_email_send_process');
    Route::post('reset-password-process', "ResetPasswordController@resetPasswordProcess")
        ->name('api.auth.reset_password_process');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('sign-out', 'Api\Auth\LoginController@signOut')->name('api.auth.sign_out');
});