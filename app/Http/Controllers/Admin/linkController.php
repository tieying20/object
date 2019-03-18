<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Models\blogrolls;
class linkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        // 搜索的内容
        $search = $request->input('search','');

        // 显示条数
        $count = $request->input('count','5');

        $list = blogrolls::where('b_company','like','%'.$search.'%')->paginate($count);
        return view('Admin/link/link-list',['list'=>$list,'count'=>$count,'search'=>$search]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin/link/link-add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //接收值
        $link = new blogrolls;
        $link->b_company = $request->input('b_company');
        
        //url验证
        $reg = '/^([hH][tT]{2}[pP]:\/\/|[hH][tT]{2}[pP][sS]:\/\/|www\.)(([A-Za-z0-9-~]+)\.)+([A-Za-z0-9-~\/])+$/';

        if(preg_match($reg,$request->input('b_url'))){
            $link->b_url = $request->input('b_url');

            $res = $link->save();
        }
        if($res){
            // 添加成功
            return 0;
            
        }else{
            //添加失败
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
        $list = blogrolls::find($id);

        return view('Admin/link/link-edit',['list'=>$list]);
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
        $link = blogrolls::find($id);
        //接收值
        $link['b_company'] = $request->input('b_company');

        $reg = '/^([hH][tT]{2}[pP]:\/\/|[hH][tT]{2}[pP][sS]:\/\/|www{3}\.{1})(([A-Za-z0-9-~]+)\.{1})+([A-Za-z0-9-~\/])+$/';
        if(preg_match($reg,$request->input('b_url'))){
            $link['b_url'] = $request->input('b_url');

            $res = $link->save();
        }

        if($res){
            // 修改成功
            return 1;
            
        }else{
            //修改失败
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
        $id = explode(',',$id);
        // return $id;
        // 删除数据
        $res = blogrolls::destroy($id);

        // dump($id);
        if($res){
            //删除成功
            return 1;
        }else{
            //删除失败
            return 0;
        }
    }

    public function Status(Request $request, $id, $status){
        //修改状态
        $link = blogrolls::find($id);
        $link->status = $status;
        $res = $link->save();

        if($res){
            //成功
            return 1;
        }else{
            //失败
            return 2;
        }
    }
}
