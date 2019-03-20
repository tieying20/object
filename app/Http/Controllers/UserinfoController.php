<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Userinfo;
use App\Models\User;
use DB;
use Hash;
use Mail;


class UserinfoController extends Controller
{
    /**
     * 我的主页
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(session('user')['id']);
        // dump($user);
        // dump($user->userinfo);

        // 用户详细主页
        return view('/Home/userinfo',['user'=>$user]);
    }

    /**
     * 用户中心
     *
     * @return \Illuminate\Http\Response
     */
    public function center()
    {
        // 用户中心
        $user = User::find(session('user')['id']);

        return view('/Home/user_center',['user'=>$user]);
    }

    /**
     * 基本设置
     *
     * @param  int
     * @return \Illuminate\Http\Response
     */
    public function set(Request $request)
    {
        $user = User::find(session('user')['id']);
        return view('/Home/user_set',['user'=>$user]);
    }

    /**
     * 邮箱验证
     */
    public function email(Request $request){
        // 获取要发送的邮箱
        $email =$request->input('email');
        // 验证码
        $yzm = mt_rand(1000,9999);
        session($email,$yzm);
        $request->session()->put('yzm'.$email,$yzm);
        dump(session('yzm'.$email));
        echo '1';
        // Mail::send('email.user_mail', ['email' => $email,'yzm' => $yzm], function ($m) use ($email,$yzm) {
        //     $res = $m->to($email)->subject('【有个社区】提醒信息！');
        //     // 把验证码存入session，键为yzm+邮箱
        //     session('yzm'.$email,$yzm);
        //     echo '1';
        // });
    }

    /**
     * 基本设置->我的资料
     */
    public function myInfo(Request $request){
        $info = $request->except(['_token']);
        dump(session('yzm'.$info['email']));
        if($info['yzm'] != session($info['email'])){
            // return back()->with('status','邮箱验证码不正确，请输入正确的验证码');
        }
        $User = User::find(session('user')['id']);
        // $userinfo = $User->Userinfo;

        // dump($userinfo);
    }

    /**
     *  我的消息
     */
    public function message()
    {
        $user = User::find(session('user')['id']);
        return view('/Home/my_message',['user'=>$user]);
    }



}
