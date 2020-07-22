<?php

/*
    * ---------------------------------------------------------------------------------------------------------
    * AUTHENTICATION API
    * ---------------------------------------------------------------------------------------------------------
    * */
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

Route::group(['middleware' => 'auth'], function () {
//    Route::get('password-change', 'AuthController@passwordChange')->name('passwordChange');
//    Route::post('password-change-process', 'AuthController@passwordChangeProcess')->name('passwordChangeProcess');
    Route::get('sign-out', 'Web\Auth\LoginController@signOut')->name('signOut');
});