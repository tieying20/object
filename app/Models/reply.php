<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class reply extends Model
{
    // 指定数据表
    public $table = 'post_reply';

    // 配置属于关系  回复属于贴子
    public function postlist(){
        return $this->belongsTo('App\Models\Postlist','post_list_id');
    }

    // 配置属于关系  回复属于用户
    public function user(){
        return $this->belongsTo('App\Models\User','uid');
    }
}
