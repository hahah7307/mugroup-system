<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:97:"/Users/hahah./Documents/wwwroot/hardware-tools/public/../application/Manage/view/article/edit.php";i:1607915060;s:88:"/Users/hahah./Documents/wwwroot/hardware-tools/application/Manage/view/public/header.php";i:1606889687;s:86:"/Users/hahah./Documents/wwwroot/hardware-tools/application/Manage/view/public/left.php";i:1607326502;s:88:"/Users/hahah./Documents/wwwroot/hardware-tools/application/Manage/view/public/footer.php";i:1599103444;}*/ ?>

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
                        <a href="<?php echo url('Inquiry/index'); ?>" layadmin-event="message" lay-text="消息中心">
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
                            <i class="layui-icon iconfont icon-<?php echo $language['abbreviation']; ?>" style="font-size: 20px"></i>  
                        </a>
                        <dl class="layui-nav-child">
                            <?php if(is_array($languages) || $languages instanceof \think\Collection || $languages instanceof \think\Paginator): if( count($languages)==0 ) : echo "" ;else: foreach($languages as $key=>$lang): ?>
                            <dd><a href="<?php echo url('Language/change_default',['id' => $lang['id']]); ?>"><?php echo $lang['abbreviation']; ?></a></dd>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </dl>
                    </li>
                    <li class="layui-nav-item" lay-unselect style="margin-right: 10px; width: 100px">
                        <a href="javascript:;">
                            <cite><?php echo $user['nickname']; ?></cite>
                        </a>
                        <dl class="layui-nav-child">
                            <dd><a href="<?php echo url('Site/admin'); ?>">基本资料</a></dd>
                            <dd><a href="<?php echo url('Site/repass'); ?>">修改密码</a></dd>
                            <hr>
                            <dd style="text-align: center;"><a href="<?php echo url('Login/logout'); ?>">退出</a></dd>
                        </dl>
                    </li>
                </ul>
            </div>

      
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
                        <dd><a layui-href="<?php echo url('Member/index'); ?>">会员管理</a></dd>
                        <dd><a layui-href="<?php echo url('MemberRank/index'); ?>">会员职位</a></dd>
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
                                <dd><a layui-href="<?php echo url('Page/index'); ?>">列表</a></dd>
                                <dd><a layui-href="<?php echo url('PageCategory/index'); ?>">分类</a></dd>
                            </dl>
                        </dd>
                        <dd data-name="article">
                            <a layui-href="javascript:;">公告管理</a>
                            <dl class="layui-nav-child">
                                <dd><a layui-href="<?php echo url('Notice/index'); ?>">列表</a></dd>
                                <dd><a layui-href="<?php echo url('NoticeCategory/index'); ?>">分类</a></dd>
                            </dl>
                        </dd>
                        <dd data-name="article">
                            <a layui-href="javascript:;">文章管理</a>
                            <dl class="layui-nav-child">
                                <dd><a layui-href="<?php echo url('Article/index'); ?>">列表</a></dd>
                                <dd><a layui-href="<?php echo url('ArticleCategory/index'); ?>">分类</a></dd>
                            </dl>
                        </dd>
                        <dd data-name="download">
                            <a layui-href="javascript:;">下载管理</a>
                            <dl class="layui-nav-child">
                                <dd><a layui-href="<?php echo url('Download/index'); ?>">列表</a></dd>
                                <dd><a layui-href="<?php echo url('DownloadCategory/index'); ?>">分类</a></dd>
                            </dl>
                        </dd>
                        <dd data-name="link">
                            <a layui-href="javascript:;">友情链接</a>
                            <dl class="layui-nav-child">
                                <dd><a layui-href="<?php echo url('Link/index'); ?>">列表</a></dd>
                                <dd><a layui-href="<?php echo url('LinkCategory/index'); ?>">分类</a></dd>
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
                        <dd><a layui-href="<?php echo url('Seo/tkd'); ?>">TKD标签</a></dd>
                        <dd><a layui-href="<?php echo url('Seo/sitemap'); ?>">网站地图</a></dd>
                    </dl>
                </li>
                <li data-name="Visit" class="layui-nav-item">
                    <a layui-href="javascript:;" lay-tips="高级" lay-direction="2">
                        <i class="layui-icon iconfont icon-tongji1"></i>
                        <cite>统计</cite>
                    </a>
                    <dl class="layui-nav-child">
                        <dd><a layui-href="<?php echo url('Visit/index'); ?>">访客统计</a></dd>
                        <dd><a layui-href="<?php echo url('Visit/area'); ?>">地域统计</a></dd>
                        <dd><a layui-href="<?php echo url('Visit/source'); ?>">来源统计</a></dd>
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
                                <dd><a layui-href="<?php echo url('Image/index'); ?>">列表</a></dd>
                                <dd><a layui-href="<?php echo url('ImageCategory/index'); ?>">分类</a></dd>
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
                        <dd><a layui-href="<?php echo url('Site/web_params'); ?>">网站设置</a></dd>
                        <dd><a layui-href="<?php echo url('Param/web'); ?>">参数设置</a></dd>
                        <!-- <dd><a layui-href="<?php echo url('Language/index'); ?>">语言设置</a></dd> -->
                        <!-- <dd><a layui-href="<?php echo url('AppTemplate/index'); ?>">模板设置</a></dd> -->
                        <dd><a layui-href="<?php echo url('BlockChild/index'); ?>">广告设置</a></dd>
                        <dd><a layui-href="<?php echo url('Navigation/index'); ?>">导航设置</a></dd>
                        <!-- <dd><a layui-href="<?php echo url('Service/index'); ?>">客服设置</a></dd> -->
                        <!-- <dd><a layui-href="<?php echo url('Mail/index'); ?>">邮件设置</a></dd> -->
                        <?php if($user['super'] == 1): ?>
                        <dd data-name="info">
                            <a layui-href="javascript:;">管理设置</a>
                            <dl class="layui-nav-child">
                                <dd><a layui-href="<?php echo url('Admin/index'); ?>">管理员</a></dd>
                                <dd><a layui-href="<?php echo url('Admin/role'); ?>">角色</a></dd>
                                <?php if($user['manage'] == 1): ?>
                                <dd><a layui-href="<?php echo url('Admin/node'); ?>">节点</a></dd>
                                <?php endif; ?>
                            </dl>
                        </dd>
                        <?php endif; ?>
                    </dl>
                </li>
                <?php if($user['manage'] == 1): ?>
                <li data-name="Manage" class="layui-nav-item">
                    <a layui-href="javascript:;" lay-tips="管理" lay-direction="2">
                        <i class="layui-icon layui-icon-template-1"></i>
                        <cite>管理</cite>
                    </a>
                    <dl class="layui-nav-child">
                        <dd><a layui-href="<?php echo url('Language/manage'); ?>">语言管理</a></dd>
                        <dd><a layui-href="<?php echo url('AppTemplate/manage'); ?>">模板管理</a></dd>
                        <dd data-name="info">
                            <a layui-href="javascript:;">详情管理</a>
                            <dl class="layui-nav-child">
                                <dd><a layui-href="<?php echo url('Info/index'); ?>">列表</a></dd>
                                <dd><a layui-href="<?php echo url('InfoCategory/index'); ?>">分类</a></dd>
                            </dl>
                        </dd>
                        <dd><a layui-href="<?php echo url('Block/index'); ?>">广告位管理</a></dd>
                    </dl>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
    <script type="text/javascript">
    layui.use(['jquery'], function(){
        var $ = layui.jquery;

        if ('<?php echo $userMenu; ?>') {
            $("#layui-side-menu").html('<?php echo $userMenu; ?>');
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
                type:'POST',url:"<?php echo url('Index/initMenu'); ?>",data:{"info": html},dataType:'json',
                success:function(data){
                    if(data.code == 1){
                        location.href = href;
                    }
                }
            });
        });
    });
    </script>


      

<!-- 主体内容 -->
<div class="layui-body" id="LAY_app_body">
    <div class="right">
		<a href="<?php echo session('manage.back_url'); ?>" class="layui-btn layui-btn-danger layui-btn-sm fr"><i class="layui-icon">&#xe603;</i>返回上一页</a>
		<div class="title">编辑<?php echo $tag; ?></div>

		<div class="layui-form">
			<div class="layui-form-item">
				<label class="layui-form-label">封面图</label>
				<div class="layui-input-inline w300">
					<input type="text" class="layui-input" name="thumb" style="display: none;">
					<span class="input-group-btn">
						<button type="button" name="thumb" class="layui-btn layui-btn-primary layui-btn-sm YanNanQiu_ViewsUploader">选择图片</button>
						<ul class="YanNanQiu-upload-list">
						<?php if($info['thumb'] != null): ?>
							<li style="margin: 2px">
								<img src="/upload/<?php echo $info['thumb']; ?>">
								<span>
									<i class="fa fa-times"></i>
								</span>
								<input type="hidden" name="thumb[]" value="<?php echo $info['thumb']; ?>">
							</li>
						<?php endif; ?>
						</ul>
					</span>
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">标题</label>
				<div class="layui-input-inline w300">
					<input type="text" class="layui-input" name="title" value="<?php echo $info['title']; ?>">
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">标识</label>
				<div class="layui-input-inline w300">
					<input type="text" class="layui-input" name="slug" value="<?php echo $info['slug']; ?>">
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">外部链接</label>
				<div class="layui-input-inline w300">
					<input type="text" class="layui-input" name="url" value="<?php echo $info['url']; ?>">
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">分类</label>
				<div class="layui-input-block w300">
					<select name="cid" lay-verify="required">
						<?php if(is_array($category) || $category instanceof \think\Collection || $category instanceof \think\Paginator): if( count($category)==0 ) : echo "" ;else: foreach($category as $key=>$v): ?>
							<option value="<?php echo $v['id']; ?>" <?php if($v['id'] == $info['cid']): ?>selected<?php endif; ?>><?php echo $v['name']; ?></option>
						<?php endforeach; endif; else: echo "" ;endif; ?>
					</select>
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">作者</label>
				<div class="layui-input-inline w300">
					<input type="text" class="layui-input" name="author" value="<?php echo $info['author']; ?>">
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">概要</label>
				<div class="layui-input-inline w800">
					<textarea name="summary" placeholder="" class="layui-textarea"><?php echo $info['summary']; ?></textarea>
				</div>
			</div>
			<div class="layui-form-item" id="info">
				<label class="layui-form-label">详情模板</label>
				<div class="">
					<ul class="YanNanQiu_TemplateImg" id="ul-info">
						<li class="YanNanQiu_TempCont_Active"><a href="javascript:;" ><img src="" alt=""></a></li>
					</ul>
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">内容</label>
				<div class="layui-input-inline tiny-mce-text w800">
					<textarea id="mytextarea" name="content"><?php echo $info['content']; ?></textarea>
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">SEO标题</label>
				<div class="layui-input-inline w800">
					<input type="text" class="layui-input" name="seo_title" value="<?php echo $info['seo_title']; ?>">
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">SEO关键词</label>
				<div class="layui-input-inline w800">
					<input type="text" class="layui-input" name="seo_keyword" value="<?php echo $info['seo_keyword']; ?>">
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">SEO描述</label>
				<div class="layui-input-inline w800">
					<textarea name="seo_description" placeholder="" class="layui-textarea"><?php echo $info['seo_description']; ?></textarea>
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">发布时间</label>
				<div class="layui-input-inline w300">
					<input type="text" class="layui-input time" name="created_at" value="<?php echo date('Y-m-d H:i:s',$info['created_at']); ?>" placeholder="发布日期">
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">首页显示</label>
				<div class="layui-input-block">
					<input type="radio" name="show_home" value="1" title="是" <?php if($info['show_home'] == 1): ?>checked<?php endif; ?>>
					<input type="radio" name="show_home" value="0" title="否" <?php if($info['show_home'] == 0): ?>checked<?php endif; ?>>
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">状态</label>
				<div class="layui-input-block">
					<input type="radio" name="status" value="1" title="开启" <?php if($info['status'] == 1): ?>checked<?php endif; ?>>
					<input type="radio" name="status" value="0" title="关闭" <?php if($info['status'] == 0): ?>checked<?php endif; ?>>
				</div>
			</div>
			<div class="layui-form-item">
				<div class="layui-input-block">
					<button class="layui-btn w200 button" lay-submit lay-filter="formCoding">提交保存</button>
				</div>
			</div>
		</div>

    </div>
</div>
<script src="/static/manage/js/uploader-use.js"></script>
<script src='/static/manage/js/tinymce/js/tinymce/tinymce.min.js'></script>
<script>
layui.use(['form', 'jquery', 'laydate'], function(){
	var $ = layui.jquery,
		form = layui.form,
		laydate = layui.laydate;

	lay('.time').each(function(){
		laydate.render({
			elem: this,
			type: 'datetime',
		});
	});

    $.ajax({
        type: 'POST',
        url: "<?php echo url('Info/get_infos'); ?>",
        data: {
            id: 3,
        },
        success: function(res) {
            var str = '';
            if(res.code == 1) {
                for(i = 0; i <= res.info.length - 1; i++) {
                    str += '<li class="li-info" data-id="' + res.info[i].id + '"><img src="/upload' + res.info[i].pic + '" alt=""></li>';
                }
            } else {
            	$("#info").addClass('display');
            }
            $("#ul-info").html(str);
        }
    });

    $("#ul-info").on("click","li",function(){
        var infoId = $(this).data('id');
        var content = tinyMCE.activeEditor.getContent();
        $.ajax({
            type: 'POST',
            url: "<?php echo url('Info/get_info_content'); ?>",
            data: {
                id: infoId,
            },
            success: function(res) {
                if(res.code == 1){
                    var info = $("<div>").html(res.info).text();
                    tinyMCE.activeEditor.setContent(content + info + '<div style="clear: both"></div>');
                }
            }
        });
    });

    tinymce.init({
        selector: '#mytextarea',
        language:'zh_CN',
        width: "100%", //编辑器宽度
        height: 400, //编辑器高度
        menubar: false,
        branding: false,
        image_advtab: true,
        image_title: true, // 是否开启图片标题设置的选择，这里设置否
        plugins: "<?php echo $tinymce['plugins']; ?>",
        toolbar: "<?php echo $tinymce['toolbar']; ?>",
        toolbar_mode : 'wrap',
        images_upload_base_path: '/statics/tinyMCE/images',
        images_upload_handler: function (blobInfo, succFun, failFun) {
            $.ajax({
                url:"/Manage/Upload/upload",
                type:'post',
                data:{info:blobInfo.base64()},
                dataType: 'json',
                async: false,
                success:function(res){
                    if (res.code == 1) {
                        succFun(res.info);
                    } else {
                        failFun(res.info);
                    }
            }});
        },
    }).then();

	// 提交
	form.on('submit(formCoding)', function(data) {
		var text = $(this).text(),
			button = $(this);
		data.field.content = tinyMCE.activeEditor.getContent()
		$('button').attr('disabled',true);
		button.text('请稍候...');
		$.ajax({
			type:'POST',url:"<?php echo url('edit', ['id' => $info['id']]); ?>",data:data.field,dataType:'json',
			success:function(data){
				if(data.code == 1){
					layer.alert(data.msg,{icon:1,closeBtn:0,title:false,btnAlign:'c'},function(){
						location.href = "<?php echo url('index'); ?>";
					});
				}else{
					layer.alert(data.msg,{icon:2,closeBtn:0,title:false,btnAlign:'c'},function(){
						layer.closeAll();
						$('button').attr('disabled',false);
						button.text(text);
					});
				}
			}
		});
		return false;
	});

});
</script>


                <!-- 辅助元素，一般用于移动设备下遮罩 -->
                <div class="layadmin-body-shade" layadmin-event="shade"></div>
            </div>
        </div>

        <script>
            layui.config({
                base: '/static/layuiadmin/' //静态资源所在路径
            }).extend({
                index: 'lib/index' //主入口模块
            }).use('index');
        </script>
    </body>
</html>



