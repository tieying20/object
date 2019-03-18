@include('Admin/layout/header')
 <meta name="csrf-token" content="{{ csrf_token() }}">
 <body>
    <div class="x-body">
        <form class="layui-form" onsubmit="return false">
        {{ csrf_field() }}
          <div class="layui-form-item">
              <label for="username" class="layui-form-label">
                  <span class="x-red">*</span>标题
              </label>
              <div class="layui-input-inline">
                  <input type="text" id="username" name="username" required="" lay-verify="required"
                  autocomplete="off" class="layui-input">
              </div>
              <div class="layui-form-mid layui-word-aux">
                  <span class="x-red">*</span>填写标题名字
              </div>
          </div>
          <div class="layui-form-item">
              <label for="url" class="layui-form-label">
                  <span class="x-red">*</span>链接
              </label>
              <div class="layui-input-inline">
                  <input type="text" id="url" name="url" required="" lay-verify="url" autocomplete="off" class="layui-input">
              </div>
               <div class="layui-form-mid layui-word-aux">
                  <span class="x-red">*</span>格式例如:http://www.123.com
              </div>
          </div>
		  <div class="layui-form-item">
          <div class="layui-form-item">
              <label for="L_repass" class="layui-form-label">
              </label>
              <button  class="layui-btn" lay-submit="" lay-filter="add" id="submit">
                  添加
              </button>
          </div>
      </form>
    </div>
    <script>
    	$.ajaxSetup({
           headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        });

      $('#submit').click(function(){

      	//要传的值
      	b_company = $('#username').val();
      	b_url = $('#url').val();

        var data = {
          'b_company' : b_company,
          'b_url' : b_url
        }
      	//执行ajax添加
      	$.post({
          url : '/admin/link',
          data : data ,
          async : true,
          success : function(data){
      		// console.log(data);
        		if(data ==  1){
		            layer.alert("添加失败", {icon: 2},function () {
              			history.go(0);
		            });
        		}else{
        			layer.alert("添加成功", {icon: 1},function () {
	                // 获得frame索引
	                var index = parent.layer.getFrameIndex(window.name);
	                //关闭当前frame
	                parent.layer.close(index);
	                window.parent.location.href='/admin/link';
      			  });
            }
      		}
      	});
      });

    </script>

  </body>

</html>
