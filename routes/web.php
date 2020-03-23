<?php

Route::get('/', 'Site\HomeController@index')->name('site.index');

Route::prefix('painel')->group(function(){
    Route::get('/', 'Admin\HomeController@index')->name('admin');
    Route::get('login', 'Admin\Auth\LoginController@index')->name('login');
    Route::post('login', 'Admin\Auth\LoginController@auth');
    Route::get('register', 'Admin\Auth\RegisterController@index')->name('register');
    Route::post('register', 'Admin\Auth\RegisterController@register');
    Route::post('logout', 'Admin\Auth\LoginController@logout')->name('logout');

    Route::resource('users', 'Admin\UserController');
    Route::resource('pages', 'Admin\PagesController');

    Route::get('profile', 'Admin\ProfileController@index')->name('profile');
    Route::put('profileSave', 'Admin\ProfileController@save')->name('profile.save');

    Route::get('settings', 'Admin\SettingController@index')->name('settings');
    Route::put('settingsSave', 'Admin\SettingController@configSave')->name('settings.save');
});

Route::fallback('Site\PageController@index');
