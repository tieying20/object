@include('Admin/layout/header')
 <meta name="csrf-token" content="{{ csrf_token() }}">
 <body>
    <div class="x-body">
        <form class="layui-form" onsubmit="return false">
        {{ csrf_field() }}
          <div class="layui-form-item">
              <div class="layui-input-inline">
                  <input type="text" id="name" name="name" required="" lay-verify="required"
                  autocomplete="off" class="layui-input" value="{{ $role['name'] }}">
              </div>
          </div>
          
      <div class="layui-form-item">
          <div class="layui-form-item">
              <label for="L_repass" class="layui-form-label">
              </label>
              <button  class="layui-btn" lay-submit="" lay-filter="edit" onclick="member_edit({{ $role['id'] }})">
                  修改
              </button>
          </div>
      </div>
      </form>
    </div>
    <script>
      $.ajaxSetup({
           headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        });

      function member_edit(id){

        //要传的值
        name = $('#name').val();

        //执行ajax添加
        $.ajax({
          type:"PUT",
          url : '/admin/role/'+id,
          data : {name:name} ,
          async : true,
          success : function(data){
          console.log(data);
            if(data ==  0){
                layer.alert("修改成功", {icon: 1},function () {
                    // 获得frame索引
                    var index = parent.layer.getFrameIndex(window.name);
                    //关闭当前frame
                    parent.layer.close(index);
                    window.parent.location.href='/admin/role';
                });
                
            }else{
                layer.alert("该角色已存在，请重新修改", {icon: 2},function () {
                      history.go(0);
                  });
            }
          }
        });
      };

    </script>

  </body>

</html>
