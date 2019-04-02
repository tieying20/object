@include('Admin/layout/header')
  <body class="layui-anim layui-anim-up">
    <div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="">首页</a>
        <a href="">演示</a>
        <a>
          <cite>导航元素</cite></a>
      </span>
      <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body">
      <div class="layui-row">
        <form class="layui-form layui-col-md12 x-so" action="" ="/admin/admin" method="get">
            {{ csrf_field() }}
          <!-- <input class="layui-input" placeholder="开始日" name="start" id="start">
          <input class="layui-input" placeholder="截止日" name="end" id="end"> -->
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
      </div>
      <xblock>
        <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>
        <!-- <button class="layui-btn" onclick="location.href='/admin/user/create'"><i class="layui-icon"></i>添加</button> -->
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
            <th>序号</th>
            <th>回贴用户</th>
            <th>回贴内容</th>
            <th>举报类型</th>
            <th>描述举报内容</th>
            <th>贴子的链接</th>
            <th>回贴时间</th>
            <th>操作</th></tr>
        </thead>
        <tbody>

        <!-- 单条会员列表开始 -->
        @if(!empty($list[0]))
        @foreach($list as $key => $value)
            <tr style="text-align: center;">
                <td>
                  <div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id='{{ $value['id'] }}'><i class="layui-icon">&#xe605;</i></div>
                </td>
                <td>{{ $firstItem++ }}</td>
                <td>{{ $value->reply->user['u_name'] }}</td>
                <td>{!! $value->reply['reply_content'] !!}</td>
                <td>{{ $value['type'] }}</td>
                <td>{{ $value['content'] or '未填写'}}</td>
                <td><a href="{{ $value['post_url'] }}" target="_blank">{{ $value['post_url'] }}</a></td>
                <td>{{ $value['created_at'] }}</td>
                <td class="td-manage">
                    <a title="未违规，删除举报并通知用户" onclick="member_del(this,'{{ $value{'id'} }}')" href="javascript:;">
                        <i class="icon iconfont"></i>
                    </a>
                    <!-- <a title="存在违规，删除并通知用户" onclick="member_del(this,'{{ $value{'id'} }}')" href="javascript:;">
                        <i class="layui-icon">&#xe640;</i>
                    </a> -->
                </td>
              </tr>
        @endforeach
        @else
            <tr>
                <td colspan="9">暂无数据</td>
            </tr>
        @endif
        <!-- 单条会员列表结束 -->

        </tbody>
      </table>

      <!-- 分页开始 -->
      <div class="page">
        {{ $list->links() }}
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

    function setStatus(obj, id, status){
        // 创建select
        select = $('<select></select>');
        // 添加选项
        switch(status){
            case 0:
                select.append('<option value="0" selected>普通帖</option>');
                select.append('<option value="1">精华帖</option>');
                select.append('<option value="2">置顶帖</option>');
                break;
            case 1:
                select.append('<option value="0">普通帖</option>');
                select.append('<option value="1" selected>精华帖</option>');
                select.append('<option value="2">置顶帖</option>');
                break;
            case 2:
                select.append('<option value="0">普通帖</option>');
                select.append('<option value="1">精华帖</option>');
                select.append('<option value="2" selected>置顶帖</option>');
                break;
        }

        // 把原来显示的内容替换成select
        $(obj).html(select);
        // 去掉点击事件的方法
        $(obj).attr('onclick','');
        // 给select聚焦
        select.focus();

        // 给select增加失去焦点事件
        select.blur(function(){
            // 获取修改的选项value
            select_val = $(this).val();
            // 判断是否有修改状态值
            if(status != select_val){
                // 发送ajax
                $.post('/postlist/setstatus',{id:id,status:select_val},function(res){
                    setS = select.children().eq(res).html(); // 根据返回的状态值获取内容
                    $(obj).html(setS); // 替换td的内容
                    $(obj).attr('onclick','setStatus(this,'+id+','+select_val+')'); // 把方法加回去
                });
            }else{
                // 没有修改内容，变回原来的内容
                setS = select.children().eq(status).html();// 根据状态值获取内容
                $(obj).html(setS); // 替换td的内容
                $(obj).attr('onclick','setStatus(this,'+id+','+select_val+')'); // 把方法加回去
            }
        });
    }


      /*未违规，删除并通知举报用户*/
    function member_del(obj,id){
        layer.confirm('未违规，删除举报并通知举报用户',function(index){
            //发异步删除数据
            // ajax传值
            $.post('/postlist/delReport',{id:id},function(result){
                // 1 删除成功
                // 2 删除失败
                if(result == 1){
                    $(obj).parents("tr").remove();
                    layer.msg('操作成功',{icon:1,time:1000});
                }else{
                    layer.alert("操作失败", {icon: 4});
                }
            });
        });
    }

      function delAll (argument) {
        var data = tableCheck.getData();
        layer.confirm('未违规，删除举报并通知'+ data.length+'位用户吗？',function(index){
            //捉到所有被选中的，发异步进行删除
            // ajax传值
            $.ajaxSetup({
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('/postlist/delReport',{id:data},function(result){
                // 1 删除成功
                // 2 删除失败
                if(result == 1){
                    layer.msg('删除成功', {icon: 1});
                    $(".layui-form-checked").not('.header').parents('tr').remove();
                }else{
                    layer.alert("删除失败", {icon: 4});
                }
            });
        });
      }
    </script>

  </body>

</html>
