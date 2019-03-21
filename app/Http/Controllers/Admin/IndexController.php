<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Hash;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dump(session('admin')['admin_name']);
        // 显示index模板
        return view('Admin/index/index');
    }

    // 首页的欢迎页面
    public function welcome()
    {   
         
        // dump($_ENV);
        return view('Admin/index/welcome');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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

    /** 后台登录 */
    public function login()
    {
        // echo '后台登录';
        
        return view('admin/login');
    }

    /** 处理后台登录 */
    public function dologin(Request $request)
    {
        // dump($request->all());
        // 获取登录的值
        $aname = $request->input('admin_name','');
        $apwd = $request->input('admin_pwd','');

        $admin = Admin::where('admin_name',$aname)->first();
        // dd($admin);
        // 判断账号是否存在
        if(!$admin){
            return back()->with('error','账号或密码不正确');
        }

        $sql_pwd = $admin->admin_pwd;
        // dd($sql_pwd);
        if(!Hash::check($apwd,$sql_pwd)){
            $request->flash();
            return back()->with('error','账号或密码不正确');
        }

        // 登录信息压入session
        session([
            'admin'=>['admin_name'=>$admin->admin_name,'id'=>$admin->id]
            ]);
        return redirect('/admin/index');
    }

    /** 后台退出登录 */
    public function loginout(Request $request)
    {
        // echo '1';
        if(!$request->session()->forget('admin')){
            return redirect('admin/login');
        }        
    }
}
