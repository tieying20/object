<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public $table = 'user';


 // 配置 一对一 模型关系
    public function userinfo()
    {
        return $this->hasOne('App\Models\Userinfo', 'uid');
    }

}