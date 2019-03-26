<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Postlist; // 贴子模型
use App\Models\Post_column; // 栏目模型
use App\Models\reply; // 回复模型
use App\Models\User; // 用户模型
use DB;

class PostlistController extends Controller
{
    /**
     * 发表贴子页面
     */
    public function add(){
    	// 获取栏目信息
    	$column = Post_column::all();
    	return view('Home.PostList.add',['column'=>$column,]);
    }

    /**
     * 处理添加贴子
     */
    public function doadd(Request $request){
    	// dump($request->all());
    	// 把贴子对应的内容添加进数据库
        DB::beginTransaction();
    	$post = new Postlist;
    	$post->uid = session('user')['id'];
    	$post->column_id = $request->input('column_id');
    	$post->post_title = $request->input('post_title');
    	$post->post_content = $request->input('post_content');
        $post->integral = $request->input('integral',0);
    	$res1 = $post->save();
        // 修改积分
        $user = $post->user->find($post->user->id);
        $user->userinfo->integral -= $request->input('integral',0);
        $res2 = $user->userinfo->save();
        // dump($post->user->userinfo->integral);
    	if($res1 && $res2){
            DB::commit();
    		return redirect('/');
    	}else{
            DB::rollBack();
    		return back()->with('error','发帖失败，这是BUG！');
    	}
    }

    /**
     * 贴子详情
     * @param $cid [贴子id]
     * @return [模板]
     */
    public function detail($cid){
        $postlist = Postlist::find($cid);// 获取id对应的贴子
        $user = $postlist->user; // 通过贴子id找到发帖用户
        $userinfo = $postlist->user->userinfo; // 获取发帖用户信息详情

        // 记录点击量（访问量）
        $postlist->visits += 1;
        $postlist->save();

        // 获取回复信息
        $reply = reply::where('post_list_id','=',$cid)->get();
        return view('Home.PostList.detail',['postlist'=>$postlist,'user'=>$user,'userinfo'=>$userinfo,'reply'=>$reply]);
    }

    /**
     * 回复贴子
     */
    public function reply(Request $request){
        // 接收数据
        $data = $request->all();

        // 使用正则把用户找出来
        $preg = '%@(\w+)%u';
        preg_match_all($preg,$data['reply_content'],$name_list);
        // dump($name_list);

        // 通过名字获取@的用户列表
        $userlist = User::select('id','u_name')->whereIn('u_name',$name_list['1'])->get();

        // 拼接地址
        // $userpath = [];
        // foreach ($userlist as $key => $value) {
        //     $userpath[] .= '<a href="/userinfo/index/'.$value['id'].'">@'.$value['u_name'].'&nbsp;</a>';
        // }
        foreach ($userlist as $key => $value) {
            $data['reply_content'] = str_replace($name_list['0'][$key].' ', '<a href="/userinfo/index/'.$value['id'].'" target="_blank">@'.$value['u_name'].'&nbsp;</a>', $data['reply_content']);
        }
        // dump($data['reply_content']);

        // 开启事务
        DB::beginTransaction();
        // 实例化回复模型
        $reply = new reply;
        $reply->post_list_id = $data['post_list_id'];
        $reply->uid = session('user')['id'];
        $reply->reply_content = $data['reply_content'];
        $res1 = $reply->save();

        // 记录回复数量
        $reply->postlist->reply_num += 1;
        $res2 = $reply->postlist->save();
        // 成功返回1
        if($res1 && $res2){
            // 提交事务
            DB::commit();
            return '1';
        }else{
            // 回滚事务
            DB::rollBack();
            return '2';
        }
    }

    /**
     * 后台贴子列表
     */
    public function showList(Request $request){
        // 搜索的内容
        $search = $request->input('search','');

        // 显示条数
        $count = $request->input('count','5');
        $list = Postlist::where('post_title','like','%'.$search.'%')->paginate($count);
        // 每页首个序号
        $firstItem = $list->firstItem();
        return view('Admin/postlist/list',['list'=>$list,'search'=>$search,'count'=>$count,'firstItem'=>$firstItem]);
    }
}
