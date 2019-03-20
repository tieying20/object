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
Route::post('admin/file_img','Admin\SlideshowController@file_img');
























// 前台首页
Route::get('home/index','Home\IndexController@index');
Route::get('/','Home\IndexController@index');

// 前台登录页面
Route::get('home/login','UsersController@login');

// 处理登录
Route::post('home/dologin','UsersController@dologin');
Route::post('home/dologin','UsersController@dologin');

// 前台用户
Route::resource('user','UsersController');

// 退出登录
Route::get('home/loginout','UsersController@loginout');

// 栏目管理
Route::resource('admin/programa','Admin\ProgramaController');












// 赞助商管理路由开始

//图片上传路由
Route::post('admin/upimg','Admin\SponsorController@Upimg');
//投放状态
Route::get('admin/sponsor/status/{id}/{status}','Admin\SponsorController@Status');

Route::resource('admin/sponsor','Admin\SponsorController');

// 赞助商管理路由结束

//友情链接路由开始
//投放状态
Route::get('admin/link/status/{id}/{status}','Admin\linkController@Status');

Route::resource('admin/link','Admin\linkController');
//友情链接路由结束



// 判断用户登录中间件组
Route::group(['middleware'=>['login']],function(){
	// 我的主页
	Route::get('userinfo/index','UserinfoController@index');

	// 用户中心
	Route::get('userinfo/center','UserinfoController@center');

	// 基本设置
	Route::get('userinfo/set','UserinfoController@set');
	// 基本设置->我的资料
	Route::post('userinfo/myinfo','UserinfoController@myInfo');

	// 我的信息
	Route::get('userinfo/message','UserinfoController@message');

	// 邮箱验证
	Route::get('userinfo/email','UserinfoController@email');

});

