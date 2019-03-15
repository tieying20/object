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
                  <input type="text" id="url" name="url" required="" lay-verify="url" autocomplete="off" class="layui-input">
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
					 	选择文件
					 </button>
              	</div>
          </div>
          <!-- 一同上传的的图片 -->
          <input type="hidden" id="upimg">

		  <div class="layui-form-item">
			    <label for="time" class="layui-form-label">
	                  浏览图
	            </label>
			    <img class="layui-upload" id="demo1" style="width:190px;height:150px; ">
			    <button type="button" class="layui-btn layui-btn-primary" id="commit">
					  	<i class="layui-icon">&#xe67c;</i>确认提交
					 </button>
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
    	// 创建日历组建
    	layui.use('laydate', function(){
	        var laydate = layui.laydate;
	        
	        //开始时间
	        laydate.render({
	          elem: '#start' //指定元素
	        });

	        //到期时间
	        laydate.render({
	          elem: '#stop' //指定元素
	        });
      	});


    	$.ajaxSetup({
           headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        });


    	//创建一个上传组件
    	layui.use('upload', function(){
	    	var upload = layui.upload;

			upload.render({
				elem: '#img'
				,url: '/admin/upimg'
				,accept: 'images' //允许上传的文件类型
				,size: 300 //最大允许上传的文件大小KB
				,field:'photo'//设定文件域的字段名
				,auto: false //选择文件后不自动上传
  				,bindAction: '#commit' //指向添加
  				,headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            	}
				,choose: function(obj)
				{//在文件被选择后触发,预览图片
					obj.preview(function(index, file, result){
					    $('#demo1').attr('src',result,'style','width:150px;height:150px;');
					    console.log(file);
					    // console.log(index);
					    // console.log(result);
				    });
				    	    			
    			}
				,done: function(res, index, upload)
				{ //上传后的回调
					// layer.closeAll('loading'); //关闭loading
					if(res.code == 0){ //上传成功
              			console.log(res.file);
              			$('#commit').attr('disabled',true);
              			$('#upimg').attr('value',res.file);
              			return layer.msg('上传成功');
					}
				}
				//,……
				,error: function(index, upload)
				{//请求异常回调
		      		return layer.msg('上传失败,请重新上传');
		      		
		      	}
			});
		});
    	

        
        $('#submit').click(function(){

        	//要传的值
        	s_company = $('#username').val();
        	start_at = $('#start').val();
        	stop_at = $('#stop').val();
        	img_url = $('#url').val();
        	img_path = $('#upimg').val();
        	// alert(img_path);

        	//执行ajax添加
        	$.post('/admin/sponsor',{'s_company':s_company,'start_at':start_at,'stop_at':stop_at,'img_url':img_url,'img_path':img_path},function(data){
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