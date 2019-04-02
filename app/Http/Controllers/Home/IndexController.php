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
use App\Models\sign_infos;//签到模型
use Illuminate\View\View; // View类，向公共模板model传值使用到的
use App\Notifications\InvoicePaid; // 消息

class IndexController extends Controller
{
    /**
     * 首页
     * @return 引入模板
     */
    public function index($status='', $order='')
    {
    	// 轮播图模块
    	// 当前时间戳
    	$now = time();
    	$slide_list = Slideshow::where('start_at','<',$now)->where('stop_at','>',$now)->get();
    	$slide_num = count($slide_list);


        // 获取所有的贴子
        $postlist = Postlist::orderBy('id','desc')->paginate(15);
        // 把指定贴子分离出来
        $stick = [];
        foreach ($postlist as $key => $value) {
            if($value['status'] == 2){
                $stick[$key] = $value; // 置顶的贴子存入新数组
                unset($postlist[$key]); // 删除原数组的这一条数据
            }
        }

        // 根据要求获取贴子
        if(!empty($status)){
            if($status == 'status'){
                $postlist = Postlist::orderBy($order,'desc')->paginate(15);
            }else{
                $postlist = Postlist::where('status','=',$status)->orderBy($order,'desc')->paginate(15);
            }
        }

        //签到
        $uid = session('user')['id'];//获取用户id
        $sign = sign_infos::where('uid','=',$uid)->where('month','=',date('m'))->first();
        //积分规则
        if($sign['xunum'] <5){
            $integral = 5;
        }else if($sign['xunum'] <15 ){
            $integral = 10;
        }else if($sign['xunum'] >=15 ){
            $integral = 15;
        }
        return view('Home/index',['slide_list'=>$slide_list,'slide_num'=>$slide_num,'postlist'=>$postlist,'stick'=>$stick,'status'=>$status,'sign'=>$sign,'integral'=>$integral]);
    }

    /**
     * 根据要求获取贴子
     */
    public function require(){

    }

    /**
     * 各个栏目的页面
     * @return 引入模板
     */
    public function columnPost($cid){
        // 获取贴子
        $postlist = Postlist::where('column_id','=',$cid)->paginate(15);
        return view('Home/Postlist/column',['postlist'=>$postlist,'cid'=>$cid]);
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

