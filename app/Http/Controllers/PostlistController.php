<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Postlist; // 贴子模型
use App\Models\Post_column; // 栏目模型
use App\Models\reply; // 回复模型
use App\Models\User; // 用户模型
use App\Models\Notice; // 通知表
use App\Models\zan; // 点赞表
use DB;

class PostlistController extends Controller
{
    /**
     * 发表贴子页面
     */
    public function add()
    {
    	// 获取栏目信息
    	$column = Post_column::all();
    	return view('Home.PostList.add',['column'=>$column,]);
    }

    /**
     * 处理添加贴子
     */
    public function doadd(Request $request)
    {
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
    public function detail($cid)
    {
        $postlist = Postlist::find($cid);// 获取id对应的贴子
        $user = $postlist->user; // 通过贴子id找到发帖用户
        $userinfo = $postlist->user->userinfo; // 获取发帖用户信息详情

        // 记录点击量（访问量）
        $postlist->visits += 1;
        $postlist->save();

        // 获取回复信息
        $reply = reply::where('post_list_id','=',$cid)->get();

        // 获取当前用户点赞记录
        $zan = zan::where('uid','=',session('user')['id'])->get();

        // 通过遍历回复信息和点赞表，把点赞的信息加个字段
        foreach ($reply as $k => $v) {
            foreach ($zan as $kk => $vv) {
                if($v['id'] == $vv['rid']){
                    $v['zan'] = 1;
                }
            }
        }

        return view('Home.PostList.detail',['postlist'=>$postlist,'user'=>$user,'userinfo'=>$userinfo,'reply'=>$reply,'zan'=>$zan]);
    }

    /**
     * 回复贴子
     */
    public function reply(Request $request)
    {
        // 接收数据
        $data = $request->all();

        // 使用正则把用户找出来
        $preg = '%@(\w+)( |&nbsp;)%u';
        preg_match_all($preg,$data['reply_content'],$name_list);

        // 通过名字获取@的用户列表
        $userlist = User::select('id','u_name')->whereIn('u_name',$name_list['1'])->get();

        // 存储id
        $id_arr = [];
        // 循环替换掉名字
        foreach ($userlist as $key => $value) {
            // 把@用户替换成带连接的
            $data['reply_content'] = str_replace($name_list['0'][$key], '<a href="/userinfo/index/'.$value['id'].'" target="_blank">@'.$value['u_name'].'&nbsp;</a>', $data['reply_content']);
            $id_arr[] .= $value['id'];
        }

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

        // 压入发帖人id
        $id_arr[] .= $reply->postlist->uid;
        // 写入通知表
        foreach ($id_arr as $k => $v) {
            if($v != $reply->uid){
                $notice = new Notice;
                $notice->uid = $reply->uid; // 通知发起人
                $notice->notice_id = $v; // 被通知的人
                $notice->pid = $reply->post_list_id; // 哪个贴子
                $notice->notice_type = '回复了您：'; // 格式
                $notice->data = $data['reply_content']; // 回复内容
                $notice->save();
            }
        }

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
    public function showList(Request $request)
    {
        // 搜索的内容
        $search = $request->input('search','');

        // 显示条数
        $count = $request->input('count','5');
        $list = Postlist::where('post_title','like','%'.$search.'%')->paginate($count);
        // 每页首个序号
        $firstItem = $list->firstItem();
        return view('Admin/postlist/list',['list'=>$list,'search'=>$search,'count'=>$count,'firstItem'=>$firstItem]);
    }

    /**
     * 获取通知消息数量
     */
    public function getNotice(Request $request)
    {
        // 获取当前用户id
        $id = $request->input('id');
        // 获取该用户未读消息
        $notice = Notice::where('notice_id','=',$id)->where('is_read','=','0')->count();
        return $notice;
    }

    /**
     * 设置消息为已读
     */
    public function setRead(Request $request, $id)
    {
        // 获取要修改的消息
        $notice = Notice::where('notice_id',$id)->get();
        // 遍历修改阅读状态并保存
        foreach ($notice as $key => $value) {
            $value->is_read = 1;
            $value->save();
        }
        return redirect('/userinfo/message/'.$id);
    }

    /**
     * 点赞
     */
    public function zan(Request $request, $rid)
    {
        $uid = $request->input('uid');
        $res1 = zan::where('rid','=',$rid)->where('uid','=',$uid)->get();
        if(!$res1->first()){
            // 点赞表里不存在这条点赞
            DB::beginTransaction();
            $zan = new zan; // 添加数据
            $zan->rid = $rid;
            $zan->uid = $uid;
            $r1 = $zan->save();

            // 修改回复的点赞数
            $reply = reply::find($rid);
            $reply->praise += 1; // 累加这条回复的点赞数
            $r2 = $reply->save();
            if($r1 && $r2){
                // 提交事务
                DB::commit();

                // 只要不是给自己点赞就发送通知
                if($request->input('notice_id') != $uid){
                    $notice = new Notice;
                    $notice->uid = $uid; // 通知发起人
                    $notice->notice_id = $request->input('notice_id'); // 被通知的人
                    $notice->pid = $reply->post_list_id; // 哪个贴子
                    $notice->notice_type = '给您点赞了'; // 格式
                    $notice->save();
                }

                // 返回点赞数量
                return $reply->praise;
            }else{
                // 失败则回滚并返回false
                DB::rollBack();
                return 'b';
            }
        }else{
            return 'a';
        }

    }
}
