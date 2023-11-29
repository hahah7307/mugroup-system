
    <!-- 侧边菜单 -->
    <div class="layui-side layui-side-menu" id="layui-side-menu">
        <div class="layui-side-scroll">
            <a class="layui-logo" layui-href="/Manage">
                <span><img src="/static/images/logo.png" height="40"></span>
            </a>
          
            <ul class="layui-nav layui-nav-tree" lay-shrink="all" id="LAY-system-side-menu" lay-filter="layadmin-system-side-menu">
                <li data-name="Home" class="layui-nav-item layui-nav-itemed">
                    <a layui-href="/Manage/Index/index.html" lay-tips="控制台" lay-direction="2">
                        <i class="layui-icon layui-icon-home"></i>
                        <cite>控制台</cite>
                    </a>
                </li>
                <li data-name="Member" class="layui-nav-item">
                    <a layui-href="javascript:;" lay-tips="会员" lay-direction="2">
                        <i class="layui-icon iconfont icon-chanpin"></i>
                        <cite>会员</cite>
                    </a>
                    <dl class="layui-nav-child">
                        <dd><a layui-href="{:url('Member/index')}">会员管理</a></dd>
                        <dd><a layui-href="{:url('MemberRank/index')}">会员职位</a></dd>
                    </dl>
                </li>
                <li data-name="Content" class="layui-nav-item">
                    <a layui-href="javascript:;" lay-tips="内容" lay-direction="2">
                        <i class="layui-icon iconfont icon-neirong"></i>
                        <cite>内容</cite>
                    </a>
                    <dl class="layui-nav-child">
                        <dd data-name="page">
                            <a layui-href="javascript:;">单页管理</a>
                            <dl class="layui-nav-child">
                                <dd><a layui-href="{:url('Page/index')}">列表</a></dd>
                                <dd><a layui-href="{:url('PageCategory/index')}">分类</a></dd>
                            </dl>
                        </dd>
                        <dd data-name="article">
                            <a layui-href="javascript:;">公告管理</a>
                            <dl class="layui-nav-child">
                                <dd><a layui-href="{:url('Notice/index')}">列表</a></dd>
                                <dd><a layui-href="{:url('NoticeCategory/index')}">分类</a></dd>
                            </dl>
                        </dd>
                        <dd data-name="article">
                            <a layui-href="javascript:;">文章管理</a>
                            <dl class="layui-nav-child">
                                <dd><a layui-href="{:url('Article/index')}">列表</a></dd>
                                <dd><a layui-href="{:url('ArticleCategory/index')}">分类</a></dd>
                            </dl>
                        </dd>
                        <dd data-name="download">
                            <a layui-href="javascript:;">下载管理</a>
                            <dl class="layui-nav-child">
                                <dd><a layui-href="{:url('Download/index')}">列表</a></dd>
                                <dd><a layui-href="{:url('DownloadCategory/index')}">分类</a></dd>
                            </dl>
                        </dd>
                        <dd data-name="link">
                            <a layui-href="javascript:;">友情链接</a>
                            <dl class="layui-nav-child">
                                <dd><a layui-href="{:url('Link/index')}">列表</a></dd>
                                <dd><a layui-href="{:url('LinkCategory/index')}">分类</a></dd>
                            </dl>
                        </dd>
                    </dl>
                </li>
                <li data-name="Seo" class="layui-nav-item">
                    <a layui-href="javascript:;" lay-tips="SEO" lay-direction="2">
                        <i class="layui-icon iconfont icon-seo1"></i>
                        <cite>SEO</cite>
                    </a>
                    <dl class="layui-nav-child">
                        <dd><a layui-href="{:url('Seo/tkd')}">TKD标签</a></dd>
                        <dd><a layui-href="{:url('Seo/sitemap')}">网站地图</a></dd>
                    </dl>
                </li>
                <li data-name="Visit" class="layui-nav-item">
                    <a layui-href="javascript:;" lay-tips="高级" lay-direction="2">
                        <i class="layui-icon iconfont icon-tongji1"></i>
                        <cite>统计</cite>
                    </a>
                    <dl class="layui-nav-child">
                        <dd><a layui-href="{:url('Visit/index')}">访客统计</a></dd>
                        <dd><a layui-href="{:url('Visit/area')}">地域统计</a></dd>
                        <dd><a layui-href="{:url('Visit/source')}">来源统计</a></dd>
                    </dl>
                </li>
                <li data-name="Image" class="layui-nav-item">
                    <a layui-href="javascript:;" lay-tips="高级" lay-direction="2">
                        <i class="layui-icon iconfont icon-icon"></i>
                        <cite>辅助</cite>
                    </a>
                    <dl class="layui-nav-child">
                        <dd data-name="image">
                            <a layui-href="javascript:;">图册管理</a>
                            <dl class="layui-nav-child">
                                <dd><a layui-href="{:url('Image/index')}">列表</a></dd>
                                <dd><a layui-href="{:url('ImageCategory/index')}">分类</a></dd>
                            </dl>
                        </dd>
                    </dl>
                </li>
                <li data-name="Site" class="layui-nav-item">
                    <a layui-href="javascript:;" lay-tips="设置" lay-direction="2">
                        <i class="layui-icon layui-icon-set"></i>
                        <cite>设置</cite>
                    </a>
                    <dl class="layui-nav-child">
                        <dd><a layui-href="{:url('Site/web_params')}">网站设置</a></dd>
                        <dd><a layui-href="{:url('Param/web')}">参数设置</a></dd>
                        <!-- <dd><a layui-href="{:url('Language/index')}">语言设置</a></dd> -->
                        <!-- <dd><a layui-href="{:url('AppTemplate/index')}">模板设置</a></dd> -->
                        <dd><a layui-href="{:url('BlockChild/index')}">广告设置</a></dd>
                        <dd><a layui-href="{:url('Navigation/index')}">导航设置</a></dd>
                        <!-- <dd><a layui-href="{:url('Service/index')}">客服设置</a></dd> -->
                        <!-- <dd><a layui-href="{:url('Mail/index')}">邮件设置</a></dd> -->
                        {if condition="$user.super eq 1"}
                        <dd data-name="info">
                            <a layui-href="javascript:;">管理设置</a>
                            <dl class="layui-nav-child">
                                <dd><a layui-href="{:url('Admin/index')}">管理员</a></dd>
                                <dd><a layui-href="{:url('Admin/role')}">角色</a></dd>
                                {if condition="$user.manage eq 1"}
                                <dd><a layui-href="{:url('Admin/node')}">节点</a></dd>
                                {/if}
                            </dl>
                        </dd>
                        {/if}
                    </dl>
                </li>
                {if condition="$user.manage eq 1"}
                <li data-name="Manage" class="layui-nav-item">
                    <a layui-href="javascript:;" lay-tips="管理" lay-direction="2">
                        <i class="layui-icon layui-icon-template-1"></i>
                        <cite>管理</cite>
                    </a>
                    <dl class="layui-nav-child">
                        <dd><a layui-href="{:url('Language/manage')}">语言管理</a></dd>
                        <dd><a layui-href="{:url('AppTemplate/manage')}">模板管理</a></dd>
                        <dd data-name="info">
                            <a layui-href="javascript:;">详情管理</a>
                            <dl class="layui-nav-child">
                                <dd><a layui-href="{:url('Info/index')}">列表</a></dd>
                                <dd><a layui-href="{:url('InfoCategory/index')}">分类</a></dd>
                            </dl>
                        </dd>
                        <dd><a layui-href="{:url('Block/index')}">广告位管理</a></dd>
                    </dl>
                </li>
                {/if}
            </ul>
        </div>
    </div>
    <script type="text/javascript">
    layui.use(['jquery'], function(){
        var $ = layui.jquery;

        if ('{$userMenu}') {
            $("#layui-side-menu").html('{$userMenu}');
            $(".layui-nav-bar").remove();
        }

        $("#layui-side-menu a").click(function(){
            $('dd').removeClass('layui-this');
            if ($(this).attr('layui-href') != 'javascript:;') {
                $(this).parent('dd').addClass('layui-this');
            }
            var html = $("#layui-side-menu").html(),
                href = $(this).attr('layui-href');

            $.ajax({
                type:'POST',url:"{:url('Index/initMenu')}",data:{"info": html},dataType:'json',
                success:function(data){
                    if(data.code == 1){
                        location.href = href;
                    }
                }
            });
        });
    });
    </script>
