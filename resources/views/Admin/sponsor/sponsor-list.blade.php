@include('Admin/layout/header')
 <meta name="csrf-token" content="{{ csrf_token() }}">
 <body class="layui-anim layui-anim-up">
    <div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="">首页</a>
        <a href="#">赞助商广告投放</a>
        <a>
          <cite>赞助商列表</cite></a>
      </span>
      <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body">
      <div class="layui-row">
        <form class="layui-form layui-col-md12 x-so">
          <input class="layui-input" placeholder="开始日" name="start" id="start">
          <input class="layui-input" placeholder="截止日" name="end" id="end">
          <input type="text" name="username"  placeholder="请输入用户名" autocomplete="off" class="layui-input">
          <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
        </form>
      </div>
      <xblock>
        <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>
        <button class="layui-btn" onclick="x_admin_show('添加用户','/admin/sponsor/create',600,400)"><i class="layui-icon"></i>添加</button>
        <span class="x-right" style="line-height:40px">共有数据：88 条</span>
      </xblock>
      <table class="layui-table">
        <thead>
          <tr>
            <th>
              <div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div>
            </th>
            <th>ID</th>
            <th>赞助商</th>
            <th>广告展示</th>
            <th>广告链接</th>
            <th>开始时间</th>
            <th>到期时间</th>
            <th>加入时间</th>
            <th>状态</th>
            <th>操作</th></tr>
        </thead>
        <tbody>

        @foreach($list as $k => $v)
          <tr>
            <td>
              <div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id='2'><i class="layui-icon">&#xe605;</i></div>
            </td>
            <td>{{ $v['id'] }}</td>
            <td>{{ $v['s_company'] }}</td>
            <td>{{ $v['img_path'] }}</td>
            <td><a href="{{ $v['img_url'] }}" target="_blank">{{ $v['img_url'] }}</a></td>
            <td>{{ $v['start_at'] }}</td>
            <td>{{ $v['stop_at'] }}</td>
            <td>{{ $v['created_at'] }}</td>
            <td class="td-status">
              <span class="layui-btn layui-btn-normal layui-btn-mini">已投放</span></td>
            <form onsubmit="return false">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <td class="td-manage">
              <a onclick="member_stop(this,'10001')" href="javascript:;"  title="启用">
                <i class="layui-icon">&#xe601;</i>
              </a>
              <a title="编辑"  onclick="x_admin_show('编辑','member-edit.html',600,400)" href="javascript:;">
                <i class="layui-icon">&#xe642;</i>
              </a>
              <a title="删除" href="javascript:;" onclick="member_del(this,{{ $v['id'] }})">
                <i class="layui-icon">&#xe640;</i>
              </a>
            </td>
            </form>
          </tr>
		@endforeach
        </tbody>
      </table>
      <div class="page">
        <div>
          <a class="prev" href="">&lt;&lt;</a>
          <a class="num" href="">1</a>
          <span class="current">2</span>
          <a class="num" href="">3</a>
          <a class="num" href="">4</a>
          <a class="next" href="">&gt;&gt;</a>
        </div>
      </div>

    </div>
    <script>
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
          layer.confirm('确认要停用吗？',function(index){

              if($(obj).attr('title')=='启用'){

                //发异步把用户状态进行更改
                $(obj).attr('title','停用')
                $(obj).find('i').html('&#xe62f;');

                $(obj).parents("tr").find(".td-status").find('span').addClass('layui-btn-disabled').html('已停用');
                layer.msg('已停用!',{icon: 5,time:1000});

              }else{
                $(obj).attr('title','启用')
                $(obj).find('i').html('&#xe601;');

                $(obj).parents("tr").find(".td-status").find('span').removeClass('layui-btn-disabled').html('已投放');
                layer.msg('已启用!',{icon: 6,time:1000});
              }
              
          });
      }

      $.ajaxSetup({
           headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        });
      /*用户-删除*/
      function member_del(obj,id){
      		// layer.alert(id);
          layer.confirm('确认要删除吗？',function(index){
	          //     //发异步删除数据
	          $.post('/admin/sponsor/'+id,{
	          	"_token": "{{ csrf_token() }}",
	      		"_method": "delete"
				},function(data){
					if(data == 1){
						$(obj).parents("tr").remove();
						layer.msg('已删除!',{icon:1,time:1000});
					}else{
						layer.msg('删除失败!',{icon:2,time:1000});
					}
				});
          });
      }



      function delAll (argument) {

        var data = tableCheck.getData();
  
        layer.confirm('确认要删除吗？'+data,function(index){
            //捉到所有被选中的，发异步进行删除
            layer.msg('删除成功', {icon: 1});
            $(".layui-form-checked").not('.header').parents('tr').remove();
        });
      }
    </script>

  </body>

</html>