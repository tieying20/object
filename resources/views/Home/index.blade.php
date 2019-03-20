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










<!-- 赞助商开始 -->
  @section('sponsor')
    @if(!empty($sponsor['0']))
      @foreach($sponsor as $k => $v)
        @if($v['status'] == 0)
          <a href="{{ $v['img_url'] }}" target="_blank" rel="nofollow" class="fly-zanzhu fly-zanzhu-img" time-limit="2019-04-15 0:0:0" style="background: none;"> <img src="/upload/{{ $v['img_path'] }}" alt="CODING" style="width:340px;height:60.33px;"> </a>
        @endif
      @endforeach
    @else
      <a href="#" class="fly-zanzhu" time-limit="2017.09.25-2099.01.01" style="background-color: #5FB878;">欢迎赞助商加盟入驻</a>
    @endif
  @endsection
<!-- 赞助商结束 -->








<!-- 友情链接开始 -->
@section('link')
  @foreach($link as $k => $v)
    @if($v['status'] == 0)
      <dd><a href="{{ $v['b_url'] }}" target="_blank">{{ $v['b_company'] }}</a><dd>
    @endif
  @endforeach
  <dd><a href="javascript:;" onclick="layer.alert('发送邮件至：www@163.com<br> 邮件标题为：申请有个社区友链', {title:'申请友链'});" class="fly-link">申请友链</a></dd>
@endsection


<!-- 友情链接结束 -->
