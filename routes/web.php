<?php

Route::get('/', 'StaticPagesController@home')->name('home');
Route::get('/help', 'StaticPagesController@help')->name('help');
Route::get('/about', 'StaticPagesController@about')->name('about');

Route::get('signup', 'UsersController@create')->name('signup');
// 用户资源路由
Route::resource('users', 'UsersController');
// 会话路由
Route::get('login', 'SessionsController@create')->name('login'); // 显示登录页面
Route::post('login', 'SessionsController@store')->name('login'); // 创建新会话（登录）
Route::delete('logout', 'SessionsController@destroy')->name('logout'); // 销毁会话（退出登录）
// 激活令牌路由
Route::get('signup/confirm/{token}', 'UsersController@confirmEmail')->name('confirm_email');
// 显示重置密码的邮箱发送页面
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
// 邮箱发送重设链接
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
// 密码更新页面
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
// 执行密码更新操作
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
