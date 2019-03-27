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
use Illuminate\View\View; // View类，向公共模板model传值使用到的
use App\Notifications\InvoicePaid; // 消息

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

        // 获取贴子
        $postlist = Postlist::paginate(15);

        return view('Home/index',['slide_list'=>$slide_list,'slide_num'=>$slide_num,'postlist'=>$postlist]);
    }

    /**
     * 各个栏目的页面
     * @return 引入模板
     */
    public function columnPost(){
        return view('Home/Postlist/column');
    }

    /**
     * 向公共模板传参数
     * @return [type] [description]
     */
    public function nav(View $view){
        // 栏目
        $post_column = post_column::all();
        //赞助商模块
        $sponsor = sponsors::all();
        //友情链接模块
        $link = blogrolls::all();
        $view->with('post_column',$post_column)
            ->with('sponsor',$sponsor)
            ->with('link',$link);
    }
}
