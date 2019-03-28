@extends('Home/layout/model')
<!-- 左侧主体开始 -->
@section('left')

    <!-- 贴子部分 -->
    <div class="fly-panel" style="margin-bottom: 0;">
        <div class="fly-panel-title fly-filter">
          <a href="" class="layui-this">综合</a>
          <span class="fly-mid"></span>
          <!-- <a href="">未结</a>
          <span class="fly-mid"></span>
          <a href="">已结</a>
          <span class="fly-mid"></span> -->
          <a href="">精华</a>
          <span class="fly-filter-right layui-hide-xs">
            <a href="" class="layui-this">按最新</a>
            <span class="fly-mid"></span>
            <a href="">按热议</a>
          </span>
        </div>

        <ul class="fly-list">
        @foreach($postlist as $k=>$v)
            <li>
                <a href="/userinfo/index/{{ $v->user['id'] }}" class="fly-avatar"  target="_blank">
                    <img src="{{ $v->user->userinfo->head_img }}" alt="{{ $v->user->name }}">
                </a>
                <h2>
                    <a class="layui-badge">{{ $v->postColumn->post_name }}</a>
                    <a href="/postlist/detail/{{ $v['id'] }}">{{ $v->post_title }}</a>
                </h2>
                <div class="fly-list-info">
                    <a href="/userinfo/index/{{ $v->user['id'] }}" link target="_blank">
                        <cite>{{ $v->user->u_name }}</cite>
                        <!--<i class="iconfont icon-renzheng" title="认证信息：XXX"></i>-->
                        <!-- <i class="layui-badge fly-badge-vip">VIP3</i> -->
                    </a>
                    <span>{{ $v['created_at'] }}</span>
                    <span class="fly-list-kiss layui-hide-xs" title="悬赏飞吻">
                        <i class="iconfont icon-kiss"></i>{{ $v['integral'] }}</span>
                    <!-- <span class="layui-badge fly-badge-accept layui-hide-xs">已结</span> -->
                    <span class="fly-list-nums"><i class="iconfont icon-pinglun1" title="回复"></i>{{ $v['reply_num'] }}</span>
                </div>
                <div class="fly-list-badge">
                    @if($v['status'] == 1)
                    <span class="layui-badge layui-bg-red">精帖</span>
                    @endif
                </div>
            </li>
        @endforeach
        </ul>
        <div class="page">
            {{ $postlist->links() }}
        </div>
        <div style="text-align: center">

            <div class="laypage-main">
            </div>
        </div>
    </div>
<script>
    // 给目前所在栏目加样式
    cid = {{ $cid }} || false;
    // alert(cid);
    if(cid){
        // 清除所有栏目的样式
        $('.layui-hide-xs').removeClass('layui-this');
        cid += 1;
        // 给所在栏目添加样式
        $('.layui-hide-xs:nth-child('+cid+')').addClass('layui-this');
    }
</script>
@endsection
<!-- 左侧主体结束 -->
