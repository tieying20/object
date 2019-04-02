@include('Admin/layout/header')
  <body>
    <div class="x-body layui-anim layui-anim-up">
        <form class="layui-form">
         {{ csrf_field() }}
         {{ method_field('PUT') }}
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
                  <!-- <span class="x-red">*</span> -->旧密码
              </label>
              <div class="layui-input-inline">
                  <input type="password" id="L_pass" name="pass" required="" lay-verify="pass"
                  autocomplete="off" class="layui-input" placeholder="旧密码">
              </div>
              <div class="layui-form-mid layui-word-aux">
                  <span class="x-red">*</span>需要更改密码时填写
              </div>
          </div>
          <div class="layui-form-item">
              <label for="L_repass" class="layui-form-label">
                  <!-- <span class="x-red">*</span> -->新密码
              </label>
              <div class="layui-input-inline">
                  <input type="password" id="L_repass" name="repass" required="" lay-verify="repass"
                  autocomplete="off" class="layui-input" placeholder="5-16位,不能含有非法字符">
              </div>
              <div class="layui-form-mid layui-word-aux">
                  <span class="x-red">*</span>需要更改密码时填写
              </div>
          </div>
          
          <div class="layui-form-item">
              <label for="role" class="layui-form-label">
                  <span class="x-red">*</span>管理员角色
              </label>
              <div class="layui-input-inline">
                  <select name="role" id="role">
                    <option value="0" {{ $edit_data['role'] == '0' ? 'selected' : '' }}>普通管理员</option>
                    <option value="1" {{ $edit_data['role'] == '1' ? 'selected' : '' }}>超级管理员</option>
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
        // form.verify({
        //     repass: [
        //         /\w{6,16}/
        //         ,'密码6-16位，由数字字母下划线组成'
        //     ]
        // });
        //监听提交
        form.on('submit(add)', function(res){
            // console.log(data);
            //发异步，把数据提交给php
            $.ajaxSetup({
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // 获取表单信息
            admin_name = $('#L_username').val();
            admin_pwd = $('#L_pass').val();
            a_repwd = $('#L_repass').val();
            role = $('#role').val();

            // ajax传值
            $.ajax({url:'/admin/admin/{{ $edit_data['id'] }}',data:{admin_pwd:admin_pwd,a_repwd:a_repwd,role:role},type:'PUT',async:true,success:function(result){
                console.log(result);
                // 0 旧密码不对
                // 1 修改成功
                // 2 修改失败
                if(result ==  0){
                    layer.alert("旧密码不对", {icon: 4});
                }else if(result == 1){
                    layer.alert("修改成功", {icon: 4},function () {
                        // 获得frame索引
                        var index = parent.layer.getFrameIndex(window.name);
                        // 关闭当前frame
                        parent.layer.close(index);
                        window.parent.location.href='/admin/admin';
                    });
                }else{
                    layer.alert("修改失败", {icon: 4});
                }
            }});
            return false;
        });
    });

    
        
</script>

  </body>

</html>