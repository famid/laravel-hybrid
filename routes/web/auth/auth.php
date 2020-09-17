<?php

/*
    * ---------------------------------------------------------------------------------------------------------
    * AUTHENTICATION API
    * ---------------------------------------------------------------------------------------------------------
    * */

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Web\Auth'] , function () {
    Route::get('sign-up', "RegisterController@signUp")->name('web.auth.sign_up');
    Route::post('sign-up-process', "RegisterController@signUpProcess")->name('web.auth.sign_up_process');

    Route::get('sign-in', "LoginController@signIn")->name('web.auth.sign_in');
    Route::post('sign-in-process', "LoginController@signInProcess")->name('web.auth.sign_in_process');

    Route::get('verify-email/{encryptUserId}',"VerificationController@verifyEmailProcess")
        ->name('web.auth.verify_email_process');

    Route::get('forget-password', "ForgotPasswordController@forgetPassword")
        ->name('web.auth.forget_password');
    Route::post('forget-password-email-send', "ForgotPasswordController@forgetPasswordEmailSendProcess")
        ->name('web.auth.forget_password_email_send_process');

    Route::get('reset-password/{email}', "ResetPasswordController@resetPassword")
        ->name('web.auth.reset_password');
    Route::post('reset-password-process', "ResetPasswordController@resetPasswordProcess")
        ->name('web.auth.reset_password_process');

    Route::get('sign-in-with-provider/{provider}', 'SocialRegisterController@redirectToProvider')
        ->name('web.auth.redirect_to_provider');
    Route::get('/provider/{provider}/callback', 'SocialRegisterController@handleProviderCallback')
        ->name('web.auth.handle_provider_callback');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('sign-out', 'Web\Auth\LoginController@signOut')->name('web.auth.sign_out');
});
