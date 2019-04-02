@include('Home/layout/header')

<div class="layui-container fly-marginTop">
  <div class="fly-panel" pad20 style="padding-top: 5px;">
    <!--<div class="fly-none">没有权限</div>-->
    <div class="layui-form layui-form-pane">
      <div class="layui-tab layui-tab-brief" lay-filter="user">
        <ul class="layui-tab-title">
          <li class="layui-this">发表新帖<!-- 编辑帖子 --></li>
        </ul>
        @if (session('status'))
            <blockquote class="layui-elem-quote " style="margin-top: 10px;">
              <div id="test2">{{ session('error') }}</div>
            </blockquote>
        @endif
        <div class="layui-form layui-tab-content" id="LAY_ucm" style="padding: 20px 0;">
          <div class="layui-tab-item layui-show">
            <form action="/postlist/doadd" method="post">
                {{ csrf_field() }}
              <div class="layui-row layui-col-space15 layui-form-item">
                <div class="layui-col-md3">
                  <label class="layui-form-label">所在专栏</label>
                  <div class="layui-input-block">
                    <select lay-verify="required" name="column_id" lay-filter="column">
                      <option></option>
                      @foreach($column as $k=>$v)
                      <option value="{{ $v['id'] }}">{{ $v['post_name'] }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="layui-col-md9">
                  <label for="L_title" class="layui-form-label">标题</label>
                  <div class="layui-input-block">
                    <input type="text" id="L_title" name="post_title" required lay-verify="required" autocomplete="off" class="layui-input">
                    <!-- <input type="hidden" name="id" value=""> -->
                  </div>
                </div>
              </div>

              <div class="layui-form-item layui-form-text">
                <div class="layui-input-block">
                    <!-- 加载编辑器的容器 -->
                    <script id="container" name="post_content" type="text/plain" style="height:250px"></script>
                    <!-- 配置文件 -->
                    <script type="text/javascript" src="/utf8-php/ueditor.config.js"></script>
                    <!-- 编辑器源码文件 -->
                    <script type="text/javascript" src="/utf8-php/ueditor.all.js"></script>
                    <!-- 实例化编辑器 -->
                    <script type="text/javascript">
                        var ue = UE.getEditor('container',{
                            toolbars: [
                            ['source', 'undo', 'redo' ,'emotion' ,'fontfamily']
                        ],
                        });
                    </script>
                  <!-- <textarea id="L_content" name="post_content" required lay-verify="required" placeholder="详细描述" class="layui-textarea fly-editor" style="height: 260px;"></textarea> -->
                </div>
              </div>
              <div class="layui-form-item">

                  <label class="layui-form-label">悬赏积分</label>
                  <div class="layui-input-inline" style="width: 190px;">
                    <input type="text" class="layui-input" name="integral" value="0" id="integral">
                  </div>
                  <div class="layui-form-mid layui-word-aux" id="hint">剩余{{ $integral }}积分哦</div>

              </div>
              <!-- <div class="layui-form-item">
                <label for="L_vercode" class="layui-form-label">人类验证</label>
                <div class="layui-input-inline">
                  <input type="text" id="L_vercode" name="vercode" required lay-verify="required" placeholder="请回答后面的问题" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid">
                  <span style="color: #c00;">1+1=?</span>
                </div>
              </div> -->
              <div class="layui-form-item">
                <button class="layui-btn" onclick="return verify()">立即发布</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="fly-footer">
  <p><a href="http://fly.layui.com/" target="_blank">Fly社区</a> 2017 &copy; <a href="http://www.layui.com/" target="_blank">layui.com 出品</a></p>
  <p>
    <a href="http://fly.layui.com/jie/3147/" target="_blank">付费计划</a>
    <a href="http://www.layui.com/template/fly/" target="_blank">获取Fly社区模版</a>
    <a href="http://fly.layui.com/jie/2461/" target="_blank">微信公众号</a>
  </p>
</div>
<script>
    // 积分框
    $('#integral').focus(function(){
        // 获取到焦点，如果值设置为默认值0则设置为空
        if($(this).val() == '0'){
            $(this).val('');
        }
    }).blur(function(){
        // 失去焦点的时候如果值为空则设置为0
        if($(this).val() == ''){
            $(this).val('0');
        }
    });

    // 提交验证
    function verify(){
        integral = $('#integral').val(); // 获取输入框积分
        have = {{ $integral }}; // 获取剩余积分

        if((have-integral) < 0){
            $('div#hint').html('<span style="color:red;">你的积分剩余' + have + '，请不要超额使用！</span>');
            $('#integral').focus();
            return false; // 阻止表单标砖
        }else{
            return true; // 让表单跳转
        }
    }
</script>
</body>
</html>
