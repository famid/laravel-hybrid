<?php

Route::group(['middleware' => ['admin'],'namespace' => 'Web\Admin\Dashboard'], function() {

    Route::get('admin-dashboard', "DashboardController@dashboard")->name('admin.dashboard');

});