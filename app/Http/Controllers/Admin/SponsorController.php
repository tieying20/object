<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Models\sponsors;
use Illuminate\Support\Facades\Storage;
class SponsorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // 赞助商列表页
    
        // 搜索的内容
        $search = $request->input('search','');

        // 显示条数
        $count = $request->input('count','5');

        $list = sponsors::where('s_company','like','%'.$search.'%')->paginate($count);

        return view('Admin/sponsor/sponsor-list',['list'=>$list,'search'=>$search,'count'=>$count]);
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
        

        //执行添加
        $sponsor = new sponsors;
        $sponsor->img_path = $request->input('img_path');
        $sponsor->s_company = $request->input('s_company');
        $sponsor->start_at = $request->input('start_at');
        $sponsor->stop_at = $request->input('stop_at');
        //url验证
        $reg = '/^([hH][tT]{2}[pP]:\/\/|[hH][tT]{2}[pP][sS]:\/\/|www\.)(([A-Za-z0-9-~]+)\.)+([A-Za-z0-9-~\/])+$/';

        if(preg_match($reg,$request->input('img_url'))){
            $sponsor->img_url = $request->input('img_url');

            $res = $sponsor->save();
        }
        
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
        $v = sponsors::find($id);
        return view('Admin/sponsor/sponsor-edit',['v'=>$v]);
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
        //找到需要修改的数据
        $sponsor = sponsors::find($id);
        //接收修改的值
        $sponsor['s_company'] = $request->input('s_company');
        $sponsor['start_at'] = $request->input('start_at');
        $sponsor['stop_at'] = $request->input('stop_at');
        
        //判断有无新图片上传
        if($request->input('img_path')){
            // 获取路径
            $path = $sponsor['img_path'];    
            //删除本地图片           
            Storage::delete($path);
            //将新数据压入数据库
            $sponsor['img_path'] = $request->input('img_path');
        }
        // url验证
        
            $reg = '/^([hH][tT]{2}[pP]:\/\/|[hH][tT]{2}[pP][sS]:\/\/|www{3}\.{1})(([A-Za-z0-9-~]+)\.{1})+([A-Za-z0-9-~\/])+$/';
            if(preg_match($reg,$request->input('img_url'))){
                $sponsor['img_url'] = $request->input('img_url');
                $res = $sponsor->save();
            }

        // $res = $sponsor->save();

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
        //删除上传的文件
        $data =sponsors::find($id);
        // return $data;
        $path = $data['img_path']; 
        
        //删除本地图片           
        $res1 =  Storage::delete($path);
        //删除数据
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

    public function Upimg(Request $request){
        //图片上传
        // if($request->hasFile('sponsor')){
            $file = $request->file('photo');
            $path = $file->store('sponsor');
            // //拼装文件路径
            // $filepath ='/upload/'.$path;
            return response()->json(['code'=>0,'file'=>$path]);
        // }else{
        //     dd('请选择文件');
        // }
    }

    public function Status(Request $request, $id, $status){
        // 修改状态
        $sponsor = sponsors::find($id);
        $sponsor->status = $status;
        $res = $sponsor->save();
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
