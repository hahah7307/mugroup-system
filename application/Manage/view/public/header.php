<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>网站后台</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/static/layuiadmin/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/static/layuiadmin/style/admin.css" media="all">
    <link rel="stylesheet" href="/static/manage/css/manage.css" media="all">
    <link rel="stylesheet" href="/static/manage/css/common.css" media="all">
    <link rel="stylesheet" href="/static/manage/css/tab_style.css"/>
    <link rel="stylesheet" href="/static/manage/css/iconfont.css"/>
    <link rel="stylesheet" href="/static/fonts/font-awesome.min.css"/>
    <script src="/static/layuiadmin/layui/layui.js"></script>
    <script src="/static/manage/js/xm-select.js"></script>
</head>
<body class="layui-layout-body">
    <div id="LAY_app">
        <div class="layui-layout layui-layout-admin">
            <div class="layui-header">
                <!-- 头部区域 -->
                <ul class="layui-nav layui-layout-left">
                    <li class="layui-nav-item layadmin-flexible" lay-unselect>
                        <a href="javascript:;" layadmin-event="flexible" title="侧边伸缩">
                            <i class="layui-icon layui-icon-shrink-right" id="LAY_app_flexible"></i>
                        </a>
                    </li>
                    <li class="layui-nav-item layui-hide-xs" lay-unselect>
                        <a href="/" target="_blank" title="前台">
                            <i class="layui-icon layui-icon-website"></i>
                        </a>
                    </li>
                    <li class="layui-nav-item" lay-unselect>
                        <a href="" layadmin-event="refresh" title="刷新">
                            <i class="layui-icon layui-icon-refresh-3"></i>
                        </a>
                    </li>
                    <!-- <li class="layui-nav-item layui-hide-xs" lay-unselect>
                    <input type="text" placeholder="搜索..." autocomplete="off" class="layui-input layui-input-search" layadmin-event="serach" lay-action="template/search.html?keywords="> 
                    </li> -->
                </ul>
                <ul class="layui-nav layui-layout-right" lay-filter="layadmin-layout-right">
                   <!--  <li class="layui-nav-item" lay-unselect>
                        <a href="{:url('Inquiry/index')}" layadmin-event="message" lay-text="消息中心">
                            <i class="layui-icon layui-icon-notice"></i>   -->
                            <!-- 如果有新消息，则显示小圆点 -->
                    <!--         <span class="layui-badge-dot"></span>
                        </a>
                    </li> -->
                    <li class="layui-nav-item layui-hide-xs" lay-unselect>
                        <a href="javascript:;" layadmin-event="theme">
                            <i class="layui-icon layui-icon-theme"></i>
                        </a>
                    </li>
                    <li class="layui-nav-item layui-hide-xs" lay-unselect>
                        <a href="javascript:;" layadmin-event="note">
                            <i class="layui-icon layui-icon-note"></i>
                        </a>
                    </li>
                    <!--  <li class="layui-nav-item layui-hide-xs" lay-unselect>
                    <a href="javascript:;" layadmin-event="fullscreen">
                    <i class="layui-icon layui-icon-screen-full"></i>
                    </a>
                    </li> -->
                    <li class="layui-nav-item" lay-unselect>
                        <a href="javascript:;">
                            <i class="layui-icon iconfont icon-{$language.abbreviation}" style="font-size: 20px"></i>  
                        </a>
                        <dl class="layui-nav-child">
                            {foreach name="languages" item="lang"}
                            <dd><a href="{:url('Language/change_default',['id' => $lang['id']])}">{$lang.abbreviation}</a></dd>
                            {/foreach}
                        </dl>
                    </li>
                    <li class="layui-nav-item" lay-unselect style="margin-right: 10px; width: 100px">
                        <a href="javascript:;">
                            <cite>{$user.nickname}</cite>
                        </a>
                        <dl class="layui-nav-child">
                            <dd><a href="{:url('Site/admin')}">基本资料</a></dd>
                            <dd><a href="{:url('Site/repass')}">修改密码</a></dd>
                            <hr>
                            <dd style="text-align: center;"><a href="{:url('Login/logout')}">退出</a></dd>
                        </dl>
                    </li>
                </ul>
            </div>

      {include file="public/left" /}

      