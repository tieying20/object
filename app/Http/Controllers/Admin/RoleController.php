<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Role;

class RoleController extends Controller
{
    /**
     * 角色列表
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // echo 11;
        // 搜索的内容
        $search = $request->input('search','');

        // 显示条数
        $count = $request->input('count','10');

        $role = Role::where('name','like','%'.$search.'%')->paginate($count);
        // 序号
        $i = 1;

        return view('/Admin/role/role-list',['role'=>$role,'search'=>$search,'i'=>$i,'count'=>$count]);
    }

    /**
     * 添加角色
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('/Admin/role/role-add');
    }

    /**
     * 处理添加角色
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dump($request->all());
        $name = $request->input('name','');
        $role = Role::where('name',$name)->first(); 
        // 判断角色名是否存在
        if($role){
            return 1;
        }

        $role = new Role;
        $role->name = $name;
        $res = $role->save();

        if($res){
            // 成功
            return 0;
        }else{
            // 失败
            return 1;
        }
    }

    /**
     * 
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * 修改页面
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $role = Role::find($id);
        return view('/Admin/role/role-edit',['role'=>$role]);
    }

    /**
     * 处理修改角色
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $name = $request->input('name','');
        $role = Role::where('name',$name)->first(); 
        // 判断角色名是否存在
        if($role){
            return 1;
        }

        $role = Role::find($id);
        $role->name = $name;
        $res = $role->save();

        if($res){
            // 成功
            return 0;
        }else{
            // 失败
            return 1;
        }
    }

    /**
     * 删除角色
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $id = explode(',', $id);
        $res = Role::destroy($id);
        if($res){
            // 成功
            return 1;
        }else{
            // 失败
            return 2;
        }
    }

    // 修改角色状态
    public function setStatus(Request $request, $id){
        // 获取要修改状态的id
        $role = role::find($id);
        // 获取该用户状态
        $status = $role->status;
        if($status == 0){
            $role->status = 1;
            $res = $role->save();
        }else{
            $role->status = 0;
            $res = $role->save();
        }
        if($res){
            // 成功
            return '1';
        }else{
            // 失败
            return '2';
        }
    }
}
