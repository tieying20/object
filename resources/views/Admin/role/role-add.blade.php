@include('Admin/layout/header')
<meta name="csrf-token" content="{{ csrf_token() }}">

  <body>
    <div class="x-body layui-anim layui-anim-up">
        <form class="layui-form">
         {{ csrf_field() }}
         @if (count($errors) > 0)
              <div class="alert alert-danger">
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
          @endif
            <div class="layui-form-item">
                <label for="s_company" class="layui-form-label">
                    <span class="x-red">*</span>角色名称
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="name" name="name" required="" lay-verify="required"
                  autocomplete="off" class="layui-input" placeholder="">
                </div>
            </div>

            <div class="layui-form-item">
                <label for="" class="layui-form-label">
                </label>
                <button  class="layui-btn" lay-filter="add" lay-submit="" id="submit">
                  增加
                </button>
            </div>
      </form>
    </div>
  </body>
  <script>
        $.ajaxSetup({
           headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        });

      $('#submit').click(function(){

        //要传的值
        name = $('#name').val();
        
        // console.log(p_name);
        //执行ajax添加
        // $.post('/admin/programa',{'p_name':p_name},function(res){
        //     console.log(res);
        // })
        $.ajax({
          url : '/admin/role',
          data : {name:name} ,
          async : true,
          type: 'post',
          success : function(data){
                console.log(data);
                    // 0 成功
                // 1 失败
                if(data ==  0){
                    layer.alert("添加成功", {icon: 4},function () {
                        // 获得frame索引
                        var index = parent.layer.getFrameIndex(window.name);
                        // 关闭当前frame
                        parent.layer.close(index);
                        window.parent.location.href='/admin/role';
                    });
                }else{
                    layer.alert("该角色已存在！！！", {icon: 4},function () {
                        history.go(0);
                    });
                }
            }
        });
        return false;
      });

    </script>
</html>
