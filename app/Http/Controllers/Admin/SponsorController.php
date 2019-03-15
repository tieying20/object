<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Models\sponsors;
class SponsorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 赞助商列表页
        $list = sponsors::all();
        return view('Admin/sponsor/sponsor-list',['list'=>$list]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //显示添加页面
        
        return view('Admin/sponsor/sponsor-add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        // 图片上传
        $file = $request->file('photo');
        // $path = $file->store('sponsor');
        //拼装文件路径
        // $filepath ='/upload'.$path;
        // return response()->json(['code'=>0,'path'=>$path,'file',$file]);
        
        


        //执行添加
        $sponsor = new sponsors;
        // $sponsor->img_push = $filepath;
        $sponsor->s_company = $request->input('s_company');
        $sponsor->start_at = $request->input('start_at');
        $sponsor->stop_at = $request->input('stop_at');
        $sponsor->img_url = $request->input('img_url');
        $res = $sponsor->save();

        // dump($res); 
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
        $res = sponsors::destroy($id);
        // dump($id);
        if($res){
            //删除成功
            return 1;
        }else{
            //删除失败
            return 0;
        }
        
    }
}
