<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post_column extends Model
{
    // 栏目名称
    public $table = 'post_column';

    // 配置一对多关系  栏目对贴子
    public function postList()
    {
    	return $this->hasMany('App\Models\Postlist','column_id');
    }
}
