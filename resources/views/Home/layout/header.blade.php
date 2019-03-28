<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>有个社区</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta name="keywords" content="">
  <meta name="description" content="">
  <link rel="stylesheet" href="/home/res/layui/css/layui.css">
  <link rel="stylesheet" href="/home/res/css/global.css">
  <!-- <script src="/home/res/layui/layui.all.js"></script> -->
  <script src="/home/res/layui/layui.js"></script>
  <script type="text/javascript" src="/bootstrap-3.3.7-dist/js/jquery-3.3.1.min.js"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script>
layui.cache.page = '';
layui.cache.user = {
  username: '游客'
  ,uid: -1
  ,avatar: '../res/images/avatar/00.jpg'
  ,experience: 83
  ,sex: '男'
};
layui.config({
  version: "3.0.0"
  ,base: '/home/res/mods/' //这里实际使用时，建议改成绝对路径
}).extend({
  fly: 'index'
}).use('fly');
</script>
</head>
<body onload="getNotice()">

<div class="fly-header layui-bg-black">
  <div class="layui-container">
    <a class="fly-logo" href="/">
      <img src="/home/res/images/logo.png" alt="layui">
    </a>
    <ul class="layui-nav fly-nav layui-hide-xs">
      <li class="layui-nav-item layui-this">
        <a href="/"><i class="iconfont icon-jiaoliu"></i>交流</a>
      </li>
    </ul>

    <ul class="layui-nav fly-nav-user">
      <!-- 登入后的状态 -->
      @if(Session::get('user'))
        <li class="layui-nav-item" style="margin-right: 23px; margin-bottom: 4px">
            <a href="/postlist/setread/{{ Session::get('user')['id'] }}" class="fly-nav-avatar">
                <span id="show_notice" class="layui-badge layui-bg-gray" style="padding: 0 0px;width: 21px;    border-radius: 10px;">0</span>
            </a>
        </li>
        <li class="layui-nav-item">
            <a id="user_show" class="fly-nav-avatar" href="/userinfo/center">
                <cite class="layui-hide-xs">{{ Session::get('user')['u_name'] }}</cite>
                <img src="{{ Session::get('head_img') }}" id="head_head_img">
            </a>
            <dl id="list_show" class="layui-nav-child">
                <dd><a href="/userinfo/set"><i class="layui-icon">&#xe620;</i>基本设置</a></dd>
                <dd><a href="/postlist/setread/{{ Session::get('user')['id'] }}"><i class="iconfont icon-tongzhi" style="top: 4px;"></i>我的消息</a></dd>
                <dd><a href="/userinfo/index/{{ Session::get('user')['id'] }}"><i class="layui-icon" style="margin-left: 2px; font-size: 22px;">&#xe68e;</i>我的主页</a></dd>
                <hr style="margin: 5px 0;">
                <dd><a href="/home/loginout/" style="text-align: center;">退出</a></dd>
            </dl>
        </li>
      @else
      <!-- 未登入的状态 -->
      <li class="layui-nav-item">
        <a class="iconfont icon-touxiang layui-hide-xs" href="/home/login/"></a>
      </li>
      <li class="layui-nav-item">
        <a href="/home/login/">登录</a>
      </li>
      <li class="layui-nav-item">
        <a href="/user/create">注册</a>
      </li>
      @endif
    </ul>
  </div>
</div>
<script>
    // 获取用户id
    var id = "{{ Session::get('user')['id'] }}" || false;
    // 每5秒请求获取一次消息
    function getNotice(){
        // 判断用户是否登录
        if(id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('/postlist/getnotice',{id:id},function(data){
                if(data == 0){
                    // 修改通知数
                    $('#show_notice').html(data);
                    // 移出变量
                    $('#show_notice').addClass('layui-bg-gray');
                }else{
                    // 修改通知数量
                    $('#show_notice').html(data);
                    // 移出变量
                    $('#show_notice').removeClass('layui-bg-gray');
                }
            });
            // 递归调用
            setTimeout(function(){
                getNotice();
            },5000);
        }
    }

</script>
