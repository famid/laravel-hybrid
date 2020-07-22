<?php
/*
    * ---------------------------------------------------------------------------------------------------------
    * AUTHENTICATION API
    * ---------------------------------------------------------------------------------------------------------
    * */
Route::group(['namespace' => 'Api\Auth'] , function () {
    Route::post('sign-up', "RegisterController@signUp")->name('api.SignUp');
    Route::post('sign-in', "LoginController@signInProcess")->name('api.SignIn');
});