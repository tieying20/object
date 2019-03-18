@include('Admin/layout/header')
<meta name="csrf-token" content="{{ csrf_token() }}">
  <body>
    <div class="x-body layui-anim layui-anim-up">
        <form class="layui-form">
         {{ csrf_field() }}
            <div class="layui-form-item">
                <label for="s_company" class="layui-form-label">
                    <span class="x-red">*</span>公司名称
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="s_company" name="s_company" required="" lay-verify="required"
                  autocomplete="off" class="layui-input" placeholder="">
                </div>
            </div>
            <div class="layui-form-item">
               <!--  <form id="form_file" enctype="multipart/form-data">
                    {{ csrf_field() }} -->
                    <label class="layui-form-label">
                        <span class="x-red">*</span>轮播图片
                    </label>
                    <label for="file_img">
                        <a class="layui-btn layui-btn-normal">点击上传</a>
                    </label>
                    <input type="file" name="uploadFile" id="file_img" style="display: none" onchange="fileChange()">
                <!-- </form> -->
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">
                </label>
                <label for="file_img">
                    <img src="" style="width:100px; border: 2px solid #ccc" id="show_img">
                </label>
            </div>
          <div class="layui-form-item">
              <label for="L_repass" class="layui-form-label">
                  <span class="x-red">*</span>跳转链接
              </label>
              <div class="layui-input-inline">
                  <input type="text" id="L_repass" name="img_url" required="" lay-verify="url"
                  autocomplete="off" class="layui-input" placeholder="跳转链接">
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
                  增加
              </button>
          </div>
      </form>
    </div>
<script>
    // 图片ajax无刷新上传
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    function fileChange(){
        var pic = $('#file_img')[0].files[0];
        var fd = new FormData();
        fd.append('uploadFile', pic);
        $.ajax({
            url: '/admin/file_img',
            type: 'post',
            data: fd,
            async:true,
            processData: false, // 不限定数据类型，上传要加
            contentType: false, // 不转换数据类型，上传要加
            success: function(path){
                img_path = '/upload/' + path;
                $('#show_img').attr('src',img_path);
            }
        });
    };

    layui.use(['form','laydate'], function(){
        var form = layui.form;
        var laydate = layui.laydate;
         //日期
        laydate.render({
            elem: '#start',
            type: 'datetime',
            done: function(date){
                // console.log(date); //得到初始的日期时间对象：{year: 2017, month: 8, date: 18, hours: 0, minutes: 0, seconds: 0}
                $('#start').val(date);
              }
        });
        laydate.render({
            elem: '#stop',
            type: 'datetime',
            done: function(date){
                // console.log(date); //得到初始的日期时间对象：{year: 2017, month: 8, date: 18, hours: 0, minutes: 0, seconds: 0}
                $('#stop').val(date);
              }
        });


        //监听提交
        form.on('submit(add)', function(data){
            // console.log(data.field);
            var data = data.field;
            data['img_path'] = $('#show_img').attr('src');
            $.ajax({
                url: '/admin/slideshow',
                type: 'post',
                data: data,
                async:true,
                success: function(res){
                    // 1 成功
                    // 2 失败
                    if(res ==  1){
                        layer.alert("添加成功", {icon: 4},function () {
                            // 获得frame索引
                            var index = parent.layer.getFrameIndex(window.name);
                            // 关闭当前frame
                            parent.layer.close(index);
                            window.parent.location.href='/admin/slideshow';
                        });
                    }else{
                        layer.alert("添加失败", {icon: 4},function () {
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
