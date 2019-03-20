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
        Mail::send('email.user_mail', ['email' => $email,'yzm' => $yzm], function ($m) use ($email,$yzm) {
            $res = $m->to($email)->subject('【有个社区】提醒信息！');
            session('yzm'.$email,$yzm);
            echo '1';
        });
    }

    /**
     *
     */

    /**
     *  我的信息
     */
    public function message()
    {
        $user = User::find(session('user')['id']);
        return view('/Home/my_message',['user'=>$user]);
    }



}
