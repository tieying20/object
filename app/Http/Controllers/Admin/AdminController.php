<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Models\Admin;
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = Admin::all();
        // dump($list);
        // 用户列表页
        return view('/Admin/users/member-list',['list'=>$list]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // 显示添加页面
        return view('/Admin/users/member-add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 执行添加
        
        // 开启事务   
        DB::beginTransaction();

        // $res = DB::table('admin')->insert($request->all());

        // $data = $request->only(['username','pass','role']);

        $admin = new Admin;
        $admin->admin_name = $request->admin_name;
        $admin->admin_pwd = $request->admin_pwd;
        $admin->role = $request->role;
        $res = $admin->save();

        if($res){
            // 成功 
            // 提交事务    
            DB::commit();
            //return $request->all();
            return 0;
        }else{
            // 失败
            // 回滚事务   
            DB::rollBack();
            return 1;
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
}
