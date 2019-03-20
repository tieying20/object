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
  <script src="/home/res/layui/layui.all.js"></script>
  <script src="/home/res/layui/layui.js"></script>
  <script type="text/javascript" src="/bootstrap-3.3.7-dist/js/jquery-3.3.1.min.js"></script>
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

<style>
  .middle_right{
    padding: 15px 15px;
  background-color: #fff;
  margin-bottom: 15px;
  }
  #lunbobox {
  width:745px;
  height:173;
  position:relative;
  }
  .lunbo {
    width:775px;
    height:172.5px;
  }
  .lunbo img {
    width:745px;
    height:172.5px;
    position:absolute;
    top:0px;
    left:0px;
  }
  #lunbobox ul {
    width: 108px;
    position: absolute;
    bottom: 10px;
    right: 262px;
    z-index: 5;
  }
  #lunbobox ul li {
    cursor:pointer;
    width:10px;
    height:4px;
    border:1px solid #cccccc;
    float:left;
    list-style:none;
    background:#cccccc;
    text-align:center;
    margin:0px 5px 0px 0px;
  }
  #toleft {
    display:none;
    width:30px;
    height:100px;
    font-size:40px;
    line-height:100px;
    text-align:center;
    color:#f4f4f4;
    /*background:#cccccc;
    */
      /*background:url("../images/toleft.jpg")no-repeat center;
    */
      position:absolute;
    top:40px;
    left:12px;
    cursor:pointer;
    z-index:99;
    opacity:0.4;
  }
  #toright {
    display:none;
    width:30px;
    height:100px;
    font-size:40px;
    line-height:100px;
    text-align:center;
    color:#f4f4f4;
    /*background:#cccccc;
    */
      position:absolute;
    top:40px;
    right:0px;
    cursor:pointer;
    z-index:99;
    opacity:0.4;
  }
</style>
</head>
<body>

<div class="fly-header layui-bg-black">
  <div class="layui-container">
    <a class="fly-logo" href="/home/index/">
      <img src="/home/res/images/logo.png" alt="layui">
    </a>
    <ul class="layui-nav fly-nav layui-hide-xs">
      <li class="layui-nav-item layui-this">
        <a href="/"><i class="iconfont icon-jiaoliu"></i>交流</a>
      </li>
      <!-- <li class="layui-nav-item">
        <a href="case/case.html"><i class="iconfont icon-iconmingxinganli"></i>案例</a>
      </li>
      <li class="layui-nav-item">
        <a href="http://www.layui.com/" target="_blank"><i class="iconfont icon-ui"></i>框架</a>
      </li> -->
    </ul>
<script>
    // var user_show = document.
</script>
    <ul class="layui-nav fly-nav-user">
      <!-- 登入后的状态 -->
      @if(Session::get('user'))
        <li class="layui-nav-item">
            <a id="user_show" class="fly-nav-avatar" href="/userinfo/center">
                <cite class="layui-hide-xs">{{ Session::get('user')['u_name'] }}</cite>
                <img src="{{ Session::get('user')['head_img'] }}">
            </a>
            <dl id="list_show" class="layui-nav-child">
                <dd><a href="/userinfo/set"><i class="layui-icon">&#xe620;</i>基本设置</a></dd>
                <dd><a href="/userinfo/message"><i class="iconfont icon-tongzhi" style="top: 4px;"></i>我的消息</a></dd>
                <dd><a href="/userinfo/index"><i class="layui-icon" style="margin-left: 2px; font-size: 22px;">&#xe68e;</i>我的主页</a></dd>
                <hr style="margin: 5px 0;">
                <dd><a href="/home/loginout/" style="text-align: center;">退出</a></dd>
            </dl>
        </li>
      @else
      <!-- 未登入的状态 -->
      <li class="layui-nav-item">
        <a class="iconfont icon-touxiang layui-hide-xs" href="/userinfo/1"></a>
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
