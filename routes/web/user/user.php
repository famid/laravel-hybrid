<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['verifyEmail'],'namespace' => 'Web\User\Dashboard'], function() {
    Route::get('user-dashboard', "DashboardController@dashboard")->name('web.user.dashboard');
});