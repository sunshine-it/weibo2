<?php

Route::get('/', 'StaticPagesController@home')->name('home');
Route::get('/help', 'StaticPagesController@help')->name('help');
Route::get('/about', 'StaticPagesController@about')->name('about');

Route::get('signup', 'UsersController@create')->name('signup');
// 用户资源路由
Route::resource('users', 'UsersController');

