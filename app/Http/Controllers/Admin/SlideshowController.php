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
        // 判断有没有上传图片
        if($request->hasFile('uploadFile')){
            // 获取图片对象
            $file_img = $request->file('uploadFile');
            // 保存图片并返回图片名
            $file_name = $profile->store('images');
            return $file_name;
        }else{
            return 'error';
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
