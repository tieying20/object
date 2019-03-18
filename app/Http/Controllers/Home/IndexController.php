<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Slideshow;

class IndexController extends Controller
{
    // 前台首页
    public function index()
    {
    	// 获取轮播图信息
    	// 当前时间戳
    	$now = time();
    	$slide_list = Slideshow::where('start_at','<',$now)->where('stop_at','>',$now)->get();
    	$slide_num = count($slide_list);
    	// dump($slide_list);
    	// 判断
        return view('Home/index',['slide_list'=>$slide_list,'slide_num'=>$slide_num]);
    }


}
