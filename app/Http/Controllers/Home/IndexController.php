<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Slideshow; // 轮播图模型
use App\Models\blogrolls; // 友情链接模型
use App\Models\sponsors; // 赞助商模型
use App\Models\Post_column; // 贴子栏目模型
use App\Models\User; // 用户模型
use App\Models\Userinfo; // 用户详情模型
use App\Models\Postlist; // 贴子模型

class IndexController extends Controller
{
    /**
     * 首页
     * @return 引入模板
     */
    public function index()
    {
    	// 轮播图模块
    	// 当前时间戳
    	$now = time();
    	$slide_list = Slideshow::where('start_at','<',$now)->where('stop_at','>',$now)->get();
    	$slide_num = count($slide_list);
    	// dump($slide_list);

        //赞助商模块
        $sponsor = sponsors::all();
        //友情链接模块
        $link = blogrolls::all();

        // 栏目
        $post_column = post_column::all();


        // 获取贴子
        $postlist = Postlist::paginate(1);

        return view('Home/index',['slide_list'=>$slide_list,'slide_num'=>$slide_num,'sponsor'=>$sponsor,'link'=>$link,'post_column'=>$post_column,'postlist'=>$postlist]);

    }

    /**
     * 各个栏目的页面
     * @return 引入模板
     */
    public function columnPost(){
        // 栏目
        $post_column = post_column::all();
        //赞助商模块
        $sponsor = sponsors::all();
        //友情链接模块
        $link = blogrolls::all();

        return view('Home/Postlist/column',['post_column'=>$post_column,'link'=>$link,'sponsor'=>$sponsor]);
    }


}
