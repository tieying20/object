@include('Admin/layout/header')
 <meta name="csrf-token" content="{{ csrf_token() }}">
 <body>
    <div class="x-body">
        <form class="layui-form" onsubmit="return false">
        {{ csrf_field() }}
          <div class="layui-form-item">
              <label for="username" class="layui-form-label">
                  <span class="x-red">*</span>赞助商
              </label>
              <div class="layui-input-inline">
                  <input type="text" id="username" name="username" required="" lay-verify="required"
                  autocomplete="off" class="layui-input">
              </div>
              <div class="layui-form-mid layui-word-aux">
                  <span class="x-red">*</span>填写赞助商名字
              </div>
          </div>
          <div class="layui-form-item">
              <label for="url" class="layui-form-label">
                  <span class="x-red">*</span>广告链接
              </label>
              <div class="layui-input-inline">
                  <input type="text" id="url" name="url" required="" lay-verify="url" autocomplete="off" class="layui-input" id="url">
              </div>
               <div class="layui-form-mid layui-word-aux">
                  <span class="x-red">*</span>格式例如:http://www.laravel.com
              </div>
          </div>
		  <div class="layui-form-item">
			  	<label for="time" class="layui-form-label">
	                  <span class="x-red">*</span>开始时间
	            </label>
	          	<div class="layui-input-inline">
	                  <input class="layui-input" type="text" name="start" id="start" required="">
	            </div>
      	  </div>
      	  <div class="layui-form-item">
			  	<label for="time" class="layui-form-label">
	                  <span class="x-red">*</span>到期时间
	            </label>
	          	<div class="layui-input-inline">
	                  <input class="layui-input" type="text" name="stop" id="stop" required="">
	            </div>
      	  </div>
      	  <div class="layui-form-item">
              <label for="url" class="layui-form-label">
                  <span class="x-red">*</span>广告展示
              </label>
              <div class="layui-input-inline">
                 <button type="button" class="layui-btn layui-btn-primary" id="img">
				  <i class="layui-icon">&#xe67c;</i>上传图片
				</button>
              </div>
          </div>
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
    	// 开始时间和结束时间
    	layui.use('laydate', function(){
	        var laydate = layui.laydate;
	        
	        //执行一个laydate实例
	        laydate.render({
	          elem: '#start' //指定元素
	        });

	        //执行一个laydate实例
	        laydate.render({
	          elem: '#stop' //指定元素
	        });
      	});

    	//
    	$.ajaxSetup({
           headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        });
        
        $('#submit').click(function(){

        	//要传的值
        	s_company = $('#username').val();
        	// img_path = $('#img').val();
        	start_at = $('#start').val();
        	stop_at = $('#stop').val();
        	img_url = $('#url').val();

        	//执行ajax添加
        	$.post('/admin/sponsor',{'s_company':s_company,'start_at':start_at,'stop_at':stop_at,'img_url':img_url},function(data){
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
	                window.parent.location.href='/admin/sponsor';
        			});
        		}
        	});
        	
        });
          

    </script>

  </body>

</html>