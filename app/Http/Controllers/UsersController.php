<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserinfoStoreRequest;
use App\Models\User;
use App\Models\Userinfo;
use DB;
use Hash;
use Auth;

class UsersController extends Controller
{
    /**
     * 后台用户列表
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $users = User::all();
        // dump($users);

        // 搜索的内容
        $search = $request->input('search','');

        // 显示条数
        $count = $request->input('count','10');

        $user = User::where('phone','like','%'.$search.'%')->paginate($count);
        // 序号
        $i = 1;

        return view('Admin/users/index',['user'=>$user,'search'=>$search,'i'=>$i,'count'=>$count]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // 注册页面
        return view('Home/create');
    }

    /**
     * 处理注册
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {

        // dd($request->all());

        // 开启事务
        DB::beginTransaction();

        // 将数据压入到数据库
        $user = new User;
        $user->u_name = $request->input('u_name','');
        $user->pwd = Hash::make($request->input('pwd',''));
        $user->phone = $request->input('phone','');
        $res = $user->save();

        //接收的id
        $id = $user->id;
        // 用户详情表
        $userinfo = new Userinfo;
        $userinfo->uid = $id;
        $res2 = $userinfo->save();

        if($res && $res2){
            // 提交事务
            DB::commit();
            return redirect('home/login')->with('success','注册成功请登录账号！');
        }else{
            // 回滚事务
            DB::rollBack();
            return back()->with('error','注册失败，请联系管理员！');
        }
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
     * 后台显示前台用户详情
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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

    // 登录页面
    public function login()
    {
        return view('Home/login');
    }

    // 处理登录
    public function dologin(UserinfoStoreRequest $request)
    {
        // 获取登录的值
        $home_phone = $request->input('phone','');
        $home_pwd = $request->input('pwd','');

        $user = User::where('phone',$home_phone)->first();
        // 判断账号是否存在
        if(!$user){
            return back()->with('error','账号不存在');
        }

        $sql_pwd = $user->pwd;
        if(!Hash::check($home_pwd,$sql_pwd)){
            $request->flash();
            return back()->with('error','密码不正确');
        }

        // 登录信息压入session
        session([
            'user'=>['phone'=>$user->phone,'id'=>$user->id,'u_name'=>$user->u_name,'head_img'=>$user->userinfo->head_img]
            ]);
        return redirect('/');
    }

    // 退出登录
    public function loginout(Request $request){
        if(!$request->session()->forget('user')){
            return redirect('/');
        }else{
            dump('退出失败');
        }
    }
}
