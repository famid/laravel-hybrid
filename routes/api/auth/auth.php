<?php
/*
    * ---------------------------------------------------------------------------------------------------------
    * AUTHENTICATION API
    * ---------------------------------------------------------------------------------------------------------
    * */
Route::group(['namespace' => 'Api'] , function () {
    Route::post('sign-up', "RegisterController@signUp")->name('api.SignUp');
});