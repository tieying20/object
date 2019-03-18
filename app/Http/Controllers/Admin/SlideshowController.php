<?php

namespace App\Http\Controllers\Admin;

use App\Models\Slideshow;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class SlideshowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // 轮播图列表
        // 搜索的内容
        $search = $request->input('search','');

        // 显示条数
        $count = $request->input('count','5');
        $list = Slideshow::where('s_company','like','%'.$search.'%')->paginate($count);
        // dump($list->currentPage()); 当前页码
        // 每页首个序号
        $firstItem = $list->firstItem();
        return view('Admin/slideshow/slide_list',['list'=>$list,'search'=>$search,'count'=>$count,'firstItem'=>$firstItem]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // 添加页面
        return view('Admin/slideshow/slide_add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 添加
        $slideshow = new Slideshow;
        $slideshow->s_company = $request->input('s_company');
        $slideshow->img_path = $request->input('img_path');
        $slideshow->img_url = $request->input('img_url');
        $slideshow->start_at = strtotime($request->input('start_at'));
        $slideshow->stop_at = strtotime($request->input('stop_at'));
        $res = $slideshow->save();
        // 成功返回1
        // 失败返回2
        if($res){
            return 1;
        }else{
            return 2;
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Slideshow  $slideshow
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Slideshow  $slideshow
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // 编辑页面
        $data = Slideshow::find($id);
        return view('/Admin/slideshow/slide_edit',['data'=>$data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Slideshow  $slideshow
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // 执行编辑操作
        // dump($request->all());
        // dump(strtotime($request->input('start_at')));
        // dump(strtotime($request->input('stop_at')));
        $slideshow = Slideshow::find($id);
        $slideshow->s_company = $request->input('s_company');
        $slideshow->img_path = $request->input('img_path');
        $slideshow->img_url = $request->input('img_url');
        $slideshow->start_at = strtotime($request->input('start_at'));
        $slideshow->stop_at = strtotime($request->input('stop_at'));
        $res = $slideshow->save();
        // 成功返回1
        // 失败返回2
        if($res){
            return 1;
        }else{
            return 2;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slideshow  $slideshow
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        // 把id拼接成数组
        $id = explode(',', $id);
        // 获取要删除的图片路径
        $img_list = Slideshow::select('img_path')->whereIn('id',$id)->get();
        // 处理图片路径，去掉/upload
        $img_path = [];
        foreach($img_list as $k=>$v){
            $img_path[] = substr($v['img_path'], 7);
        }
        Storage::delete($img_path);

        // 删除对应的数据库信息
        $res = Slideshow::destroy($id);
        // 成功返回1
        // 失败返回2
        if($res){
            return 1;
        }else{
            return 2;
        }
    }

    public function file_img(Request $request){
        // 图片上传部分
        // 有新也有旧就是编辑操作的上传
        if($request->hasFile('uploadFile') && $request->input('oldfile')){
            Storage::delete(substr($request->input('oldfile'), 7));
            // 获取图片对象
            $file_img = $request->file('uploadFile');
            // 保存图片并返回图片名
            $file_name = $file_img->store('slide_img');
            return $file_name;
        }elseif($request->hasFile('uploadFile')){
            // 获取图片对象
            $file_img = $request->file('uploadFile');
            // 保存图片并返回图片名
            $file_name = $file_img->store('slide_img');
            return $file_name;
        }
    }
}
