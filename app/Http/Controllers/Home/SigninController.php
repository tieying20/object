<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\sign_infos;
use App\Models\Userinfo;
use DB;
class SigninController extends Controller
{
	/**
     * 签到
     *
     * @return \Illuminate\Http\Request
     */
    public function sign(Request $request)
    {	
    	// return 0;
    	$signin = new sign_infos;
    	//获取值
    	// return $request->input();
    	$year  = $request->input('year');
        $month  = $request->input('month');
        $day = $request->input('day');
        //获取用户uid
        $uid = session('user')['id'];
        //查询用户的签到
        $signinfo = DB::table('sign_info')
        ->where('year',$year)
        ->where('month',$month)
        ->where('uid',$uid)
        ->get();
        //用户详情 关联积分
        $userinfo = Userinfo::where('uid','=',$uid)->first();
        // return $userinfo['integral'];
        // $res = null;
        //判断用户有无签到过	        
        if (!$signinfo->first()) {
        	//为空
            $signin->uid = $uid;
            $signin->year = $year;
            $signin->month = $month;
            $signin->signlist = $day;
            $signin->save();

            $userinfo['integral'] += $this->point();//积分
            $userinfo->save();

            if($signin){
            	return 0;// 首次/月 签到
            }
        }else{
        	//不为空
        	//是否连续签到       	
        	foreach($signinfo as $k => $v){        		
				$res = $v->signlist;//签到日期列表
				$xunnum = $v->xunum;//连续签到天数
				$updated = $v->updated_at;//签到的时间
				$updated = strtotime($updated);
				$int = date('Y-m-d');//当前日
				$int = strtotime($int);
				$ints = $int + 86400;//明天    
    			$int_s = $int - 86400;//昨天

				if($int < $updated && $updated < $ints){
					return 3;//当前日已经签到,返回

				}else if ($updated < $int_s) {
					// return 5;
					//昨日未签到 连续签到恢复1天
					$signlist = $res.','.$day;
		            $userinfo['integral'] += $this->point();
		            $xunnum = 1;
		            $updated = date('Y-m-d H:i:s');

		            $data = DB::table('sign_info')->where('month',$month)->where('uid',$uid)->update(['signlist'=>$signlist,'xunum'=>$xunnum,'updated_at'=>$updated]);
                    $data2 = $userinfo->save();
                    
		            if($data && $data2){
		            	return 0;
		            }
	            }else{
                    //昨日已签,连续签到+1
		            $signlist = $res.','.$day;
                    //根据连续签到天数判断获得积分
                    if($xunnum <5){
		                $userinfo['integral'] += $this->point();
                    }else if($xunnum <15){
                        $userinfo['integral'] += 5 + $this->point();
                    }else if($xunnum >=15){
                        $userinfo['integral'] += 10 + $this->point();
                    }
		            $xunnum += 1;
                    
		            $updated = date('Y-m-d H:i:s');
		            
		            $data = DB::table('sign_info')->where('month',$month)->where('uid',$uid)->update(['signlist'=>$signlist,'xunum'=>$xunnum,'updated_at'=>$updated]);
		            $data2 = $userinfo->save();

                    if($data && $data2){
                        return 0;
                    }
	            }

            };
            
        }
    	
    }
    /**
     * 获取用户签到日期
     *
     * @return \Illuminate\Http\Request
     */
    public function has(Request $request)
	{
        $uid = session('user')['id'];
		$year = $request->input('year');
        $month = $request->input('month');

        $signinfo = sign_infos::where('uid','=',$uid)->where('year',$year)->where('month',$month)->first();
        // return $signinfo['signlist'];
        if($signinfo){
            //分割成数组
            $signarray = explode(',',$signinfo['signlist']);
            $sarray  =  [];
            foreach ($signarray as $key => $value) {
                $sarray[]  =  $signinfo['year'].'-'.$signinfo['month'].'-'.$value;
            }
            return $sarray;
        }
        return ['rescode'=>-1, 'msg'=>'数据为空！'];
	}

	public function point()
	{  
		//获取积分
    	   $score = 5;
    	   return $score;
	}
}
