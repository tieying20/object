@extends('Home/layout/model')

@section('left')
    <div class="fly-panel detail-box">
        <h1>{{ $postlist['post_title'] }}</h1>
        <div class="fly-detail-info">
            <!-- <span class="layui-badge">审核中</span> -->
            <span class="layui-badge layui-bg-green fly-detail-column">{{ $postlist->postColumn['post_name'] }}</span>
            <!-- <span class="layui-badge" style="background-color: #999;">未结</span> -->
            <!-- <span class="layui-badge" style="background-color: #5FB878;">已结</span> -->
            <span class="layui-badge layui-bg-black">置顶</span>
            <span class="layui-badge layui-bg-red">精帖</span>
            <div class="fly-admin-box" data-id="123">
                <!-- <span class="layui-btn layui-btn-xs jie-admin" type="del">删除</span> -->
                <!-- <span class="layui-btn layui-btn-xs jie-admin" type="set" field="stick" rank="1">置顶</span> -->
                <!-- <span class="layui-btn layui-btn-xs jie-admin" type="set" field="stick" rank="0" style="background-color:#ccc;">取消置顶</span> -->
                <!-- <span class="layui-btn layui-btn-xs jie-admin" type="set" field="status" rank="1">加精</span> -->
                <!-- <span class="layui-btn layui-btn-xs jie-admin" type="set" field="status" rank="0" style="background-color:#ccc;">取消加精</span> --></div>
            <span class="fly-list-nums">
                <a href="#comment">
                    <i class="iconfont" title="回答">&#xe60c;</i>{{ $postlist['reply_num'] }}</a>
                <i class="iconfont" title="人气">&#xe60b;</i>{{ $postlist['visits'] }}</span>
        </div>
        <div class="detail-about">
            <a class="fly-avatar" href="javascript:;"><!-- 后期可以做成跳到对方的主页 -->
                <img src="{{ $userinfo['head_img'] }}" alt="贤心"></a>
            <div class="fly-detail-user">
                <a href="javascript:;" class="fly-link">
                    <cite>{{ $user['u_name'] }}</cite>
                    <i class="iconfont icon-renzheng" title="认证信息：无"></i>
                    <i class="layui-badge fly-badge-vip">VIP3</i></a>
                <span>{{ $postlist['created_at'] }}</span>
            </div>
            <div class="detail-hits" id="LAY_jieAdmin" data-id="123">
                <span style="padding-right: 10px; color: #FF7200">悬赏：{{ $postlist['integral'] }}飞吻</span>
                <!-- <span class="layui-btn layui-btn-xs jie-admin" type="edit">
                    <a href="add.html">编辑此贴</a>
                </span> -->
            </div>
        </div>
        <div class="detail-body photos">
            <!-- 贴子的内容 -->
            {!! $postlist['post_content'] !!}
        </div>
    </div>
    <div class="fly-panel detail-box" id="flyReply">
        <fieldset class="layui-elem-field layui-field-title" style="text-align: center;">
            <legend>回帖</legend></fieldset>
        <ul class="jieda" id="jieda">
        @if(!empty($reply['0']))
            @foreach($reply as $k=>$v)
                <li data-id="111" class="jieda-daan">
                    <a name="item-1111111111"></a>
                    <div class="detail-about detail-about-reply">
                        <a class="fly-avatar" href="/userinfo/index/{{ $v->user['id'] }}" target="_blank">
                            <img src="{{ $v->user->userinfo['head_img'] }}" alt=" "></a>
                        <div class="fly-detail-user">
                            <a href="/userinfo/index/{{ $v->user['id'] }}" target="_blank" class="fly-link">
                                <cite>{{ $v->user->u_name }}</cite>
                                <i class="iconfont icon-renzheng" title="认证信息：XXX"></i>
                                <i class="layui-badge fly-badge-vip">VIP3</i></a>
                            <!-- <span>(楼主)</span> -->
                            <!-- <span style="color:#5FB878">(管理员)</span>
                            <span style="color:#FF9E3F">（社区之光）</span>
                            <span style="color:#999">（该号已被封）</span> -->

                        </div>
                        <div class="detail-hits"><span>{{ $v['created_at'] }}</span></div>
                        <!-- <i class="iconfont icon-caina" title="最佳答案"></i> -->
                    </div>
                    <div class="detail-body jieda-body photos">
                        <p>{!! $v['reply_content'] !!}</p>
                    </div>
                    <div class="jieda-reply">
                        <!--  已赞样式：zanok -->
                        <span class="jieda-zan {{ $v['zan'] == '1' ? 'zanok' : '' }}" type="zan" onclick="zan(this,{{ $v['id'] }},{{ $v->user['id'] }})">
                            <i class="iconfont icon-zan"></i>
                            <em>{{ $v['praise'] }}</em>
                        </span>

                        <span onclick="reply_user('{{ $v->user['u_name'] }}')">
                            <i class="iconfont icon-svgmoban53"></i>回复
                        </span>
                        <div class="jieda-admin">
                            <!-- <span type="edit">编辑</span> -->
                            <span type="del" onclick="">举报</span>
                            <!-- <span class="jieda-accept" type="accept">采纳</span> -->
                        </div>
                    </div>

                </li>
            @endforeach
        @else
            <!-- 无数据时 -->
            <li class="fly-none">消灭零回复</li>
        @endif
        </ul>
        <div class="layui-form layui-form-pane">
            <form>
                {{ csrf_field() }}
                <div class="layui-form-item layui-form-text">
                    <!-- 加载编辑器的容器 -->
                    <script id="container" name="reply_content" type="text/plain" style="height:210px"></script>
                    <!-- 配置文件 -->
                    <script type="text/javascript" src="/utf8-php/ueditor.config.js"></script>
                    <!-- 编辑器源码文件 -->
                    <script type="text/javascript" src="/utf8-php/ueditor.all.js"></script>
                    <!-- 实例化编辑器 -->
                    <script type="text/javascript">
                        var ue = UE.getEditor('container',{
                            toolbars: [
                            ['source', 'undo', 'redo' ,'emotion' ,'fontfamily']
                        ],
                        });
                    </script>
                </div>
                <div class="layui-form-item">
                    <input type="hidden" name="post_list_id" value="{{ $postlist['id'] }}">
                    <button class="layui-btn" lay-submit="" onclick="reply(event)">提交回复</button>
                </div>
            </form>
        </div>
    </div>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // 贴子回复ajax
    function reply(e){
        e.preventDefault();   //阻止默认提交
        // 判断用户是否登录
        if(id){
            var post_list_id = {{ $postlist['id'] }}; // 获取贴子id
            var reply_content = ue.getContent(); // 获取回复内容
            $.post('/postlsit/reply',{post_list_id:post_list_id,reply_content:reply_content},function(res){
                console.log(res);
                // 返回1成功
                if(res == '1'){
                    layer.alert("回复成功", {icon: 1},function () {
                        window.location.reload();
                    });
                }else{
                    layer.alert("添加失败", {icon: 5},function () {
                        history.go(0);
                    });
                }
            });
        }else{
            layer.alert("回复需要登录哦！", {icon: 5},function () {
                window.location.href = '/home/login';
            });
        }
    }

    // 回复用户
    function reply_user(uname){
        // window.location.hash = "#container";

        // 移动到输入框位置
        var goedit = $('#container').offset();
        document.documentElement.scrollTop = goedit.top - 100;
        // 让输入框做出回复用户的效果
        var content = ue.getContentTxt();
        console.log(content);
        ue.setContent(content+'@'+uname+'&nbsp;');
    }

    // 点赞
    function zan(obj,rid,notice_id){
        if(id){
            // 发送ajax点赞
            $.get('/postlist/zan/'+rid,{uid:id,notice_id:notice_id},function(res){
                if(res == 'a'){
                    // error1是已点赞
                    $(obj).addClass('zanok').find('em').html('已经点过赞了!');
                }else if(res){
                    // 变成已点赞样式并且修改点赞数量
                    $(obj).addClass('zanok').find('em').html(res);
                }
            });
        }else{
            layer.alert("点赞需要登录哦！", {icon: 5},function () {
                window.location.href = '/home/login';
            });
        }
    }
</script>
@endsection
