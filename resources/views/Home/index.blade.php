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
      </div>x
  </div>
@endsection
<!-- 轮播图结束 -->




















