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
// 首页路由结束




// 用户管理路由开始 
Route::resource('admin/user','Admin\AdminController');


// 用户管理路由结束 

