@include('Home/layout/header')
@include('/Home/user_nav')
    <span class="layui-nav-bar" style="top: 77.5px; height: 0px; opacity: 0;"></span></ul>

    <div class="site-tree-mobile layui-hide">
      <i class="layui-icon"></i>
    </div>
    <div class="site-mobile-shade"></div>

    <div class="site-tree-mobile layui-hide">
      <i class="layui-icon"></i>
    </div>
    <div class="site-mobile-shade"></div>


    <div class="fly-panel fly-panel-user" pad20="">
      <div class="layui-tab layui-tab-brief" lay-filter="user">
        <ul class="layui-tab-title" id="LAY_mine">
          <li class="layui-this" lay-id="info">我的资料</li>
          <li lay-id="avatar" class="">头像</li>
          <li lay-id="pass" class="">密码</li>
          <li lay-id="bind" class="">帐号绑定</li>
        </ul>
        <div class="layui-tab-content" style="padding: 20px 0;">
            <!-- 我的资料开始 -->
            <div class="layui-form layui-form-pane layui-tab-item layui-show">
                <form method="post">
                    <div class="layui-form-item">
                        <label for="L_email" class="layui-form-label">
                            邮箱
                        </label>
                        <div class="layui-input-inline">
                            <input type="text" id="L_email" name="email" required="" lay-verify="" value="{{ $user->userinfo->email }}" class="layui-input">
                        </div>
                        <button class="layui-btn layui-btn-normal" onclick="send()" id="yzm">
                            验证邮箱
                        </button>
                    </div>
                    <div class="layui-form-item">
                        <label for="L_username" class="layui-form-label">
                            昵称
                        </label>
                        <div class="layui-input-inline">
                            <input type="text" id="L_username" name="u_name" required="" lay-verify=""
                            autocomplete="off" value="{{ $user->u_name }}" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label for="L_sex" class="layui-form-label">
                            性别
                        </label>
                        <div class="layui-input-inline">
                            <select name="sex">
                                <option value="" selected="">请选择性别</option>
                                <option value="1">男</option>
                                <option value="0">女</option>
                                <option value="2">保密</option>
                            </select>

                        </div>

                    </div>
                    <div class="layui-form-item">
                        <label for="L_city" class="layui-form-label">
                            城市
                        </label>
                        <div class="layui-input-inline">
                            <input type="text" id="L_city" name="city" autocomplete="off" value="{{ $user->userinfo->city }}"
                            class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item layui-form-text">
                        <label for="L_sign" class="layui-form-label">
                            签名
                        </label>
                        <div class="layui-input-block">
                            <textarea id="L_sign" name="describe" autocomplete="off" class="layui-textarea" style="height: 80px;">{{ $user->userinfo->describe }}</textarea>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <button class="layui-btn" key="set-mine" lay-filter="*" lay-submit="">
                            确认修改
                        </button>
                    </div>
                </form>
            </div>
            <!-- 我的资料结束 -->

              <!-- 设置头像开始 -->
              <div class="layui-form layui-form-pane layui-tab-item">
                <div class="layui-form-item">
                  <div class="avatar-add">
                    <p>建议尺寸168*168，支持jpg、png、gif，最大不能超过50KB</p>
                    <button type="button" class="layui-btn upload-img">
                      <i class="layui-icon"></i>上传头像
                    </button><input class="layui-upload-file" type="file" name="file">
                    <img src="/uploads/new_img.jpg">
                    <span class="loading"></span>
                  </div>
                </div>
              </div>
              <!-- 设置头像接受 -->

              <!-- 修改密码开始 -->
              <div class="layui-form layui-form-pane layui-tab-item">

                  <div class="layui-form-item">
                    <label for="L_nowpass" class="layui-form-label">当前密码</label>
                    <div class="layui-input-inline">
                      <input type="password" id="L_nowpass" name="nowpass" required="" lay-verify="required" autocomplete="off" class="layui-input">
                    </div>
                  </div>
                  <div class="layui-form-item">
                    <label for="L_pass" class="layui-form-label">新密码</label>
                    <div class="layui-input-inline">
                      <input type="password" id="L_pass" name="pass" required="" lay-verify="required" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">6到16个字符</div>
                  </div>
                  <div class="layui-form-item">
                    <label for="L_repass" class="layui-form-label">确认密码</label>
                    <div class="layui-input-inline">
                      <input type="password" id="L_repass" name="repass" required="" lay-verify="required" autocomplete="off" class="layui-input">
                    </div>
                  </div>
                  <div class="layui-form-item">
                    <button class="layui-btn" key="set-mine" lay-filter="*" lay-submit="">确认修改</button>
                  </div>

              </div>
              <!-- 修改密码结束 -->

              <!-- 绑定账号开始 -->
              <div class="layui-form layui-form-pane layui-tab-item">
                    <ul class="app-bind">
                      <li class="fly-msg app-havebind">
                        <i class="iconfont icon-qq"></i>
                        <span>已成功绑定，您可以使用QQ帐号直接登录Fly社区，当然，您也可以</span>
                        <a href="javascript:;" class="acc-unbind" type="qq_id">解除绑定</a>

                        <!-- <a href="" onclick="layer.msg('正在绑定微博QQ', {icon:16, shade: 0.1, time:0})" class="acc-bind" type="qq_id">立即绑定</a>
                        <span>，即可使用QQ帐号登录Fly社区</span> -->
                      </li>
                      <li class="fly-msg">
                        <i class="iconfont icon-weibo"></i>
                        <!-- <span>已成功绑定，您可以使用微博直接登录Fly社区，当然，您也可以</span>
                        <a href="javascript:;" class="acc-unbind" type="weibo_id">解除绑定</a> -->

                        <a href="" class="acc-weibo" type="weibo_id" onclick="layer.msg('正在绑定微博', {icon:16, shade: 0.1, time:0})">立即绑定</a>
                        <span>，即可使用微博帐号登录Fly社区</span>
                      </li>
                    </ul>
              </div>
              <!-- 绑定账号结束 -->

        </div>

    </div>
<script>
    function send(){
        // 保存当前对象
        email = $('#L_email').val();
        $.get('/userinfo/email',{email:email},function(res){
            if(res == '1'){
                $('#yzm').attr('disabled','false');
                $('#yzm').css('cursor','not-allowed');
                i = 60;
                timer = setInterval(function(){
                    i--;
                    $('#yzm').html('发送成功('+i+'秒后重新发送)');
                    if(i <= 0){
                        $('#yzm').attr('disabled','true');
                        $('#yzm').css('cursor','pointer');
                        $('#yzm').html('验证邮箱');
                        clearInterval(timer);
                    }
                },1000);
            }
        });
        return false;
    }
</script>
</body>
</html>
