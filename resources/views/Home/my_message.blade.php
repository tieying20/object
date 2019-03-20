@include('Home/layout/header')
@include('/Home/user_nav')


        <div class="fly-panel fly-panel-user" pad20>
            <div class="layui-tab layui-tab-brief" lay-filter="user" id="LAY_msg" style="margin-top: 15px;">
                <button class="layui-btn layui-btn-danger layui-hide" id="LAY_delallmsg">清空全部消息</button>
                <div id="LAY_minemsg" style="margin-top: 10px;">111</div>
            </div>
        </div>

    </div>
</body>
</html>
