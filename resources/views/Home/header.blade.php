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

    <ul class="layui-nav fly-nav-user">

      <!-- 未登入的状态 -->
      <li class="layui-nav-item">
        <a class="iconfont icon-touxiang layui-hide-xs" href="/userinfo/show"></a>
      </li>
      <li class="layui-nav-item">
        <a href="/home/login/">登录</a>
      </li>
      <li class="layui-nav-item">
        <a href="/user/create">注册</a>
      </li>

      <!-- <li class="layui-nav-item layui-hide-xs">
        <a href="/app/qq/" onclick="layer.msg('正在通过QQ登入', {icon:16, shade: 0.1, time:0})" title="QQ登入" class="iconfont icon-qq"></a>
      </li>
      <li class="layui-nav-item layui-hide-xs">
        <a href="/app/weibo/" onclick="layer.msg('正在通过微博登入', {icon:16, shade: 0.1, time:0})" title="微博登入" class="iconfont icon-weibo"></a>
      </li>
       -->
      <!-- 登入后的状态 -->
      <!--
      <li class="layui-nav-item">
        <a class="fly-nav-avatar" href="javascript:;">
          <cite class="layui-hide-xs">贤心</cite>
          <i class="iconfont icon-renzheng layui-hide-xs" title="认证信息：layui 作者"></i>
          <i class="layui-badge fly-badge-vip layui-hide-xs">VIP3</i>
          <img src="https://tva1.sinaimg.cn/crop.0.0.118.118.180/5db11ff4gw1e77d3nqrv8j203b03cweg.jpg">
        </a>
        <dl class="layui-nav-child">
          <dd><a href="user/set.html"><i class="layui-icon">&#xe620;</i>基本设置</a></dd>
          <dd><a href="user/message.html"><i class="iconfont icon-tongzhi" style="top: 4px;"></i>我的消息</a></dd>
          <dd><a href="user/home.html"><i class="layui-icon" style="margin-left: 2px; font-size: 22px;">&#xe68e;</i>我的主页</a></dd>
          <hr style="margin: 5px 0;">
          <dd><a href="/user/logout/" style="text-align: center;">退出</a></dd>
        </dl>
      </li>
      -->
    </ul>
  </div>
</div>
