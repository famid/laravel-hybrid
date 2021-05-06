<?php
/*
    * ---------------------------------------------------------------------------------------------------------
    * AUTHENTICATION API
    * ---------------------------------------------------------------------------------------------------------
    * */

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Api\Auth'] , function () {
    Route::post('sign-up-process', "RegisterController@signUpProcess")->name('api.auth.sign_up_process');

    Route::post('sign-in-process', "LoginController@signInProcess")->name('api.auth.sign_in_process');

    Route::post('verify-email-process', "VerificationController@verifyEmailProcess")
        ->name('api.auth.verify_email_process');
    Route::post('resend-email-verification-code', "VerificationController@resendEmailVerificationCode")
        ->name('api.auth.resend_email_verification_code');

    Route::post('forget-password-email-send', "ForgotPasswordController@forgetPasswordEmailSendProcess")
        ->name('api.auth.forget_password_email_send_process');

    Route::post('reset-password-process', "ResetPasswordController@resetPasswordProcess")
        ->name('api.auth.reset_password_process');
    /*-------------------------------------Social sign api -----------------------------------------------*/
    Route::post('social-sign-up', "SocialRegisterController@socialSignUp")
        ->name('api.auth.social_sign_up');
    /*-----------------------------------------------------------------------------------------------------*/
});

Route::group(['middleware' => ['auth:api']], function () {
    Route::post('sign-out', 'Api\Auth\LoginController@signOut')->name('api.auth.sign_out');
    Route::post('password-change-process', "Api\Auth\ResetPasswordController@passwordChangeProcess")
        ->name('api.auth.password_change_process');
});
