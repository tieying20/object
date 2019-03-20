@extends('Home/layout/model')



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
        <span class="fly-signin-days">已连续签到<cite>16</cite>天</span>
      </div>
      <div class="fly-panel-main fly-signin-main">
        <button class="layui-btn layui-btn-danger" id="LAY_signin">今日签到</button>
        <span>可获得<cite>5</cite>飞吻</span>

        <!-- 已签到状态 -->
        <!--
        <button class="layui-btn layui-btn-disabled">今日已签到</button>
        <span>获得了<cite>5</cite>飞吻</span>
        -->
      </div>
    </div>

@endsection



<!-- 签到模块结束 -->
















