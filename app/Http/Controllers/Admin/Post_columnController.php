<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Post_column;

class Post_columnController extends Controller
{
    /**
     * 显示栏目
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dump(11);
        $post_column = Post_column::all();
        // dump($programa);

        return view('Admin/post_column/post_column_list',['post_column'=>$post_column]);
    }

    /**
     * 添加栏目页面
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin/post_column/post_column_add');
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
        $post_column = new Post_column;
        $post_column->post_name = $request->input('post_name');
        $post_column->order = $request->input('order');
        if(!$post_column->post_name == ''){
            $res = $post_column->save();
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
     * 显示修改页面
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post_column = Post_column::find($id);
        return view('/Admin/post_column/post_column_edit',['post_column'=>$post_column]);
    }

    /**
     * 处理修改
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        
        $name = $request->input('post_name','');
        // dd($name);
        // $post_column = Post_column::where('post_name',$name)->first(); 
        // // 判断栏目是否存在
        // if($post_column){
        //     return 1;
        // }

        $post_column = Post_column::find($id);
        $post_column->post_name = $name;
        $res = $post_column->save();

        if($res){
            // 成功
            return 0;
        }else{
            // 失败
            return 1;
        }
    }

    /**
     * 删除栏目
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = explode(',', $id);
        $res = Post_column::destroy($id);
        if($res){
            // 成功
            return 1;
        }else{
            // 失败
            return 2;
        }
    }
}
