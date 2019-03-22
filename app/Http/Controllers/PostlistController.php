<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Postlist; // 贴子模型
use App\Models\Post_column; // 栏目模型

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
    	$post = new Postlist;
    	$post->uid = session('user')['id'];
    	$post->column_id = $request->input('column_id');
    	$post->post_title = $request->input('post_title');
    	$post->post_content = $request->input('post_content');
    	$res = $post->save();
    	if($res){
    		return redirect('/');
    	}else{
    		return back()->with('error','发帖失败，这是BUG！');
    	}
    }

    public function show($cid){
        return view('Home.PostList.show');
    }
}
