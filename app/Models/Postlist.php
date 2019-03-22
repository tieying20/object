<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Postlist extends Model
{
    // 指定数据表
    public $table = 'post_list';

    // 配置属于关系  贴子属于用户
    public function user(){
    	return $this->belongsTo('App\Models\User','uid');
    }

    // 配置属于关系  贴子属于栏目
    public function postColumn(){
    	return $this->belongsTo('App\Models\Post_column','column_id');
    }
}
