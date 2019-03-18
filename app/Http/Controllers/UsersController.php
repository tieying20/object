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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        // dump($users);
        // 用户列表
        return view('Admin/users/index',['users'=>$users]);
        
        
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
          
        // 处理注册
        // dd($request->all());

        // 开启事务   
        DB::beginTransaction();  

        // 将数据压入到数据库
        $user = new User;
        $user->u_name = $request->input('u_name','');
        $user->pwd = Hash::make($request->input('pwd',''));
        $user->phone = $request->input('phone','');
        $res = $user->save();

        //接受的id 
        $id = $user->id;
        // 用户详情表
        $userinfo = new Userinfo;
        $userinfo->uid = $id;
        $res2 = $userinfo->save();

        if($res && $res2){
            // 提交事务
            DB::commit();
            // return redirect('/home/index');
            echo '<script>alert("注册成功");location="/home/index"</script>';
        }else{
            // 回滚事务
            DB::rollBack();
            return back('/user/create/')->with('error','注册失败');
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

    // 登录页面
    public function login()
    {
        return view('Home/login');
    }

    // 处理登录
    public function dologin(Request $request)
    {
        // 获取登录的值
        // dump($request->all());
        $home_phone = $request->input('phone','');
        $home_pwd = $request->input('pwd','');

        $user = User::where('phone',$home_phone)->first();
        $pwd = $user->pwd;
        // $phone = $user->phone;
        // dump($pwd);
        
        if(!Hash::check($home_pwd,$pwd)){
            $i = '密码不正确！';
            // echo $i;
            // return back('/home/login')->with('message', '用户名或密码错误');
            return redirect('/home/login/');
            // echo '<script>alert("登录失败");location="/home/index"</script>';
            // exit;
        }
        // dump($pwd);
        echo '<script>alert("登录成功");location="/home/index"</script>';

            
            
    }
}
