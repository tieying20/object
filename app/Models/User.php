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

     // 配置 一对一 签到模型
 	public function sign_info()
 	{
 		return $this->hasOne('App\Models\sign_infos','uid');
 	}

 	// 配置 一对多 贴子模型
    public function postlist(){
    	return $this->hasMany('App\Models\postlist','uid');
    }

}
