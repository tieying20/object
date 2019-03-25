<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Postlist; // 贴子模型
use App\Models\Post_column; // 栏目模型
use App\Models\reply; // 回复模型
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
    	// 直接添加进数据库
        DB::beginTransaction();
    	$post = new Postlist;
    	$post->uid = session('user')['id'];
    	$post->column_id = $request->input('column_id');
    	$post->post_title = $request->input('post_title');
    	$post->post_content = $request->input('post_content');
    	$res1 = $post->save();
        // 修改积分
        $user = $post->user->find($post->user->id);
        $user->userinfo->integral -= $request->input('integral',0);
        $res2 = $user->userinfo->save();
        dump($post->user->userinfo->integral);
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
        $postlist = Postlist::find($cid);// 获取贴子id
        $user = $postlist->user; // 通过贴子id找到发帖用户
        $userinfo = $postlist->user->userinfo; // 获取发帖用户信息详情

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
        // 存数据
        $reply = new reply;
        $reply->post_list_id = $data['post_list_id'];
        $reply->uid = session('user')['id'];
        $reply->reply_content = $data['reply_content'];
        $res = $reply->save();
        // 成功返回1
        if($res){
            return '1';
        }else{
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
