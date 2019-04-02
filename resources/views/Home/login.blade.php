@include('Home/layout/header')

<!-- 显示错误 信息 开始 -->
<link rel="stylesheet" type="text/css" href="/bootstrap-3.3.7-dist/css/bootstrap.min.css">
<script type="text/javascript" src="/bootstrap-3.3.7-dist/js/jquery-3.3.1.min.js"></script>
  <script type="text/javascript" src="/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<!-- 显示错误 信息 结束 -->

<div class="layui-container fly-marginTop">
  <div class="fly-panel fly-panel-user" pad20>
    <div class="layui-tab layui-tab-brief" lay-filter="user">
      <ul class="layui-tab-title">
        <li class="layui-this">登入</li>
        <li><a href="/user/create">注册</a></li>
      </ul>
      <div class="layui-form layui-tab-content" id="LAY_ucm" style="padding: 20px 0;">
        <div class="layui-tab-item layui-show">
          <div class="layui-form layui-form-pane">
            <form method="post" action="/home/dologin">
            {{ csrf_field() }}

              <div class="layui-form-item">
              <span></span>
              </div>
              <div class="layui-form-item">
                <label for="L_email" class="layui-form-label">手机号</label>
                <div class="layui-input-inline">
                  <input type="text" id="L_phone" name="phone" required lay-verify="required"  class="layui-input" value="{{ old('phone') }}">
                </div>
              </div>

              <div class="layui-form-item">
                <label for="L_vercode" class="layui-form-label">图形验证</label>
                <div class="layui-input-inline">
                  <input type="text" id="L_vercode" name="vercode" required lay-verify="required" placeholder="" autocomplete="off" class="layui-input" value="{{ old('vercode') }}">
                </div>
                <div >
                  <img class="thumbnail captcha" src="{{ url('home/imgcode' )}}" onclick="this.src='/home/imgcode?'+Math.random()" title="点击图片重新获取验证码">
                </div>
              </div>
              
              <div class="layui-form-item">
                <label for="L_pass" class="layui-form-label">密码</label>
                <div class="layui-input-inline">
                  <input type="password" id="L_pass" name="pwd" required lay-verify="required" autocomplete="off" class="layui-input">
                </div>
              </div>
              <!-- <div class="layui-form-item">
                <label for="L_vercode" class="layui-form-label">验证</label>
                <div class="layui-input-inline">
                  <input type="text" id="L_vercode" name="vercode" required lay-verify="required" placeholder="请回答后面的问题" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid">
                  <!-- <span style="color: #c00;">{{-- d.vercode --}}</span> -->
                <!-- </div> -->
              <!-- </div> -->
              <div class="layui-form-item">
                <button class="layui-btn" lay-submit>立即登录</button>
                <span style="padding-left:20px;">
                  <a href="forget.html">忘记密码？</a>
                </span>
              </div>
              <!-- <div class="layui-form-item fly-form-app">
                <span>或者使用社交账号登入</span>
                <a href="" onclick="layer.msg('正在通过QQ登入', {icon:16, shade: 0.1, time:0})" class="iconfont icon-qq" title="QQ登入"></a>
                <a href="" onclick="layer.msg('正在通过微博登入', {icon:16, shade: 0.1, time:0})" class="iconfont icon-weibo" title="微博登入"></a>
              </div> -->
            </form>
          </div>
        </div>
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
