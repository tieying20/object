<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    // 指定数据表
    public $table = 'notice';

    // 通知属于发起用户
    public function user()
    {
        return $this->belongsTo('App\Models\User','uid');
    }

    // 通知属于哪个贴子
    public function postlist()
    {
        return $this->belongsTo('App\Models\Postlist','pid');
    }

}
