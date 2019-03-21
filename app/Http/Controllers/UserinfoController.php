<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Userinfo;
use App\Models\User;
use DB;
use Hash;
use Mail;
use Illuminate\Support\Facades\Storage;


class UserinfoController extends Controller
{
    /**
     * 我的主页
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 用户表
        $user = User::find(session('user')['id']);
        // 用户详情表
        $userinfo = $user->userinfo;

        // 用户详细主页
        return view('/Home/userinfo',['user'=>$user,'userinfo'=>$userinfo]);
    }

    /**
     * 用户中心
     *
     * @return \Illuminate\Http\Response
     */
    public function center()
    {
        // 用户表
        $user = User::find(session('user')['id']);
        // 用户详情表
        $userinfo = $user->userinfo;
        return view('/Home/user_center',['user'=>$user,'userinfo'=>$userinfo]);
    }

    /**
     * 基本设置
     *
     * @param  int
     * @return \Illuminate\Http\Response
     */
    public function set(Request $request)
    {
        // 用户表
        $user = User::find(session('user')['id']);
        // 用户详情表
        $userinfo = $user->userinfo;
        return view('/Home/user_set',['user'=>$user,'userinfo'=>$userinfo]);
    }


    /**
     * 基本设置->邮箱验证
     */
    public function email(Request $request){
        // 获取要发送的邮箱
        $email =$request->input('email');
        // 验证码
        $yzm = mt_rand(1000,9999);
        // $request->session()->put('yzm'.$email,$yzm);
        // dump($yzm);
        // echo '1';
        Mail::send('email.user_mail', ['email' => $email,'yzm' => $yzm], function ($m) use ($email,$yzm,$request) {
            $res = $m->to($email)->subject('【有个社区】提醒信息！');
            // 把验证码存入session，键为yzm+邮箱
            $request->session()->put('yzm'.$email,$yzm);
            echo '1';
        });
    }

    /**
     * 基本设置->我的资料
     */
    public function myInfo(Request $request){
        // 接收传过来的数据
        $info = $request->except(['_token']);
        // dump($info);
        // 判断验证码
        if($request->exists('yzm')){
            if($info['yzm'] != session('yzm'.$info['email'])){
                // 将邮箱加入闪存
                return back()->with('yzm_no','邮箱验证码不正确，请输入正确的验证码');
            }
        }
        // 开启事务
        DB::beginTransaction();
        // 修改user表
        $User = User::find(session('user')['id']);
        $User->u_name = $info['u_name'];
        $res1 = $User->save();
        // 修改userinfo表
        $userinfo = $User->Userinfo;
        $userinfo->email = $info['email'];
        $userinfo->sex = $info['sex'];
        $userinfo->city = $info['city'];
        $userinfo->describe = $info['describe'];
        $res2 = $userinfo->save();
        // 判断成功or失败
        if($res1 && $res2){
            DB::commit(); // 提交事务
            return redirect('userinfo/set')->with('status','修改成功');
        }else{
            DB::rollBack(); // 回滚事务
            return back()->with('status','修改失败，请联系管理员');
        }
    }

    /**
     * 基本设置->头像更换
     */
    public function upFile(Request $request){
        $old_img = $request->input('old_img');
        // 如果原头像不是新手头像就删除
        if($old_img != '/upload/user_img/default.jpg'){
            Storage::delete(substr($old_img, 7));
        }
        // 接收文件对象
        $file = $request->file('file');
        // 保存图片并返回保存路径
        $img_path = $file->store('user_img');
        return $img_path;
    }

    /**
     * 基本设置->重置密码
     */
    public function resetPwd(Request $request){
        // 接收数据
        $data = $request->all();
        // 判断输入的密码是否符合规则
        $preg = "/^\w{6,16}$/";
        if(!preg_match($preg, $data['pass'])){
            // 写入闪存
            $request->flash();
            return back()->with('status','密码长度要求6-16位，可由数字、字母、下划线组成！');
        }

        // 判断两次密码是否一致
        if($data['pass'] != $data['repass']){
            // 写入闪存
            $request->flash();
            return back()->with('status','两次密码不一致！');
        }

        // 获取用户id
        $id = session('user')['id'];
        $user = User::find($id);
        // 判断输入的密码跟数据库的密码是否一致
        if(!Hash::check($data['nowpass'],$user['pwd'])){
            // 写入闪存
            $request->flash();
            return back()->with('status','您输入的当前密码不正确！');
        }

        // 到这里就能直接修改密码了
        $user->pwd = Hash::make($data['pass']);
        $res = $user->save();
        if($res){
            return back()->with('status','修改成功！');
        }else{
            return back()->with('status','修改失败，存在BUG');
        }
    }

    /**
     *  我的消息
     */
    public function message()
    {
        // 用户表
        $user = User::find(session('user')['id']);
        // 用户详情表
        $userinfo = $user->userinfo;
        return view('/Home/my_message',['user'=>$user,'userinfo'=>$userinfo]);
    }



}
