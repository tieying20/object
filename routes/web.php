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

// 后台登录
Route::get('admin/login','Admin\IndexController@login');
// 处理后台登录
Route::post('admin/dologin','Admin\IndexController@dologin');

// 前台首页
Route::get('/','Home\IndexController@index');
// 首页根据需求获取贴子
Route::get('home/index/{status}/{order}','Home\IndexController@index');

// 其余栏目页面
Route::get('home/columnpost/{cid}','Home\IndexController@columnPost');
// 其余的栏目根据需求获取贴子
Route::get('home/columnpost/{cid}/{status}/{order}','Home\IndexController@columnPost');

// 前台登录页面
Route::get('home/login','UsersController@login');

// 处理前台登录
Route::post('home/dologin','UsersController@dologin');
Route::post('home/dologin','UsersController@dologin');

// 前台用户
Route::resource('user','UsersController');

// 前台退出登录
Route::get('home/loginout','UsersController@loginout');

// 贴子详情
Route::get('postlist/detail/{cid}','PostlistController@detail');

// 我的主页
Route::get('userinfo/index/{id}','UserinfoController@index');

// 判断用户登录中间件组
Route::group(['middleware'=>['login']],function(){

	// 用户中心
	Route::get('userinfo/center','UserinfoController@center');
	// 我的帖子
	Route::get('userinfo/posts','UserinfoController@posts');
	//我的帖子-删除
	Route::get('userinfo/pdel/{id}','UserinfoController@pdel');
	// 基本设置
	Route::get('userinfo/set','UserinfoController@set');
	// 基本设置->我的资料
	Route::post('userinfo/myinfo','UserinfoController@myInfo');
	// 基本设置->头像更换
	Route::post('userinfo/upfile','UserinfoController@upFile');
	// 基本设置->修改密码
	Route::post('userinfo/resetpwd','UserinfoController@resetPwd');

	// 我的信息
	Route::get('userinfo/message/{id}','UserinfoController@message');

	// 邮箱验证
	Route::get('userinfo/email','UserinfoController@email');

	// 发帖页面
	Route::get('postlist/add','PostlistController@add');
	// 处理添加贴子
	Route::post('postlist/doadd','PostlistController@doadd');

	// 回复贴子
	Route::post('postlsit/reply','PostlistController@reply');

	// 获取消息通知
	Route::post('postlist/getnotice','PostlistController@getNotice');

	// 设置消息为已读
	Route::get('postlist/setread/{id}','PostlistController@setRead');

	// 点赞
	Route::get('postlist/zan/{rid}','PostlistController@zan');

	// 举报页面
	Route::get('postlist/showjb/{rid}/{pid}','PostlistController@showJb');

	// 举报处理
	Route::post('postlist/inform','PostlistController@inform');
});




// 后台用户登录中间件
Route::group(['middleware'=>'admin_login'],function(){
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
	// 后台退出登录
	Route::get('admin/loginout','Admin\IndexController@loginout');
	// 栏目管理
	Route::resource('admin/post_column','Admin\Post_columnController');

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

	// 修改 前台用户状态
	Route::get('userinfo/setStatus/{id}','UserinfoController@setStatus');


	// 贴子列表
	Route::get('postlist/showlist','PostlistController@showList');
	// 修改贴子的状态
	Route::post('postlist/setstatus','PostlistController@setStatus');
	// 修改贴子的状态
	Route::post('postlist/delete','PostlistController@delete');

	// 回复举报页面
	Route::get('postlist/report','PostlistController@report');
	// 无违规，删除举报消息
	Route::post('postlist/delReport','PostlistController@delReport');

	// 角色管理
	// Route::resource('admin/role','Admin\roleController');
	// Route::get('admin/role/setStatus/{id}','Admin\roleController@setStatus');

});


// 前台手机用户验证码
Route::get('home/docode','UsersController@docode');

Route::get('home/imgcode','UsersController@imgcode');




//签到路由开始

//处理用户是否签到
Route::get('home/signin/hassign','Home\SigninController@hassign');
//点击签到
Route::post('home/signin','Home\SigninController@sign');
//获取用户签到日期
Route::get('home/signin/has','Home\SigninController@has');

//签到路由结束
