@include('Home/layout/header')
@include('/Home/user_nav')

<div class="fly-panel fly-panel-user" pad20 style="padding-top:20px;">
  	<div class="fly-msg" style="margin-bottom: 20px;"> Hi，{{ $user['u_name'] }}，你已是我们的正式社员。 </div>
  	<div class="layui-row layui-col-space20"> 
	    <div class="layui-col-md6" > 
			<div class="fly-panel fly-signin fly-panel-border" > 
				<div class="fly-panel-title"> 签到 <i class="fly-mid"></i> 
					<a href="javascript:;" class="fly-link" id="LAY_signinHelp">说明</a> <i class="fly-mid"></i> 
					<!-- <a href="javascript:;" class="fly-link" id="LAY_signinTop">活跃榜<span class="layui-badge-dot"></span></a>  -->
					<span class="fly-signin-days">已连续签到<cite>{{ $sign['xunum'] }}</cite>天</span>
				</div> 
				<div class="fly-panel-main fly-signin-main">
					@if(strtotime($sign['updated_at']) < strtotime(date('Y-m-d')) )
		            	<button class="layui-btn layui-btn-danger" id="signin">今日签到</button>
		            @else
		            	<button class="layui-btn layui-btn-disabled">今日已签到</button>
	          			<span>获得了<cite style="color:red;">&nbsp5&nbsp</cite>积分</span>
		            @endif
				</div> 
			</div>
		</div> 
		<div class="layui-col-md6"> 
			<div class="fly-panel fly-panel-border" >
		 		<div class="fly-panel-title"> 我的会员信息 </div> 
		 		<div class="fly-panel-main layui-text" style="padding: 18px 15px; height: 50px; line-height: 26px;"> 
		 			<p>您的财富积分：{{ $sign['point'] }}</p> 
		 			<p>您当前为：非 VIP</p> 
		 		</div> 
		 	</div>
		</div>
		<div class="layui-col-md12" style="margin-top: -20px;"> 
			<div class="fly-panel fly-panel-border"> 
				<div class="fly-panel-title"> 快捷方式 </div> 
				<div class="fly-panel-main"> 
					<ul class="layui-row layui-col-space10 fly-shortcut"> 
						<li class="layui-col-sm3 layui-col-xs4 "> 
							<a href="/userinfo/set" class="layui-btn layui-btn-lg"><i class="layui-icon"></i><cite>修改信息</cite></a> 
						</li> 
						<li class="layui-col-sm3 layui-col-xs4 "> 
							<a href="/userinfo/set/#avatar" class="layui-btn layui-btn-lg"><i class="layui-icon "></i><cite>修改头像</cite></a> 
						</li> 
						<li class="layui-col-sm3 layui-col-xs4"> 
							<a href="/userinfo/set/#pass" class="layui-btn layui-btn-lg"><i class="layui-icon"></i><cite>修改密码</cite></a> 
						</li> 
						<li class="layui-col-sm3 layui-col-xs4"> 
							<a href="/postlist/add" class="layui-btn layui-btn-lg"><i class="layui-icon"></i><cite>发表新帖</cite></a> 
						</li> 
						<li class="layui-col-sm3 layui-col-xs4"> 
							<a href="/userinfo/message" class="layui-btn layui-btn-lg"><i class="layui-icon"></i><cite>我的消息</cite></a> 
						</li> 
						<li class="layui-col-sm3 layui-col-xs4 "> 
							<a href="javascript:;" class="layui-btn layui-btn-lg" id="fly-search"><i class="layui-icon"></i><cite>搜索资源</cite></a> 
						</li> 
						<li class="layui-col-sm3 layui-col-xs4"> 
							<a href="" class="layui-btn layui-btn-lg"><i class="layui-icon"></i><cite>我的收藏</cite></a> 
						</li> 
						<li class="layui-col-sm3 layui-col-xs4"> 
							<a href="" class="layui-btn layui-btn-lg" style="width: 135px;"><i class="layui-icon" ></i><cite>成为赞助商</cite></a> 
						</li>
					</ul> 
				</div>  
			</div> 
		</div>
	</div>
</div>

</body>
<script>
//签到
$('#signin').click(function()
{
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
    });
})
//搜索
  $('#fly-search').on('click', function(){
    layer.open({
      type: 1
      ,title: false
      ,closeBtn: false
      //,shade: [0.1, '#fff']
      ,shadeClose: true
      ,maxWidth: 10000
      ,skin: 'fly-layer-search'
      ,content: ['<form action="http://cn.bing.com/search">'
        ,'<input autocomplete="off" placeholder="搜索内容，回车跳转" type="text" name="q">'
      ,'</form>'].join('')
      ,success: function(layero){
        var input = layero.find('input');
        input.focus();

        layero.find('form').submit(function(){
          var val = input.val();
          if(val.replace(/\s/g, '') === ''){
            return false;
          }
          input.val('site:layui.com '+ input.val());
      });
      }
    })
  });
</script>
</html>
