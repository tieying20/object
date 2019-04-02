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
use App\Models\reply;//签到模型
use DB;
use Illuminate\Support\Carbon;
use Illuminate\View\View; // View类，向公共模板model传值使用到的

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
        $postlist = Postlist::where('status','<','9')->orderBy('id','desc')->paginate(15);
        // 把置顶贴子分离出来
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
                // 等于status就是综合贴子
                $postlist = Postlist::where('status','<','9')->orderBy($order,'desc')->paginate(15);
                // 把置顶贴子分离出来
                $stick = [];
                foreach ($postlist as $key => $value) {
                    if($value['status'] == 2){
                        $stick[$key] = $value; // 置顶的贴子存入新数组
                        unset($postlist[$key]); // 删除原数组的这一条数据
                    }
                }
            }else{
                // 这里是获取精华帖的
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
        return view('Home/index',['slide_list'=>$slide_list,'slide_num'=>$slide_num,'postlist'=>$postlist,'stick'=>$stick,'status'=>$status,'order'=>$order,'sign'=>$sign,'integral'=>$integral]);
    }

    /**
     * 各个栏目的页面
     * @return 引入模板
     */
    public function columnPost($cid, $status='', $order=''){
        // 获取贴子
        $postlist = Postlist::where('column_id','=',$cid)->where('status','<','9')->paginate(15);
        // 根据要求获取贴子
        if(!empty($status)){
            if($status == 'status'){
                // 等于status就是综合贴子
                $postlist = Postlist::where('column_id','=',$cid)->where('status','<','9')->orderBy($order,'desc')->paginate(15);
            }else{
                // 这里是获取精华帖的
                $postlist = Postlist::where('column_id','=',$cid)->where('status','<','9')->where('status','=',$status)->orderBy($order,'desc')->paginate(15);
            }
        }
        return view('Home/Postlist/column',['postlist'=>$postlist,'cid'=>$cid,'status'=>$status,'order'=>$order]);
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
        // 回帖周榜
        //php获取这周起始时间和结束时间
        $z_start = Carbon::now()->startOfWeek();
        $z_over = Carbon::now()->endOfWeek();
        $reply_num = DB::table('post_reply')
                        ->select(DB::raw('uid,COUNT(*) AS count'))
                        ->whereDate('created_at','>=',$z_start)
                        ->whereDate('created_at','<=',$z_over)
                        ->groupBy('uid')
                        ->orderBy('count','desc')
                        ->take(20)
                        ->get();
        // $reply_num1 = DB::select('SELECT uid, COUNT(*) AS count FROM post_reply GROUP BY uid ORDER BY count desc'); //这种方法也行
        $user_id = []; // 存用户id
        $r_count = []; // 用户回复次数
        // 循环把用户id写入
        foreach ($reply_num as $value) {
            $user_id[] .= $value->uid;
            $r_count[$value->uid] = $value->count;
        }
        // 根据用户id取出用户对象
        $r_user = User::select('id','u_name','phone')->whereIn('id',$user_id)->get();

        $reyi = Postlist::where('reply_num','>',0)->orderBy('reply_num','desc')->get();
        $view->with('post_column',$post_column)
            ->with('sponsor',$sponsor)
            ->with('r_user',$r_user)
            ->with(['r_count'=>$r_count])
            ->with('link',$link)
            ->with('reyi',$reyi);
    }
}

