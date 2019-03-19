<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Programa;

class ProgramaController extends Controller
{
    /**
     * 显示栏目
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dump(11);
        return view('Admin/programa/programa_list');
    }

    /**
     * 添加栏目页面
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin/programa/programa_add');
    }

    /**
     * 处理添加栏目
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->input('p_name'));
        $programa = new Programa;
        $programa->p_name = $request->input('p_name');
        if(!$programa->p_name == ''){
            $res = $programa->save();
            // dump($res);
            if($res){
                // 成功
                return '0';
            }else{
                // 失败
                return '1';
            }
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
