@include('Home/layout/header')
@include('/Home/user_nav')

  <div class="fly-panel fly-panel-user" pad20>
	  <div class="layui-tab layui-tab-brief" lay-filter="user" id="LAY_msg" style="margin-top: 15px;">
	    <button class="layui-btn layui-btn-danger" id="LAY_delallmsg">清空全部消息</button>
	    <div  id="LAY_minemsg" style="margin-top: 10px;">
        <!--<div class="fly-none">您暂时没有最新消息</div>-->
        <ul class="mine-msg">
        @foreach($notice as $k=>$v)
          <li data-id="123">
            <blockquote class="layui-elem-quote">
              <a href="/jump?username=Absolutely" target="_blank"><cite>{{ $v->user['u_name'] }}</cite></a>在贴子<a target="_blank" href="/postlist/detail/{{ $v->postlist['id'] }}"><cite>{{ $v->postlist['post_title'] }}</cite></a>{!! $v['notice_type'].$v['data'] !!}
            </blockquote>
            <p><span>{{ $v['created_at'] }}</span><a href="javascript:;" class="layui-btn layui-btn-small layui-btn-danger fly-delete">删除</a></p>
          </li>
        @endforeach
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
