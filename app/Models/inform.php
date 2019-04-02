<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class inform extends Model
{
    // 指定数据表
    public $table = 'inform';

    // 属于举报的用户
    public function user()
    {
        return $this->belongsTo('App\Models\User','uid');
    }

    // 属于回复
    public function reply()
    {
        return $this->belongsTo('App\Models\reply','rid');
    }
}
