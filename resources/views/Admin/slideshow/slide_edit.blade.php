@include('Admin/layout/header')
  <body>
    <div class="x-body layui-anim layui-anim-up">
        <form class="layui-form">
         {{ csrf_field() }}
         {{ method_field('PUT') }}
          <div class="layui-form-item">
                <label for="s_company" class="layui-form-label">
                    <span class="x-red">*</span>公司名称
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="s_company" name="s_company" required="" lay-verify="required" autocomplete="off" class="layui-input" value="{{ $data['s_company'] }}">
                </div>
            </div>
            <div class="layui-form-item">
               <!--  <form id="form_file" enctype="multipart/form-data">
                    {{ csrf_field() }} -->
                    <label class="layui-form-label">
                        <span class="x-red">*</span>轮播图片
                    </label>
                    <label for="file_img">
                        <a class="layui-btn layui-btn-normal">点击修改</a>
                    </label>
            <script>
                /* 修改图片的操作 */
                function fileChange(){
                        old_img = $('#show_img').attr('src');
                        console.log(old_img);
                        var pic = $('#file_img')[0].files[0];
                        var fd = new FormData();
                        fd.append('uploadFile', pic);
                        fd.append('oldfile', old_img);
                        $.ajaxSetup({
                            headers: {
                              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: '/admin/file_img',
                            type: 'post',
                            data: fd,
                            async:true,
                            processData: false, // 不限定数据类型，上传要加
                            contentType: false, // 不转换数据类型，上传要加
                            success: function(path){
                                // alert(path);
                                img_path = '/upload/' + path;
                                $('#show_img').attr('src',img_path);
                            }
                        });
                    }
            </script>
                    <input type="file" name="uploadFile" id="file_img" style="display: none" onchange="fileChange();">
                <!-- </form> -->
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">
                </label>
                <label for="file_img">
                    <img src="{{ $data['img_path'] }}" style="width:100px; border: 2px solid #ccc" id="show_img">
                </label>
            </div>
          <div class="layui-form-item">
              <label for="L_repass" class="layui-form-label">
                  <span class="x-red">*</span>跳转链接
              </label>
              <div class="layui-input-inline">
                  <input type="text" id="L_repass" name="img_url" required="" lay-verify="url"
                  autocomplete="off" class="layui-input" placeholder="跳转链接" value="{{ $data['img_url'] }}">
              </div>
          </div>
          <div class="layui-form-item">
              <label for="start" class="layui-form-label">
                  <span class="x-red">*</span>开始时间
              </label>
              <div class="layui-input-inline">
                    <input type="text" class="layui-input" name="start_at" id="start" value="" autocomplete="off" lay-verify="required">
                </div>
          </div>
          <div class="layui-form-item">
              <label for="stop" class="layui-form-label">
                  <span class="x-red">*</span>结束时间
              </label>
              <div class="layui-input-inline">
                    <input type="text" class="layui-input" name="stop_at" id="stop" value="" autocomplete="off" lay-verify="required">
                </div>
          </div>
          <div class="layui-form-item">
              <label for="" class="layui-form-label">
              </label>
              <button  class="layui-btn" lay-filter="add" lay-submit="">
                  提交
              </button>
          </div>
      </form>
    </div>
<script>

    // 表单验证，要用js，因为下面是ajax传值的
    layui.use(['form','laydate'], function(){
        var form = layui.form;

        //日期
        var laydate = layui.laydate;
        laydate.render({
            elem: '#start',
            type: 'datetime',
            value: '{{ date('Y-m-d H:i:s',$data['start_at']) }}', //必须遵循format参数设定的格式
            done: function(date){
                // console.log(date); //得到初始的日期时间对象：{year: 2017, month: 8, date: 18, hours: 0, minutes: 0, seconds: 0}
                $('#start').val(date);
              }
        });
        laydate.render({
            elem: '#stop',
            type: 'datetime',
            value: '{{ date('Y-m-d H:i:s',$data['stop_at']) }}', //必须遵循format参数设定的格式
            done: function(date){
                // console.log(date); //得到初始的日期时间对象：{year: 2017, month: 8, date: 18, hours: 0, minutes: 0, seconds: 0}
                $('#stop').val(date);
              }
        });

        //监听提交  修改
        form.on('submit(add)', function(res){
            //发异步，把数据提交给php
            $.ajaxSetup({
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // 获取表单信息
            res.field.img_path = $('#show_img').attr('src');
            console.log(res.field);
            // 修改
            // ajax传值
            $.ajax({
                url:'/admin/slideshow/{{ $data['id'] }}',
                data:res.field,
                type:'PUT',
                async:true,
                success:function(result){
                    console.log(result);
                    // 1 成功
                    // 2 失败
                    if(result ==  1){
                        layer.alert("编辑成功", {icon: 4},function () {
                            // 获得frame索引
                            var index = parent.layer.getFrameIndex(window.name);
                            // 关闭当前frame
                            parent.layer.close(index);
                            window.parent.location.href='/admin/slideshow';
                        });
                    }else{
                        layer.alert("编辑失败", {icon: 4},function () {
                            history.go(0);
                        });
                    }
                }
            });
            return false;
        });
    });



</script>

  </body>

</html>
