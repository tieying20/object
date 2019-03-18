@include('Admin/layout/header')
 <meta name="csrf-token" content="{{ csrf_token() }}">
 <body class="layui-anim layui-anim-up">
    <div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="">首页</a>
        <a href="#">友情链接</a>
        <a>
          <cite>链接列表</cite></a>
      </span>
      <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body">
      <form class="layui-form layui-col-md12 x-so" action="" ="/admin/link" method="get">
            {{ csrf_field() }}
            <div class="layui-input-inline">
                <select name="count">
                    <option value="5" {{ $count == 5 ? 'selected' : ''}}>显示5条</option>
                    <option value="10" {{ $count == 10 ? 'selected' : ''}}>显示10条</option>
                    <option value="15" {{ $count == 15 ? 'selected' : ''}}>显示15条</option>
                    <option value="20" {{ $count == 20 ? 'selected' : ''}}>显示20条</option>
                </select>
            </div>
            <input type="text" name="search" placeholder="请输入关键字" autocomplete="off" class="layui-input" style="width:200px" value="{{ $search }}">
            <button class="layui-btn" lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
        </form>
      <xblock>
        <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>
        <button class="layui-btn" onclick="x_admin_show('添加链接','/admin/link/create',600,250)"><i class="layui-icon"></i>添加</button>
        <span class="x-right" style="line-height:40px">
            共有数据：{{ $list->total() }}条
        </span>
      </xblock>
      <table class="layui-table">
        <thead>
          <tr>
            <th>
              <div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div>
            </th>
            <th>ID</th>
            <th>标题</th>
            <th>链接</th>
            <th>加入时间</th>
            <th>修改时间</th>
            <th>状态</th>
            <th>操作</th></tr>
        </thead>
        <tbody>
		@if(!empty($list['0']))
        @foreach($list as $k => $v) 
          <tr>
            <td>
              <div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id='{{ $v['id'] }}'><i class="layui-icon">&#xe605;</i></div>
            </td>
            <td>{{ $v['id'] }}</td>
            <td>{{ $v['b_company'] }}</td>
            <td><a href="{{ $v['b_url'] }}" target="_blank">{{ $v['b_url'] }}</a></td>
            <td>{{ $v['created_at'] }}</td>
            <td>{{ $v['updated_at'] }}</td>
            @if($v['status'] == 0)
            <td class="td-status">
              <span class="layui-btn layui-btn-normal layui-btn-mini">已投放</span></td>
            @else
            <td class="td-status">
              <span class="layui-btn layui-btn-normal layui-btn-mini layui-btn-disabled">已停用</span></td>
            @endif
            <form onsubmit="return false">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <td class="td-manage">
            @if($v['status'] == 0)
                <a onclick="member_stop(this,'{{ $v['id'] }}')" href="javascript:;"  title="已启用">
                	<i class="layui-icon">&#xe601;</i>
              	</a>    
          	@else
                <a onclick="member_stop(this,'{{ $v['id'] }}')" href="javascript:;" title="已停用">
                    <i class="layui-icon"></i>
                </a>
            @endif
              <a title="编辑"  onclick="x_admin_show('编辑','/admin/link/{{ $v['id'] }}/edit')" href="javascript:;">
                <i class="layui-icon">&#xe642;</i>
              </a>
              <a title="删除" href="javascript:;" onclick="member_del(this,{{ $v['id'] }})">
                <i class="layui-icon">&#xe640;</i>
              </a>
            </td>
            </form>
          </tr>
		@endforeach
		@else
			<tr>
                <td colspan="10">暂无数据</td>
            </tr>
		@endif
        </tbody>
      </table>
      <div class="page">
        {{ $list->links() }}
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
	      if($(obj).attr('title')=='已启用'){
	      		layer.confirm('确认要停用吗？',function(index){
		            //发异步把用户状态进行更改
		            $.ajax({
		                url : '/admin/link/status/' + id + '/1',
		                type : 'get',
		                async: true,
		                success:function(result){
		                    // 1 成功
		                    // 2 失败
		                    if(result == 1){
		                        $(obj).attr('title','已停用')
		                        $(obj).find('i').html('&#xe62f;');

		                        $(obj).parents("tr").find(".td-status").find('span').addClass('layui-btn-disabled').html('已停用');
		                        layer.msg('已停用!',{icon: 5,time:1000});
		                    }else{
		                        layer.msg('修改失败!',{icon: 5,time:1000});
		                    }
		                }

                	});
            	});
          }else if($(obj).attr('title')=='已停用'){
          	layer.confirm('确认要启用吗？',function(index){
	            //发异步把用户状态进行更改
	            $.ajax({
	                url : '/admin/link/status/' + id + '/0',
	                type : 'get',
	                async: true,
	                success:function(result){
	                    // 1 成功
	                    // 2 失败
	                    if(result == 1){
	                        $(obj).attr('title','已启用')
	                        $(obj).find('i').html('&#xe601;');

	                        $(obj).parents("tr").find(".td-status").find('span').removeClass('layui-btn-disabled').html('已启用');
	                        layer.msg('已启用!',{icon: 6,time:1000});
	                    }else{
	                        layer.msg('修改失败!',{icon: 5,time:1000});
	                    }
	                }
	            });
            });  
          };
       
      };

      $.ajaxSetup({
           headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        });
      /*用户-删除*/
      function member_del(obj,id){
      		// layer.alert(id);
          layer.confirm('确认要删除吗？',function(index){
	          //     //发异步删除数据
	          $.post('/admin/link/'+id,{
	          	"_token": "{{ csrf_token() }}",
	      		"_method": "delete"
				},function(data){
					// console.log(data);
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
  
        layer.confirm('确认要删除'+data.length+'个链接吗?',function(index){
            //捉到所有被选中的，发异步进行删除
            // ajax传值
            $.ajaxSetup({
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
              url:'/admin/link/'+data,
              type:'DELETE',
              async:true,
              success:function(result){
                console.log(result);
                if(result ==1){
                  layer.msg('删除成功', {icon: 1});
                    $(".layui-form-checked").not('.header').parents('tr').remove();
                }else{
                    layer.alert("删除失败", {icon: 4});
                }
              }
            });
        });
      }
    </script>

  </body>

</html>