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
          <li lay-id="pass" class="">重置密码</li>

        </ul>

        <div class="layui-tab-content" style="padding: 20px 0;">
            <!-- 我的资料开始 -->
            <div class="layui-form layui-form-pane layui-tab-item layui-show">
              @if (session('status'))
                <blockquote class="layui-elem-quote " style="margin-top: 10px;">
                  <div id="test2">{{ session('status') }}</div>
                </blockquote>
              @endif
              @if (session('yzm_no'))
                <blockquote class="layui-elem-quote " style="margin-top: 10px;">
                  <div id="test2">{{ session('yzm_no') }}</div>
                </blockquote>
              @endif
                <form method="post" action="/userinfo/myinfo">
                    {{ csrf_field() }}
                    <div class="layui-form-item">
                        <label for="L_email" class="layui-form-label">
                            邮箱
                        </label>
                        @if(empty($userinfo['email']))
                            <div class="layui-input-inline">
                                <input type="text" id="L_email" name="email" lay-verify="required" value="" class="layui-input">
                            </div>
                            <span class="layui-btn layui-btn-normal" onclick="send()" id="yzm">验证邮箱</span>
                        @else
                            <div class="layui-input-inline">
                                <input type="text" id="L_email" name="email" lay-verify="required" value="{{ $userinfo['email'] }}" class="layui-input" readonly="true">
                            </div>
                        @endif
                    </div>

                    <div class="layui-form-item" style="padding-left: 30px; display: none;" id="hint">
                        <span style="color:#D80000">您的邮箱格式不正确，请重新输入</span>
                    </div>

                    <div class="layui-form-item" id="show_yzm" @if(session('yzm_no')) style="display: ;" @else style="display: none;" @endif>
                        <label for="L_yzm" class="layui-form-label">
                            验证码
                        </label>
                        <div class="layui-input-inline">
                            <input type="text" id="L_yzm" name="yzm" lay-verify="" value="" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label for="L_username" class="layui-form-label">
                            昵称
                        </label>
                        <div class="layui-input-inline">
                            <input type="text" id="L_username" name="u_name" required="" lay-verify=""
                            autocomplete="off" value="{{ $user['u_name'] }}" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label for="L_sex" class="layui-form-label">
                            性别
                        </label>
                        <div class="layui-input-inline">
                            <select name="sex">
                                <option value="" selected="">请选择性别</option>
                                <option value="1"{{ $userinfo['sex'] == '1' ? 'selected' : '' }}>男</option>
                                <option value="0"{{ $userinfo['sex'] == '0' ? 'selected=""' : '' }}>女</option>
                                <option value="2"{{ $userinfo['sex'] == '2' ? 'selected=""' : '' }}>保密</option>
                            </select>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label for="L_city" class="layui-form-label">
                            城市
                        </label>
                        <div class="layui-input-inline">
                            <input type="text" id="L_city" name="city" autocomplete="off" value="{{ $userinfo['city'] }}"
                            class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item layui-form-text">
                        <label for="L_sign" class="layui-form-label">
                            签名
                        </label>
                        <div class="layui-input-block">
                            <textarea id="L_sign" name="describe" autocomplete="off" class="layui-textarea" style="height: 80px;">{{ $userinfo['describe'] }}</textarea>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <button class="layui-btn" key="set-mine" lay-submit="">
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
                    <form action="">
                        <p>建议尺寸168*168，支持jpg、png、gif，最大不能超过50KB</p>
                        <label for="profile">
                            <span class="layui-btn upload-img">
                              <i class="layui-icon"></i>上传头像
                            </span>
                        </label>
                        <input class="layui-upload-file" type="file" name="file" id="profile" onchange="upFile()">
                        <img src="{{ $userinfo['head_img'] }}" id="old_img">
                        <span class="loading"></span>
                    </form>
                  </div>
                </div>
              </div>
              <!-- 设置头像接受 -->

              <!-- 修改密码开始 -->
              <div class="layui-form layui-form-pane layui-tab-item ">
                  @if (session('status'))
                    <blockquote class="layui-elem-quote " style="margin-top: 10px;">
                      <div id="test2">{{ session('status') }}</div>
                    </blockquote>
                  @endif
                <form action="/userinfo/resetpwd" method="post">
                    {{ csrf_field() }}
                  <div class="layui-form-item">
                    <label for="L_nowpass" class="layui-form-label">当前密码</label>
                    <div class="layui-input-inline">
                      <input type="password" id="L_nowpass" name="nowpass" required="" lay-verify="required" autocomplete="off" class="layui-input" value="{{ old('nowpass') }}">
                    </div>
                  </div>
                  <div class="layui-form-item">
                    <label for="L_pass" class="layui-form-label">新密码</label>
                    <div class="layui-input-inline">
                      <input type="password" id="L_pass" name="pass" required="" lay-verify="required" autocomplete="off" class="layui-input"  value="{{ old('pass') }}">
                    </div>
                    <div class="layui-form-mid layui-word-aux">6到16个字符</div>
                  </div>
                  <div class="layui-form-item">
                    <label for="L_repass" class="layui-form-label">确认密码</label>
                    <div class="layui-input-inline">
                      <input type="password" id="L_repass" name="repass" required="" lay-verify="required" autocomplete="off" class="layui-input" value="{{ old('repass') }}">
                    </div>
                  </div>
                  <div class="layui-form-item">
                    <button class="layui-btn" key="set-mine" lay-submit="">确认修改</button>
                  </div>
                </form>
              </div>
              <!-- 修改密码结束 -->
        </div>
    </div>
<script>
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // 发送邮件开始
    function send(){
        // 保存当前对象
        email = $('#L_email').val();
        // 获取邮箱提示的对象
        hint = $('#hint');
        // 邮箱的格式
        preg = /^[A-Za-z\d]+([-_.][A-Za-z\d]+)*@([A-Za-z\d]+[-.])+[A-Za-z\d]{2,4}$/;
        if (email == '') {
            hint.css('display',''); // 显示错误提示信息的div
            hint.find('span').html('请您输入邮箱，邮箱不能为空哦！'); // 修改提示信息
            return ;
        }else if(!preg.test(email)){
            hint.css('display',''); // 显示错误提示信息的div
            hint.find('span').html('您的邮箱格式不正确，请重新输入');// 修改提示信息
            return ;
        }

        // 发送邮箱的操作
        $('#yzm').html('正在发送'); // 修改按钮文字
        $.get('/userinfo/email',{email:email},function(res){
            if(res == '1'){
                hint.css('display','none'); // 隐藏邮箱错误提示信息
                $('#yzm').attr('disabled','false'); // 设置发送按钮不可点击
                $('#yzm').css('cursor','not-allowed'); // 设置按钮的鼠标禁止点击样式
                $('#show_yzm').css('display',''); // 显示验证码输入框
                i = 60; // 倒计时
                timer = setInterval(function(){
                    i--;
                    $('#yzm').html('发送成功('+i+'秒后重新发送)');
                    if(i <= 0){
                        $('#yzm').attr('disabled','true'); // 设置按钮可点击
                        $('#yzm').css('cursor','pointer'); // 设置按钮的鼠标样式(小手)
                        $('#yzm').html('验证邮箱'); // 修改按钮文字
                        clearInterval(timer); // 清除定时器
                    }
                },1000);
            }
        });
        return false;
    }
    // 发送邮件结束

    // 头像上传开始
    function upFile(){
        // 获取图片的信息
        var head_img = $('#profile')[0].files[0];
        // 获取旧图片路径
        var old_img_path = $('#old_img').attr('src');
        // new一个表单对象
        var fd = new FormData();
        // 把图片的信息追加到表单对象里
        fd.append('file',head_img);
        fd.append('old_img',old_img_path);
        $.ajax({
            url : '/userinfo/upfile',
            type : 'POST',
            data: fd,
            processData: false, // 不限定数据类型，上传要加
            contentType: false, // 不转换数据类型，上传要加
            success : function(path){
                $('#old_img').attr('src',path);
            }
        });
    }
    // 头像上传结束
</script>
</body>
</html>
