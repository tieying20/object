@include('Admin/layout/header')

  <body class="layui-anim layui-anim-up">
    <!-- <div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="">首页</a>
        <a href="">演示</a>
        <a>
          <cite>导航元素</cite>
        </a>
      </span>
      <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div> -->
    <div class="x-body">
      <div class="layui-row">
        <form class="layui-form layui-col-md12 x-so" action="/admin/role" method="get">
        {{ csrf_field() }}
          <!-- <input class="layui-input" placeholder="开始日" name="start" id="start"> -->
          <!-- <input class="layui-input" placeholder="截止日" name="end" id="end"> -->
          <input type="text" name="search"  placeholder="请输入角色名称" autocomplete="off" class="layui-input" value="{{ $search }}">
          <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
        </form>
      </div>
      <xblock>
        <!-- <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>
        <button class="layui-btn" onclick="x_admin_show('添加用户','/admin/user/create',600,400)"><i class="layui-icon"></i>添加</button> -->
        <!-- <button class="layui-btn" onclick="location.href='/admin/user/create'"><i class="layui-icon"></i>添加</button> -->
        <span class="x-right" style="line-height:40px">共有数据：{{ $role->total() }}条</span>
      </xblock>
      <table class="layui-table">
        <thead>
          <tr>
            <th>
              <div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div>
            </th>
            <th>编号</th>
            <th>角色名称</th>
            <th>注册时间</th>
            <th>修改时间</th>
            <th>状态</th>
            <th>操作</th></tr>
        </thead>
        <tbody>
        @if($role)
        <!-- 单条前台用户列表开始 -->
        @foreach($role as $key => $val)
          <tr>
            <td>
              <div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id='2'><i class="layui-icon">&#xe605;</i></div>
            </td>
            <td>{{ $i++ }}</td>
            <td>{{ $val['name'] }}</td>
            <td>{{ $val['created_at'] }}</td>
            <td>{{ $val['updated_at'] }}</td>
            <td class="td-status">
                    @if($val['status'] == '0')
                        <span class="layui-btn layui-btn-normal layui-btn-mini">已启用</span>
                    @else
                        <span class="layui-btn layui-btn-normal layui-btn-mini layui-btn-disabled">已停用</span>
                    @endif

                </td>
            <td class="td-manage">
                    @if($val['status'] == '0')
                        <a onclick="member_stop(this,'{{ $val['id'] }}')" href="javascript:;"  title="已启用">
                            <i class="layui-icon"></i>
                        </a>
                    @else
                        <a onclick="member_stop(this,'{{ $val['id'] }}')" href="javascript:;" title="已停用">
                            <i class="layui-icon"></i>
                        </a>
                    @endif

              <a title="修改"  onclick="x_admin_show('修改','/admin/role/{{ $val['id'] }}/edit',500,400)" href="javascript:;">
                <i class="layui-icon">&#xe642;</i>
              </a>
              <!-- <a onclick="x_admin_show('修改密码','member-password.html',600,400)" title="修改密码" href="javascript:;">
                <i class="layui-icon">&#xe631;</i>
              </a> -->
              <a title="删除" onclick="member_del(this,'{{ $val['id'] }}')" href="javascript:;">
                <i class="layui-icon">&#xe640;</i>
              </a>
            </td>
          </tr>
        @endforeach
        <!-- 单条前台用户列表结束 -->
        @else
          <tr>
            <td>暂无数据</td>
          </tr>
        @endif
        </tbody>
      </table>

      <!-- 分页开始 -->
      <div class="page">
        {{ $role->links() }}
      </div>
      <!-- 分页结束 -->

    </div>
    <script>
      $.ajaxSetup({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
      });

      layui.use('laydate', function(){
        var laydate = layui.laydate;

        //执行一个laydate实例
        laydate.render({
          elem: '#start' //指定元素
        });

        //执行一个laydate实例
        laydate.render({
          elem: '#end' //指定元素
        });
      });

       /*用户-停用*/ 
      function member_stop(obj,id){
          layer.confirm('确认吗？',function(index){

              // if($(obj).attr('title')=='已启用'){

                //发异步把用户状态进行更改
                $.ajax({
                    url : '/admin/role/setStatus/' + id,
                    type : 'get',
                    async: true,
                    success:function(result){
                        // 1 成功
                        // 2 失败
                        if(result == '1'){
                          if($(obj).attr('title')=='已启用'){
                              $(obj).attr('title','已停用')
                              $(obj).find('i').html('&#xe62f;');
                              $(obj).parents("tr").find(".td-status").find('span').addClass('layui-btn-disabled').html('已停用');
                              layer.msg('已停用!',{icon: 5,time:1000});
                          }else if($(obj).attr('title')=='已停用'){
                              $(obj).attr('title','已启用')
                              $(obj).find('i').html('&#xe601;');

                              $(obj).parents("tr").find(".td-status").find('span').removeClass('layui-btn-disabled').html('已启用');
                              layer.msg('已启用!',{icon: 6,time:1000});
                          }
                        }else{
                            layer.msg('修改失败!',{icon: 5,time:1000});
                        }

                    }
                });
              // }

          });
      }

      /*用户-删除*/
      function member_del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            //发异步删除数据
            // ajax传值

            $.ajax({url:'/admin/role/'+id,type:'DELETE',async:true,success:function(result){
                console.log(result);
                // 1 删除成功
                // 2 删除失败
                if(result == 1){
                    $(obj).parents("tr").remove();
                    layer.msg('删除成功',{icon:1,time:1000});
                }else{
                    layer.alert("删除失败", {icon: 4});
                }
            }});

        });
      }



      // function delAll (argument) {

      //   var data = tableCheck.getData();

      //   layer.confirm('确认要删除吗？'+data,function(index){
      //       //捉到所有被选中的，发异步进行删除
      //       layer.msg('删除成功', {icon: 1});
      //       $(".layui-form-checked").not('.header').parents('tr').remove();
      //   });
      // }
    </script>

  </body>

</html>
