<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\sign_infos;
class SigninController extends Controller
{
	
    public function sign()
    {
    	//签到
    	return 1;
    	
    }
    public function  hassign()
    {
    	//处理用户是否签到
    	
    }
    
    public function has()
	{
		//获取用户签到日期
		return 1;
	}
}
