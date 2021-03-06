@extends('Home/layout/model')

<!-- 左侧主体开始 -->
@section('left')
    <!-- 轮播图 -->
    <link rel="stylesheet" href="/css/Mycss.css">
    <div class="middle_right">
      <div id="lunbobox">
      <div id="toleft">&lt;</div>
      <div class="lunbo">
          @foreach($slide_list as $k=>$v)
          <a href="{{ $v['img_url'] }}" target="_block"><img src="{{ $v['img_path'] }}"></a>
          @endforeach
      </div>
      <div id="toright">&gt;</div>
      <ul>
          @foreach($slide_list as $k=>$v)
          <li></li>
          @endforeach
      </ul>
      <span></span>
      </div>
    </div>

    <!-- 贴子部分 -->
    <div class="fly-panel">
        <div class="fly-panel-title fly-filter">
          <a>置顶</a>
        </div>
        <ul class="fly-list">
            @foreach($stick as $k=>$v)
            <li>
                <a href="/userinfo/index/{{ $v->user['id'] }}" class="fly-avatar"  target="_blank">
                    <img src="{{ $v->user->userinfo->head_img }}" alt="{{ $v->user->name }}">
                </a>
                <h2>
                    <a class="layui-badge">{{ $v->postColumn->post_name }}</a>
                    <a href="/postlist/detail/{{ $v['id'] }}">{{ $v->post_title }}</a>
                </h2>
                <div class="fly-list-info">
                    <a href="/userinfo/index/{{ $v->user['id'] }}" link target="_blank">
                        <cite>{{ $v->user->u_name }}</cite>
                        <!--<i class="iconfont icon-renzheng" title="认证信息：XXX"></i>-->
                        <!-- <i class="layui-badge fly-badge-vip">VIP3</i> -->
                    </a>
                    <span>{{ $v['created_at'] }}</span>
                    <span class="fly-list-kiss layui-hide-xs" title="悬赏积分">
                        <i class="iconfont icon-kiss"></i>{{ $v['integral'] }}</span>
                    <!-- <span class="layui-badge fly-badge-accept layui-hide-xs">已结</span> -->
                    <span class="fly-list-nums"><i class="iconfont icon-pinglun1" title="回复"></i>{{ $v['reply_num'] }}</span>
                </div>
                <div class="fly-list-badge">
                    @if($v['status'] == 2)
                    <span class="layui-badge layui-bg-black">置顶</span>
                    @endif
                </div>
            </li>
        @endforeach
        </ul>
    </div>
    <div class="fly-panel" style="margin-bottom: 0;">
        <div class="fly-panel-title fly-filter">
          <a href="/home/index/status/id" class="layui-this post_status">综合</a>
          <span class="fly-mid"></span>
          <!-- <a href="">未结</a>
          <span class="fly-mid"></span>
          <a href="">已结</a>
          <span class="fly-mid"></span> -->
          <a href="/home/index/1/id" class="post_status" id="post_status">精华</a>

          <span class="fly-filter-right layui-hide-xs">
            <a href="{{ $status!=1 ? '/home/index/status/id' : '/home/index/1/id' }}" class="layui-this tiaojian">按最新</a>
            <span class="fly-mid"></span>
            <a href="{{ $status!=1 ? '/home/index/status/reply_num' : '/home/index/1/reply_num' }}" class="tiaojian">按热议</a>
          </span>
            <!-- 给上面的标签加样式的 -->
            <script type="text/javascript">
                status = {{ empty($status) ? 'false' : $status }};
                order = '{{ $order }}';
                // 在综合还是精华
                if(status == 1){
                    $('.post_status').removeClass('layui-this');
                    $('#post_status').addClass('layui-this');
                    // console.log($('.post_status'));
                }

                // 以最新还是评论最多展示，添加样式
                if(order == 'reply_num'){
                    $('.tiaojian').removeClass('layui-this');
                    $('.tiaojian').eq('1').addClass('layui-this');
                    // console.log($('.tiaojian').eq('1'));
                }
            </script>
        </div>

        <ul class="fly-list">
        @foreach($postlist as $k=>$v)
            <li>
                <a href="/userinfo/index/{{ $v->user['id'] }}" class="fly-avatar"  target="_blank">
                    <img src="{{ $v->user->userinfo->head_img }}" alt="{{ $v->user->name }}">
                </a>
                <h2>
                    <a class="layui-badge">{{ $v->postColumn->post_name }}</a>
                    <a href="/postlist/detail/{{ $v['id'] }}">{{ $v->post_title }}</a>
                </h2>
                <div class="fly-list-info">
                    <a href="/userinfo/index/{{ $v->user['id'] }}" link target="_blank">
                        <cite>{{ $v->user->u_name }}</cite>
                        <!--<i class="iconfont icon-renzheng" title="认证信息：XXX"></i>-->
                        <!-- <i class="layui-badge fly-badge-vip">VIP3</i> -->
                    </a>
                    <span>{{ $v['created_at'] }}</span>
                    <span class="fly-list-kiss layui-hide-xs" title="悬赏积分">
                        <i class="iconfont icon-kiss"></i>{{ $v['integral'] }}</span>
                    <!-- <span class="layui-badge fly-badge-accept layui-hide-xs">已结</span> -->
                    <span class="fly-list-nums"><i class="iconfont icon-pinglun1" title="回复"></i>{{ $v['reply_num'] }}</span>
                </div>
                <div class="fly-list-badge">
                    @if($v['status'] == 1)
                    <span class="layui-badge layui-bg-red">精帖</span>
                    @endif
                </div>
            </li>
        @endforeach
        </ul>
        <div class="page">
            {{ $postlist->links() }}
        </div>
        <div style="text-align: center">

            <div class="laypage-main">
            </div>
        </div>
    </div>

    <!-- 轮播图js -->
    <script>
        ///轮播
        $(function() {
          //$("#toright").hide();
          //$("#toleft").hide();
          $('#toright').hover(function() {
              $("#toleft").hide()
          }, function() {
              $("#toleft").show()
          })
          $('#toleft').hover(function() {
              $("#toright").hide()
          }, function() {
              $("#toright").show()
          })
        })

        var t;
        var index = 0;
        /////自动播放
        t = setInterval(play, 3000)

        function play() {
          index++;
          if (index > {{ $slide_num }}) {
              index = 0
          }
          // console.log(index)
          $("#lunbobox ul li").eq(index).css({
              "background": "#999",
              "border": "1px solid #ffffff"
          }).siblings().css({
              "background": "#cccccc",
              "border": ""
          })

          $(".lunbo a ").eq(index).fadeIn(500).siblings().fadeOut(500);
        };

        ///点击鼠标 图片切换
        $("#lunbobox ul li").click(function() {

          //添加 移除样式
          //$(this).addClass("lito").siblings().removeClass("lito"); //给当前鼠标移动到的li增加样式 且其余兄弟元素移除样式   可以在样式中 用hover 来对li 实现
          $(this).css({
              "background": "#999",
              "border": "1px solid #ffffff"
          }).siblings().css({
              "background": "#cccccc"
          })
          var index = $(this).index(); //获取索引 图片索引与按钮的索引是一一对应的
          // console.log(index);

          $(".lunbo a ").eq(index).fadeIn(500).siblings().fadeOut(500); // siblings  找到 兄弟节点(不包括自己）
        });

        /////////////上一张、下一张切换
        $("#toleft").click(function() {
          index--;
          if (index < 0) //判断index<0的情况为：开始点击#toright  index=0时  再点击 #toleft 为负数了 会出错
          {
              index = {{ $slide_num-1 }};
          }
          console.log(index);
          $("#lunbobox ul li").eq(index).css({
              "background": "#999",
              "border": "1px solid #ffffff"
          }).siblings().css({
              "background": "#cccccc"
          })

          $(".lunbo a ").eq(index).fadeIn(500).siblings().fadeOut(500); // siblings  找到 兄弟节点(不包括自己）必须要写
        }); // $("#imgbox a ")获取到的是一个数组集合 。所以可以用index来控制切换

        $("#toright").click(function() {
          index++;
          if (index > {{ $slide_num-1 }}) {
              index = 0
          }
          console.log(index);
          $(this).css({
              "opacity": "0.5"
          })
          $("#lunbobox ul li").eq(index).css({
              "background": "#999",
              "border": "1px solid #ffffff"
          }).siblings().css({
              "background": "#cccccc"
          })
          $(".lunbo a ").eq(index).fadeIn(500).siblings().fadeOut(500); // siblings  找到 兄弟节点(不包括自己）
        });
        $("#toleft,#toright").hover(function() {
              $(this).css({
                  "color": "black"
              })
          },
          function() {
              $(this).css({
                  "opacity": "0.4",
                  "color": ""
              })
          })
        ///

        ///////鼠标移进  移出
        $("#lunbobox ul li,.lunbo a img,#toright,#toleft ").hover(
          ////////鼠标移进
          function() {
              $('#toright,#toleft').show()
              clearInterval(t);

          },
          ///////鼠标移开
          function() {
              //$('#toright,#toleft').hide()
              //alert('aaa')
              t = setInterval(play, 3000)

              function play() {
                  index++;
                  if (index > {{ $slide_num }}) {
                      index = 0
                  }
                  $("#lunbobox ul li").eq(index).css({
                      "background": "#999",
                      "border": "1px solid #ffffff"
                  }).siblings().css({
                      "background": "#cccccc"
                  })
                  $(".lunbo a ").eq(index).fadeIn(500).siblings().fadeOut(500);
              }
          })
    </script>
@endsection
<!-- 左侧主体结束 -->

<!-- 签到模块开始 -->
@section('signin')
    <div class="fly-panel fly-signin">
      <div class="fly-panel-title">
        签到
        <i class="fly-mid"></i>
        <a href="javascript:;" class="fly-link" id="LAY_signinHelp">说明</a>
        <i class="fly-mid"></i>
        <!-- <a href="javascript:;" class="fly-link" id="LAY_signinTop">活跃榜<span class="layui-badge-dot"></span></a> -->

        @if(session()->has('user'))
        <span class="fly-signin-days">已连续签到<cite>{{ $sign['xunum'] }}</cite>天</span>
        @endif

      </div>
      <div class="fly-panel-main fly-signin-main" style="height:370px;">

        @if(session()->has('user'))
          @if(strtotime($sign['updated_at']) < strtotime(date('Y-m-d')) )
            <button class="layui-btn layui-btn-danger" id="signin">今日签到</button>
            <span>可获得<cite>{{ $integral }}</cite>积分</span>
          @else
            <button class="layui-btn layui-btn-disabled">今日已签到</button>
            <span>获得了<cite>{{ $integral }}</cite>积分</span>

          @endif
        @else
          <button class="layui-btn layui-btn-danger" id="signin">今日签到</button>
        @endif
        <div id="date" style="margin-top:10px;"></div>

      </div>
    </div>
@endsection
<!-- 签到script -->
@section('signin_script')
  layui.use('laydate', function(){
    var laydate = layui.laydate;
    laydate.render({
      elem: '#date'
      ,btns: ['now']
      ,calendar: true
      ,position: 'static'
      ,min: '{:date("Y-m-d", mktime(0,0,0, date("m")-1, 1, date("Y")) )}'
      ,max: '{:date("Y-m-d")}'
      ,ready: function(date){
        //控件在打开时触发
        // console.log('date', date);
        distd();
        getdate(date);
      }
      ,change: function(value, date, endDate){
        //时间被切换时触发
        // console.log('date', date);
        distd();
        getdate(date);
      }
    });
  });

  // 1、获取签到日期。 初始化当前年月，获取签到列表
  // 2、根据日期添加标签。
  var smiles  =  '<i class="layui-icon">&#xe6af;</i>';
  //禁止点击日历
  function distd(){
    $('.layui-laydate-content tbody td').each(function(){
      if ( $(this).hasClass('laydate-disabled') == false ) {
        $(this).addClass('laydate-disabled');
      }
    });
  }

  // 获取签到日期，循环添加签到
function getdate(cdate='')
{
  $.get({
      url :'/home/signin/has',
      data : cdate,
      success : function(result){
        // console.log(result);
        if(result.rescode < 0){
          return ;
        }
        //拿数据
        smileok(result);
      }
    });

  function smileok(signindata)
  {
    for (var i = signindata.length - 1; i >= 0; i--) {
      $('td').each(function(){
        var ymd = $(this).attr('lay-ymd');
        if ( ymd == signindata[i] ) {
          $arr = $(this).append(smiles);
          return true;
        }
      });
    }
  }
}

//签到
$('#signin').click(function()
{
  @if(session()->has('user'))
    var curdate = new Date();
    var date ={ 'year':curdate.getFullYear(), 'month':curdate.getMonth()+1,'day':curdate.getDate()}
    // console.log(date);
    $.post({
      url :'/home/signin',
      data :date,
      success:function(data){
        console.log(data);
        if(data==0) {
          //签到成功
          $('#signin').removeClass('layui-btn layui-btn-danger').addClass('layui-btn layui-btn-disabled').html('今日已签到');
          layer.msg('签到成功');

          // getsmiledate(date);
        }else if(data==3){
          layer.msg('今日已签到,记得明日再来签到哦');

        }else{
          layer.msg('网络异常 请稍后再试',function(){

          });
        }
      }
    })
  @else
  layer.msg('请先登入',function(){

  })
  @endif
})

@endsection
<!-- 签到模块结束 -->








