<div class="layui-container fly-marginTop fly-user-main">
    <ul class="layui-nav layui-nav-tree layui-inline" lay-filter="user">
      <li class="layui-nav-item">
        <a href="/userinfo/{{ $user->id }}">
          <i class="layui-icon"></i>
          我的主页
        </a>
      </li>
      <li class="layui-nav-item">
        <a href="/userinfo/create/{{ $user->id }}">
          <i class="layui-icon"></i>
          用户中心
        </a>
      </li>
      <li class="layui-nav-item">
        <a href="/userinfo/show/{{ $user->id }}">
          <i class="layui-icon"></i>
          基本设置
        </a>
      </li>
      <li class="layui-nav-item">
        <a href="/userinfo/message/{{ $user->id }}">
          <i class="layui-icon"></i>
          我的消息
        </a>
      </li>
    </ul>