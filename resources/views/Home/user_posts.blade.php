@include('Home/layout/header')
@include('/Home/user_nav')


  <div class="fly-panel fly-panel-user" pad20>
    <div class="layui-tab layui-tab-brief" lay-filter="user" id="LAY_uc">
<!--       <div class="fly-msg">
        您的邮箱尚未验证，这比较影响您的帐号安全，<a href="/user/activate/">立即去激活？</a>
      </div> -->

      <ul class="layui-tab-title" id="LAY_mine">
        <li data-type="mine-jie" lay-id="index" class="layui-this">我发的帖（<span>{{ $postlist->count() }}</span>）</li>
        <!-- <li data-type="collection" data-url="/collection/find/" lay-id="collection">我收藏的帖（<span>0</span>）</li> -->
      </ul>
    </div>
    <div class="layui-tab-content" id="LAY_ucm" style="padding: 5px 0;"> 
        <div class="layui-tab-item layui-show"> 
          <table class="layui-hide" id="LAY_mySendCard"></table>
          <div class="layui-form layui-border-box layui-table-view" lay-filter="LAY-table-1" lay-id="LAY_mySendCard" style=" ">
            <div class="layui-table-box">
              <div class="layui-table-header">
                <table cellspacing="0" cellpadding="0" border="0" class="layui-table" lay-skin="line">
                  <thead>
                    <tr>
                      <th data-field="title" data-key="1-0-0" data-minwidth="300" style="width:400px;">  
                        <div class="layui-table-cell laytable-cell-1-0-0">  
                          <span style="font-weight:bold; ">帖子标题</span>
                        </div>
                      </th>
                      <th data-field="status" data-key="1-0-1" style="width:100px;>
                        <div class="layui-table-cell laytable-cell-1-0-1" align="center">
                        <span style="font-weight:bold;">所在栏目</span>
                        </div>
                      </th>
                      <th data-field="time" data-key="1-0-3" style="width:200px;">
                        <div class="layui-table-cell laytable-cell-1-0-3" align="center">
                          <span style="font-weight:bold;"">发表时间</span>
                        </div>
                      </th>
                      <th data-field="4" data-key="1-0-4" class=" layui-table-col-special">
                        <div class="layui-table-cell laytable-cell-1-0-4">
                          <span style="font-weight:bold;"">数据</span></div>
                      </th>
                      <th data-field="5" data-key="1-0-5" class=" layui-table-col-special">
                        <div class="layui-table-cell laytable-cell-1-0-5">
                          <span style="font-weight:bold;"">操作</span>
                        </div>
                      </th>
                    </tr>
                  </thead>
                </table>
              @if($postlist->first())
                @foreach($postlist as $k => $v)
                <table cellspacing="0" cellpadding="0" border="0" class="layui-table" lay-skin="line">
                  <thead>
                    <tr>
                      <th data-field="title" data-key="1-0-0" data-minwidth="300" style="width:400px;">  
                        <div class="layui-table-cell laytable-cell-1-0-0">  
                          <a href="/postlist/detail/{{ $v['id'] }}" title="{{ $v->post_title }}" >{{ $v->post_title }}</a>
                        </div>
                      </th>
                      <th data-field="status" data-key="1-0-1" style="width:80px;>
                        <div class="layui-table-cell laytable-cell-1-0-1" align="center">
                          <span>{{ $post_column->where('id',$v->column_id)->first()['post_name'] }}</span>
                        </div>
                      </th>
                      <th data-field="time" data-key="1-0-3" style="width:200px;">
                        <div class="layui-table-cell laytable-cell-1-0-3" align="center">
                          <p title="{{ $v->created_at }}" >{{substr($v->created_at,5) }}</p>
                        </div>
                      </th>
                      <th data-field="4" data-key="1-0-4" class=" layui-table-col-special">
                        <div class="layui-table-cell laytable-cell-1-0-4">
                          <span>{{ $v->visits }} 阅 / {{ $v->reply_num }} 答</span></div>
                      </th>
                      <th data-field="5" data-key="1-0-5" class=" layui-table-col-special">
                        <div class="layui-table-cell laytable-cell-1-0-5">
                           <a title="删除" href="javascript:;" onclick="member_del(this,{{ $v->id }})">删除</a>
                        </div>
                      </th>
                    </tr>
                  </thead>
                </table>
                @endforeach
              </div>
              @else
              <div class="layui-table-body layui-table-main">
                <table cellspacing="0" cellpadding="0" border="0" class="layui-table" lay-skin="line">
                  <tbody></tbody>
                </table>
                <div class="layui-none">无数据</div>
              </div>
            </div>
            <div class="layui-table-page layui-hide">
              <div id="layui-table-page1"></div>
            </div>
            @endif
            <style>
              .laytable-cell-1-0-0{  }.laytable-cell-1-0-1{ width: 100px; }.laytable-cell-1-0-2{ width: 100px; }.laytable-cell-1-0-3{ width: 120px; }.laytable-cell-1-0-4{ width: 150px; }.laytable-cell-1-0-5{ width: 100px; }
            </style>
          </div> 
        </div> 
    </div>
  </div>
  <script>
    $.ajaxSetup({
           headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        });

    function member_del(obj,id){
        // layer.alert(id);
        layer.confirm('确认要删除帖子吗？删除后将无法恢复!',function(index){
          //     //发异步删除数据
          $.get('/userinfo/pdel/'+id,{
            "_token": "{{ csrf_token() }}",
          // "_method": "delete"
        },function(data){
          console.log(data);
          if(data == 1){
            $(obj).parents("tr").remove();
            layer.msg('已删除!',{icon:1,time:1000});
          }else{
            layer.msg('删除失败!',{icon:2,time:1000});
          }
        });
          });
      }
  </script>
</body>
</html>
