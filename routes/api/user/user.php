<?php

Route::group(['middleware' => ['verifyEmail'],'namespace' => 'Web\User\Dashboard'], function() {

    Route::get('user-dashboard', "DashboardController@dashboard")->name('user.dashboard');

});