@include('Admin/layout/header')
  
  <body class="layui-anim layui-anim-up">
    <div class="x-body">
      <table class="layui-table">
        <thead>
          <tr>
            <th>用户ID</th>
            <th>邮箱</th>
            <th>头像</th>
            <th>性别</th>
            <th>城市</th>
            <th>积分</th>
            <th>等级</th>
            <th>连续签到天数</th>
          </tr>
        </thead>
        <tbody>
        <!-- 单条前台用户详情开始 -->
          <tr>
            <td>{{ $user->userinfo->uid }}</td>
            <td>{{ $user->userinfo->email }}</td>
            <td style="width:100px;height:100px;">
                <img src="{{ $user->userinfo->head_img }}">
            </td>
            <td>
              @if ($user->userinfo->sex == '2')
                保密
              @elseif ($user->userinfo->sex == '1')
                男
              @else
                女
              @endif
            </td>
            <td>{{ $user->userinfo->city }}</td>
            <td>{{ $user->userinfo->integral }}</td>
            <td>{{ $user->userinfo->level }}</td>
            <td>{{ $user->userinfo->sign_num }}</td>
          </tr>
        <!-- 单条前台用户详情结束 -->
        </tbody>
      </table>
    </div>
  </body>
</html>