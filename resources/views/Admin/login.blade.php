@include('Admin/layout/header')
<body class="login-bg">
     
    <div class="login layui-anim layui-anim-up">
        <div class="message">有个社区管理登录</div>
        <div id="darkbannerwrap"></div>
        
        <form method="post" class="layui-form" action="/admin/dologin">
        {{ csrf_field() }}
            <span style="color:red;">
            
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            </span>
            <input name="admin_name" placeholder="用户名"  type="text" lay-verify="required" class="layui-input" >
            <hr class="hr15">
            <input name="admin_pwd" lay-verify="required" placeholder="密码"  type="password" class="layui-input">
            <hr class="hr15">
            <input value="登录" lay-submit lay-filter="login" style="width:100%;" type="submit">
            <hr class="hr20" >
        </form>
    </div>

    <script>
    //     $(function  () {
    //         layui.use('form', function(){
    //           var form = layui.form;
    //           // layer.msg('玩命卖萌中', function(){
    //           //   //关闭后的操作
    //           //   });
    //           //监听提交
    //           form.on('submit(login)', function(data){
    //             // alert(888)
    //             layer.msg(JSON.stringify(data.field),function(){
    //                 location.href='index.html'
    //             });
    //             return false;
    //           });
    //         });
    //     })

        
    </script>

    
    <!-- 底部结束 -->

</body>
</html>