@include('/Home/layout/header')

<div class="fly-home fly-panel" style="background-image: url();">
  <img src="{{ $user->userinfo->head_img }}" alt="贤心">
  <i class="iconfont icon-renzheng" title="有个社区认证"></i>
  <h1>
    {{ $user->u_name }}
    <i class="iconfont icon-nan"></i>
    <!-- <i class="iconfont icon-nv"></i>  -->
    <!-- <i class="layui-badge fly-badge-vip">VIP3</i> -->
    <!--
    <span style="color:#c00;">（管理员）</span>
    <span style="color:#5FB878;">（社区之光）</span>
    <span>（该号已被封）</span>
    -->
  </h1>

  <!-- <p style="padding: 10px 0; color: #5FB878;">认证信息：layui 作者</p> -->

  <p class="fly-home-info">
    <i class="iconfont icon-kiss" title="积分"></i><span style="color: #FF7200;">{{$userinfo['integral']}} 积分</span>
    <i class="iconfont icon-shijian"></i><span>{{ $user->created_at }}加入</span>
    <i class="iconfont icon-chengshi"></i><span>来自{{ $user->userinfo->city }}</span>
  </p>

  <p class="fly-home-sign">{{ $user->userinfo->describe }}</p>

  <div class="fly-sns" data-user="">
    <a href="javascript:;" class="layui-btn layui-btn-primary fly-imActive" data-type="addFriend">加为好友</a>
    <a href="javascript:;" class="layui-btn layui-btn-normal fly-imActive" data-type="chat">发起会话</a>
  </div>

</div>

<div class="layui-container">
  <div class="layui-row layui-col-space15">
    {{-- 左侧回复板块 --}}
    <div class="layui-col-md6 fly-home-jie">
      <div class="fly-panel">
        <h3 class="fly-panel-title">{{ $user->u_name }} 最近的发帖</h3>
        <ul class="jie-row" style="padding-bottom:14px">
        @if($postlist->first())
          @foreach($postlist as $k => $v)
            <li>
              <!-- <span class="fly-jing">精</span> -->
              <span class="fly-jing">{{ $post_column->where('id',$v['column_id'])->first()['post_name'] }}</span>

              <a href="/postlist/detail/{{ $v['id'] }}" class="jie-title">{{ $v['post_title'] }}</a>
              <i>{{ $v['created_at'] }}</i>
              <em class="layui-hide-xs">{{ $v['visits'] }}阅/{{ $v['reply_num'] }}答</em>
            </li>
          @endforeach
        @else
            <div class="fly-none" style="min-height: 50px; padding:30px 0; height:auto;"><i style="font-size:14px;">没有发表任何帖子</i></div>
        @endif
        </ul>
      </div>
    </div>
    {{-- 右侧回复板块 --}}
    <div class="layui-col-md6 fly-home-da">
      <div class="fly-panel">
        <h3 class="fly-panel-title">{{ $user->u_name }} 最近的回答</h3>
        <ul class="home-jieda">
        @if($reply->first())
          @foreach($reply as $k=>$v)
            <li>
            <p>
            <span>{{$v['created_at']}}</span>
            在<a href="/postlist/detail/{{ $v['post_list_id'] }}" target="_blank">{{ $plist->where('id',$v['post_list_id'])->first()['post_title'] }}</a>中回答：

            </p>
            <div class="home-dacontent">
              {!! $v['reply_content'] !!}

            </div>
          </li>
          @endforeach
        @else
          <div class="fly-none" style="min-height: 50px; padding:30px 0; height:auto;"><span>没有回答任何问题</span></div>
        @endif
        </ul>
      </div>
    </div>
  </div>
</div>

<div class="fly-footer">
  <p><a href="http://fly.layui.com/" target="_blank">Fly社区</a> 2017 &copy; <a href="http://www.layui.com/" target="_blank">layui.com 出品</a></p>
  <p>
    <a href="http://fly.layui.com/jie/3147/" target="_blank">付费计划</a>
    <a href="http://www.layui.com/template/fly/" target="_blank">获取Fly社区模版</a>
    <a href="http://fly.layui.com/jie/2461/" target="_blank">微信公众号</a>
  </p>
</div>


</body>
</html>
