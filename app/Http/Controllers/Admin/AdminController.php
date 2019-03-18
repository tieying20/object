<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Hash;
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // 管理员列表页

        // 搜索的内容
        $search = $request->input('search','');

        // 显示条数
        $count = $request->input('count','5');
        $list = Admin::where('admin_name','like','%'.$search.'%')->paginate($count);
        // dump($list->currentPage());
        // 每页首个序号
        $firstItem = $list->firstItem();
        return view('/Admin/admin/member-list',['list'=>$list,'search'=>$search,'count'=>$count,'firstItem'=>$firstItem]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // 显示添加页面
        return view('/Admin/admin/member-add');
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
        $admin = new Admin;
        $admin->admin_name = $request->input('admin_name');
        $admin->admin_pwd = Hash::make($request->input('admin_pwd'));
        $admin->role = $request->input('role');
        $res = $admin->save();
        if($res){
            // 成功
            return 0;
        }else{
            // 失败
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
        // 修改页面
        $edit_data = Admin::find($id);
        return view('/Admin/admin/member-edit',['edit_data'=>$edit_data]);

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
        // 执行修改
        $admin = Admin::find($id);
        // 输入的旧密码
        $old_pwd = $request->input('admin_pwd');
        if(isset($old_pwd)){
            // 获取数据库密码
            $sql_pwd = Admin::select(['admin_pwd'])->find($id)['admin_pwd'];
            // 旧密码不正确，返回0
            if(!Hash::check($old_pwd, $sql_pwd)){
                return 0;
            }
            // 获取新密码
            $new_pwd = Hash::make($request->input('a_repwd'));
            // 更改密码
            $admin->admin_pwd = $new_pwd;
        }

        // 获取等级
        $role = $request->input('role');
        $admin->role = $role;
        $res = $admin->save();
        if($res){
            // 成功
            return 1;
        }else{
            // 失败
            return 2;
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // 删除管理员
        $id = explode(',', $id);
        // return $id;
        $res = Admin::destroy($id);
        if($res){
            // 成功
            return 1;
        }else{
            // 失败
            return 2;
        }
    }

    public function setStatus(Request $request, $id, $status){
        // 获取要修改状态的id
        $admin = Admin::find($id);
        $admin->status = $status;
        $res = $admin->save();
        // dump($admin);
        // echo $status;
        if($res){
            // 成功
            return 1;
        }else{
            // 失败
            return 2;
        }

    }
}
