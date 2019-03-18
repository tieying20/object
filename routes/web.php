<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    dump('兄弟们，开干吧！');
    return view('welcome');
});

// 首页路由开始

// 后台首页
Route::get('admin/index','Admin\IndexController@index');
// 首页的欢迎页面
Route::get('admin/welcome','Admin\IndexController@welcome');


// 管理员
Route::resource('admin/admin','Admin\AdminController');
Route::get('admin/admin/setStatus/{id}/{status}','Admin\AdminController@setStatus');

// 轮播图
Route::resource('admin/slideshow','Admin\SlideshowController');

























// 前台首页
Route::get('home/index','Home\IndexController@index');

// 前台登录页面
Route::get('home/login','UsersController@login');

// 处理登录
Route::post('home/dologin','UsersController@dologin');

// 前台用户
Route::resource('user','UsersController');

// 我的信息
Route::get('userinfo/message/{id}','UserinfoController@message');

// 个人中心
Route::resource('userinfo','UserinfoController');

// 前台注册页面
Route::get('home/register','Home\IndexController@register');
















// 赞助商管理路由开始
Route::resource('admin/sponsor','Admin\SponsorController');

// 赞助商管理路由结束


