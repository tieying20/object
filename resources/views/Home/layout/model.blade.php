@include('Home/layout/header')
    <div class="fly-panel fly-column">
      <div class="layui-container">
        <ul class="layui-clear">
        <!-- 栏目部分 -->
          <li class="layui-hide-xs layui-this"><a href="/">首页</a></li>
          @foreach($post_column as $key => $val)
          <li class="layui-hide-xs"><a href="/home/columnpost/{{ $val['id'] }}">{{ $val->post_name }}</a></li>
          <!-- <li><a href="jie/index.html">分享<span class="layui-badge-dot"></span></a></li> -->
          @endforeach
          <li class="layui-hide-xs layui-hide-sm layui-show-md-inline-block"><span class="fly-mid"></span></li>

          <!-- 用户登入后显示 -->
          <li class="layui-hide-xs layui-hide-sm layui-show-md-inline-block"><a href="user/index.html">我发表的贴</a></li>
          <li class="layui-hide-xs layui-hide-sm layui-show-md-inline-block"><a href="user/index.html#collection">我收藏的贴</a></li>
        </ul>

        <div class="fly-column-right layui-hide-xs">
          <span class="fly-search"><i class="layui-icon"></i></span>
          <a href="/postlist/add" class="layui-btn">发表新帖</a>
        </div>
        <div class="layui-hide-sm layui-show-xs-block" style="margin-top: -10px; padding-bottom: 10px; text-align: center;">
          <a href="jie/add.html" class="layui-btn">发表新帖</a>
        </div>
      </div>
    </div>
  <!-- 右下角发帖按钮开始 -->{{--
    <ul class="layui-fixbar">
        <!-- 发表贴子按钮 -->
        <a href="/postlist/add">
            <li class="layui-icon" lay-type="bar1" style="background-color:#009688"></li>
        </a>
        <!-- 回到顶部按钮 -->
        <li class="layui-icon layui-fixbar-top" lay-type="top" style="background-color:#009688"></li>
    </ul>--}}
  <!-- 右下角发帖按钮结束 -->

<!-- 主页主体部分 -->
    <div class="layui-container">
      <div class="layui-row layui-col-space15">
        <!-- 左侧部分 -->
        <div class="layui-col-md8" style="overflow: hidden;">
            <!-- 左侧主体 -->
            @section('left')
            @show

        </div>
        <!-- 这里是右侧的代码 -->
        <div class="layui-col-md4">
          <!-- 签到模块 -->
          @section('signin')
          @show
          <div class="fly-panel">
            <div class="fly-panel-title">
              赞助商广告
              <span class="fly-mid"></span>
              <a href="#" class="fly-link fly-joinad">我要加入</a>
            </div>
            <div class="fly-panel-main" style="padding: 5px 10px 5px 0px ;">
              @if(!empty($sponsor['0']))
                @foreach($sponsor as $k => $v)
                  @if($v['status'] == 0)
                    <a href="{{ $v['img_url'] }}" target="_blank" rel="nofollow" class="fly-zanzhu fly-zanzhu-img" time-limit="2019-04-15 0:0:0" style="background: none;"> <img src="/upload/{{ $v['img_path'] }}" alt="CODING" style="width:340px;height:60.33px;"> </a>
                  @endif
                @endforeach
              @else
                <a href="#" class="fly-zanzhu" time-limit="2017.09.25-2099.01.01" style="background-color: #5FB878;">欢迎赞助商加盟入驻</a>
              @endif
            </div>
          </div>
          <div class="fly-panel fly-rank fly-rank-reply" id="LAY_replyRank">
            <h3 class="fly-panel-title">回贴周榜</h3>
            <dl>
              <!-- <i class="layui-icon fly-loading">&#xe63d;</i> -->
              @foreach($r_user as $key=>$value)
              <dd>
                <a href="/userinfo/index/{{ $value['id'] }}">
                  <img src="{{ $value->userinfo->head_img }}"><cite>{{ $value['u_name'] }}</cite><i>{{ $r_count[$value['id']] }}次回答</i>
                </a>
              </dd>
              @endforeach
            </dl>
          </div>

          <dl class="fly-panel fly-list-one">
            <dt class="fly-panel-title">本周热议</dt>
            @foreach($reyi as $key=>$value)
            <dd>
              <a href="/postlist/detail/{{ $value['id'] }}">{{ $value['post_title'] }}</a>
              <span><i class="iconfont icon-pinglun1"></i> {{ $value['reply_num'] }}</span>
            </dd>
            @endforeach
            <!-- 无数据时 -->
            <!--
            <div class="fly-none">没有相关数据</div>
            -->
          </dl>

          <div class="fly-panel fly-link">
            <h3 class="fly-panel-title">友情链接</h3>
            <dl class="fly-panel-main">
              @foreach($link as $k => $v)
                @if($v['status'] == 0)
                  <dd><a href="{{ $v['b_url'] }}" target="_blank">{{ $v['b_company'] }}</a><dd>
                @endif
              @endforeach
              <dd><a href="javascript:;" onclick="layer.alert('发送邮件至：zuozhan@163.com<br> 邮件标题为：申请有个社区友链', {title:'申请友链'});" class="fly-link">申请友链</a></dd>
                  </dl>
          </div>
        </div>
      </div>
    </div>

<div class="fly-footer">
  <p><a>有个社区</a> 2019 &copy; <a>作战小组 出品</a></p>
  <p>
    <a href="http://fly.layui.com/jie/3147/" target="_blank">付费计划</a>
    <a href="http://www.layui.com/template/fly/" target="_blank">获取有个社区模版</a>
    <a href="http://fly.layui.com/jie/2461/" target="_blank">微信公众号</a>
  </p>
  <p>感谢laravel、layui的支持</p>
</div>




<script>
$.ajaxSetup({
         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
      });
//签到模式
@section('signin_script')
@show

</script>

</body>
</html>
