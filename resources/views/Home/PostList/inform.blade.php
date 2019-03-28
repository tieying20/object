@include('Admin/layout/header')
  <body>
    <div class="x-body layui-anim layui-anim-up">
        <form class="layui-form">
         {{ csrf_field() }}
            <div class="layui-input-inline">
                <span class="x-red">*</span>请选择投诉举报类型
            </div>
            <div class="layui-form-item">
                <input type="radio" name="type" value="低俗色情" title="低俗色情" checked="">
                <input type="radio" name="type" value="垃圾广告" title="垃圾广告" >
                <input type="radio" name="type" value="辱骂攻击" title="辱骂攻击" >
                <input type="radio" name="type" value="抄袭我的内容" title="抄袭我的内容" >
                <input type="radio" name="type" value="暴露我的隐私" title="暴露我的隐私" >
            </div>
            <div class="layui-form-item">
                <span class="x-red"></span>请填写举报理由
            </div>
            <div class="layui-form-item">
                <textarea placeholder="请输入内容" class="layui-textarea" name="content"></textarea>
            </div>
            <div class="layui-form-item">
                <label for="" class="layui-form-label">
                </label>
                <button class="layui-btn" lay-filter="add" lay-submit="">
                  提交
                </button>
            </div>
      </form>
    </div>
<script>
    layui.use('form', function(){
        var form =layui.form;
        //监听提交
        form.on('submit(add)', function(data){
            // 表单数据
            data = data.field;
            data.rid = {{ $rid }};
            data.post_url = {{ $pid }};
            // console.log(pid);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('/postlist/inform',{data:data},function(res){
                // console.log(res);
                if(res == '1'){
                    layer.alert("举报成功,我们会尽快处理的！", {icon: 6},function () {
                        // 获得frame索引
                        var index = parent.layer.getFrameIndex(window.name);
                        // 关闭当前frame
                        parent.layer.close(index);
                    });
                }else{
                    layer.alert("举报失败", {icon: 7},function () {
                        // 获得frame索引
                        var index = parent.layer.getFrameIndex(window.name);
                        // 关闭当前frame
                        parent.layer.close(index);
                    });
                }
            });
            return false;
        });
    })
</script>

  </body>

</html>
