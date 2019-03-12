@include('Admin/layout/header')
<meta name="csrf-token" content="{{ csrf_token() }}">
  <body>
    <div class="x-body layui-anim layui-anim-up">
        <form class="layui-form" onsubmit="return false">
         {{ csrf_field() }}
          <div class="layui-form-item">
              <label for="L_username" class="layui-form-label">
                  <span class="x-red">*</span>昵称
              </label>
              <div class="layui-input-inline">
                  <input type="text" id="L_username" name="username" required="" lay-verify="nikename"
                  autocomplete="off" class="layui-input">
              </div>
          </div>
          <div class="layui-form-item">
              <label for="L_pass" class="layui-form-label">
                  <span class="x-red">*</span>密码
              </label>
              <div class="layui-input-inline">
                  <input type="password" id="L_pass" name="pass" required="" lay-verify="pass"
                  autocomplete="off" class="layui-input">
              </div>
              <div class="layui-form-mid layui-word-aux">
                  6到16个字符
              </div>
          </div>
          <div class="layui-form-item">
              <label for="L_repass" class="layui-form-label">
                  <span class="x-red">*</span>确认密码
              </label>
              <div class="layui-input-inline">
                  <input type="password" id="L_repass" name="repass" required="" lay-verify="repass"
                  autocomplete="off" class="layui-input">
              </div>
          </div>
          <div class="layui-form-item">
              <label for="role" class="layui-form-label">
                  <span class="x-red">*</span>管理员角色
              </label>
              <div class="layui-input-inline">
                  <select name="role" id="role">
                    <option value="0">普通管理员</option>
                    <option value="1">超级管理员</option>
                  </select>
              </div>
          </div>
          <div class="layui-form-item">
              <label for="" class="layui-form-label">
              </label>
              <button  class="layui-btn" lay-filter="add" lay-submit="">
                  增加
              </button>
          </div>
      </form>
      <!-- <form action="" class="admin_add">
          <div class="layui-form-item">
              <label for="L_username" class="layui-form-label">
                  <span class="x-red">*</span>昵称
              </label>
              <div class="layui-input-inline">
                  <input type="text" id="uname" name="username" required="" lay-verify="nikename"
                  autocomplete="off" class="layui-input">
              </div>
          </div>

          <input type="submit" value="提交">
      </form> -->
    </div>
<script>


    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.layui-btn').click(function(){
      admin_name = $('#L_username').val();
      admin_pwd = $('#L_repass').val();
      a_repwd = $('#L_pass').val();
      role = $('#role').val();
      // 表单验证，要用js，因为下面是ajax传值的
    

      
      // 表单验证，要用js，因为下面是ajax传值的
      
      $.post('/admin/user',{'admin_name':admin_name,'admin_pwd':admin_pwd,'a_repwd':a_repwd,'role':role},function(data){
        // console.log(data);
          if(data ==  1){
            layer.alert("添加失败", {icon: 4},function () {
              history.go(0);
            });
          }else{
            layer.alert("添加成功", {icon: 4},function () {
                // 获得frame索引
                var index = parent.layer.getFrameIndex(window.name);
                //关闭当前frame
                parent.layer.close(index);
                window.parent.location.href='/admin/user';
            });
          }
      });

    });
        
</script>

  </body>

</html>