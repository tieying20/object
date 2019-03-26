<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\sign_infos;
use DB;
class SigninController extends Controller
{
	
    public function sign(Request $request)
    {	
    	//签到
    	
    	$signin = new sign_infos;
    	//获取值
    	// return $request->input();
    	$year  = $request->input('year');
        $month  = $request->input('month');
        $day = $request->input('day');
        //获取用户uid
        $uid = session('user')['id'];
        ///查询用户的签到
        $signinfo = DB::table('sign_info')
        ->where('year',$year)
        ->where('month',$month)
        ->where('uid',$uid)
        ->get();
        // $res = null;
	        //判断用户有无签到过	        
	        if (!$signinfo->first()) {
	        	//为空
	            $signin->uid = $uid;
	            $signin->year = $year;
	            $signin->month = $month;
	            $signin->signlist = $day;
	            $signin->point += $this->point();
	            $signin->save();
	        }else{
	        	//不为空
	        	foreach($signinfo as $k => $v){
   					$res = $v->signlist;
   					$point = $v->point;

		            $signlist = $res.','.$day;
		            $point += $this->point();

		            $data = DB::table('sign_info')->where('month',$month)->update(['point'=>$point,'signlist'=>$signlist]);

	            };
	        }
        // return 1;       
        if($signin || $data){
        	return 0;
        }else{
        	return 1;
        }
    	
    }
    public function hassign(Request $request,$uid)
    {
    	//处理用户是否签到
        $day  =  date("j");
       
        $array  =  explode(',', $signinfo['signlist']);
        if ( in_array($curday, $array) ) {
            return -1;
        }
        return 1;

    	
    }

    public function has(Request $request)
	{
		//获取用户签到日期
		return $request->input();
	}

	public function point()
	{
		//获取积分
		$score = 20;
		return $score;
	}
}
