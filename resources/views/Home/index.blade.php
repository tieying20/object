@extends('Home/layout/model')
<meta name="csrf-token" content="{{ csrf_token() }}">


<!-- 轮播图开始 -->
@section('slideshow')
  <div class="middle_right">
      <div id="lunbobox">
      <div id="toleft">&lt;</div>
      <div class="lunbo">
          @foreach($slide_list as $k=>$v)
          <a href="{{ $v['img_url'] }}" target="_block"><img src="{{ $v['img_path'] }}"></a>
          @endforeach
      </div>
      <div id="toright">&gt;</div>
      <ul>
          @foreach($slide_list as $k=>$v)
          <li></li>
          @endforeach
      </ul>
      <span></span>
      </div>
  </div>
@endsection
<!-- 轮播图结束 -->


<!-- 签到模块开始 -->
@section('signin')
    <div class="fly-panel fly-signin">
      <div class="fly-panel-title">
        签到
        <i class="fly-mid"></i>
        <a href="javascript:;" class="fly-link" id="LAY_signinHelp">说明</a>
        <i class="fly-mid"></i>
        <a href="javascript:;" class="fly-link" id="LAY_signinTop">活跃榜<span class="layui-badge-dot"></span></a>
        <span class="fly-signin-days">已连续签到<cite> </cite>天</span>
      </div>
      <div class="fly-panel-main fly-signin-main" style="height:340px;">
      <div id="date" style="margin-top:-21px;margin-bottom:10px; "></div>
        <button class="layui-btn layui-btn-danger" id="signin">今日签到</button>
        <span>可获得<cite>5</cite>飞吻</span>
        <!-- 已签到状态 -->
        <!--
        <button class="layui-btn layui-btn-disabled">今日已签到</button>

        <span>获得了<cite>5</cite>飞吻</span>
        -->
      </div>
    </div>
@endsection
<!-- 签到script -->
@section('signin_script')
  layui.use('laydate', function(){
    var laydate = layui.laydate;
    laydate.render({
      elem: '#date'
      ,btns: ['now']
      ,calendar: true
      ,position: 'static'
      ,min: '{:date("Y-m-d", mktime(0,0,0, date("m")-1, 1, date("Y")) )}'
      ,max: '{:date("Y-m-d")}'
      ,ready: function(date){
        //控件在打开时触发
        console.log('date', date);;
        distd();
        getdate(date);
      }
      ,change: function(value, date, endDate){
        //时间被切换时触发
        console.log('date', date);
        distd();
        getdate(date);
      }
    }); 
  });

  // 1、获取签到日期。 初始化当前年月，获取签到列表
  // 2、根据日期添加标签。
  var smiles  =  '<i class="fa fa-smile-o faicon" aria-hidden="true"></i>';
  //禁止点击日历
  function distd(){
    $('.layui-laydate-content tbody td').each(function(){
      if ( $(this).hasClass('laydate-disabled') == false ) {
        $(this).addClass('laydate-disabled');
      }
    });
  }

  // 获取签到日期，循环添加签到
function getdate(cdate=''){
  $.post({
      url :'/home/signin',
      cdate : cdate,
      success : function(result){
        console.log(result);
        if(result.rescode < 0){
          return ;
        }
        //拿数据
        smileok(result);
      }
    });

  function smileok(signindata)
  {
    for (var i = signindata.length - 1; i >= 0; i--) {
      $('td').each(function(){
        var ymd = $(this).attr('lay-ymd');
        // console.log(ymd);
        if ( ymd == signindata[i] ) {
          $(this).append(smiles);
          return true;
        }
      });
    }
  }
}

// 处理是否签到过
function  getSign(){
  $('#signin').removeClass('signbtn');
  $('#singin').class('layui-btn layui-btn-disabled');
}

$('#signin').click(function(){
  var curdate = new Date();
  var date ={ 'year':curdate.getFullYear(), 'month':curdate.getMonth()+1 }
  



})













@endsection
<!-- 签到模块结束 -->
















