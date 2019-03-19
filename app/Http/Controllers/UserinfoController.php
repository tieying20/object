<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Userinfo;
use App\Models\User;
use DB;
use Hash;

class UserinfoController extends Controller
{
    /**
     * 用户详细主页
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $user = User::find($id);
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
    public function create($id)
    {
        // 用户中心
        $user = User::find($id);

        return view('/Home/user_center',['user'=>$user]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // 基本设置
        $user = User::find($id);

        return view('/Home/user_set',['user'=>$user]);
    }

    /**
     * 后台显示前台用户详情
     *
     * @param  int  $id 
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // 后台显示前台用户详情
        $user = User::find($id);
        // dump($user);
        // dump($user->userinfo);
        return view('Admin/users/userinfo',['user'=>$user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function message($id)
    {
        // 我的信息
        $user = User::find($id);

        return view('/Home/my_message',['user'=>$user]);
    }

}
