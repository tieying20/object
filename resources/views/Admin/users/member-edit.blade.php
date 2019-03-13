@include('Admin/layout/header')
<meta name="csrf-token" content="{{ csrf_token() }}">
  <body>
    <div class="x-body layui-anim layui-anim-up">
        <form class="layui-form">
         {{ csrf_field() }}
          <div class="layui-form-item">
              <label for="L_username" class="layui-form-label">
                  账号
              </label>
              <div class="layui-input-inline">
                  <input type="text" id="L_username" name="username" required="" lay-verify="nikename"
                  autocomplete="off" class="layui-input" placeholder="5-16位,不能含有非法字符" value="{{ $edit_data['admin_name'] }}" disabled="disabled">
              </div>
          </div>
          <div class="layui-form-item">
              <label for="L_pass" class="layui-form-label">
                  <span class="x-red">*</span>密码
              </label>
              <div class="layui-input-inline">
                  <input type="password" id="L_pass" name="pass" required="" lay-verify="pass"
                  autocomplete="off" class="layui-input" placeholder="5-16位,不能含有非法字符">
              </div>
          </div>
          <div class="layui-form-item">
              <label for="L_repass" class="layui-form-label">
                  <span class="x-red">*</span>确认密码
              </label>
              <div class="layui-input-inline">
                  <input type="password" id="L_repass" name="repass" required="" lay-verify="repass"
                  autocomplete="off" class="layui-input" placeholder="重复输入密码">
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
    </div>
<script>
    // 表单验证，要用js，因为下面是ajax传值的
    layui.use('form', function(){
        var form = layui.form;
        form.verify({
            nikename: [
                /\w{5,16}/
                ,'账号5-16位，由数字字母下划线组成'
            ]

            //我们既支持上述函数式的方式，也支持下述数组的形式
            //数组的两个值分别代表：[正则匹配、匹配不符时的提示文字]
            ,pass: [
                /\w{6,16}/
                ,'密码6-16位，由数字字母下划线组成'
            ]

            ,repass: function(value){
                if($('#L_pass').val() != $('#L_repass').val()){
                    return '两次密码不一致';
                }
            }
        });
        //监听提交
        form.on('submit(add)', function(data){
            console.log(data);
            //发异步，把数据提交给php
            $.ajaxSetup({
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // 获取表单信息
            admin_name = $('#L_username').val();
            admin_pwd = $('#L_repass').val();
            a_repwd = $('#L_pass').val();
            role = $('#role').val();
            // ajax传值
            $.post('/admin/admin',{'admin_name':admin_name,'admin_pwd':admin_pwd,'a_repwd':a_repwd,'role':role},function(data){
                // console.log(data);
                if(data ==  1){
                    layer.alert("添加失败", {icon: 4},function () {
                      history.go(0);
                    });
                }else{
                    layer.alert("添加成功", {icon: 4},function () {
                        // 获得frame索引
                        var index = parent.layer.getFrameIndex(window.name);
                        // 关闭当前frame
                        parent.layer.close(index);
                        window.parent.location.href='/admin/admin';
                    });
                }
            });
            return false;
        });
    });

    
        
</script>

  </body>

</html>