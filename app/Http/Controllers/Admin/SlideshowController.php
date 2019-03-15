<?php

namespace App\Http\Controllers\Admin;

use App\Models\Slideshow;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SlideshowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 轮播图列表
        $list = [null];
        return view('Admin/slideshow/slide_list',['list'=>$list]);
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
        // 图片上传部分
        // 判断有没有上传图片
        if($request->hasFile('uploadFile')){
            // 获取图片对象
            $file_img = $request->file('uploadFile');
            // 保存图片并返回图片名
            $file_name = $file_img->store('slide_img');
            echo $file_name;
        }

        // 其余内容处理
        dump($request->all());
        $slideshow = new Slideshow;
        $slideshow->s_company = $request->input('s_company','');
        $slideshow->img_path = $request->input('s_company','');
        $slideshow->img_url = $request->input('uploadFile','');
        $slideshow->start_at = time($request->input('start_at',''));
        $slideshow->stop_at = time($request->input('stop_at',''));
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
    public function show(Slideshow $slideshow)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Slideshow  $slideshow
     * @return \Illuminate\Http\Response
     */
    public function edit(Slideshow $slideshow)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Slideshow  $slideshow
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slideshow $slideshow)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slideshow  $slideshow
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slideshow $slideshow)
    {
        //
    }
}
