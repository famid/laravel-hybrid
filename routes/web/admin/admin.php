<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['admin'],'namespace' => 'Web\Admin\Dashboard'], function() {
    Route::get('admin-dashboard', "DashboardController@dashboard")->name('web.admin.dashboard');
});