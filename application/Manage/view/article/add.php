
{include file="public/header" /}

<!-- 主体内容 -->
<style type="text/css">
	#ul-info {padding-left:0; margin-bottom: 0}
</style>
<div class="layui-body" id="LAY_app_body">
    <div class="right">
		<a href="{:session('manage.back_url')}" class="layui-btn layui-btn-danger layui-btn-sm fr"><i class="layui-icon">&#xe603;</i>返回上一页</a>
		<div class="title">添加{$tag}</div>

		<div class="layui-form">
			<div class="layui-form-item">
				<label class="layui-form-label">封面图</label>
				<div class="layui-input-inline w300">
					<input type="text" class="layui-input" name="thumb" style="display: none;">
					<span class="input-group-btn">
						<button type="button" name="thumb" class="layui-btn layui-btn-primary layui-btn-sm YanNanQiu_ViewsUploader">选择图片</button>
						<ul class="YanNanQiu-upload-list">
						</ul>
					</span>
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">标题</label>
				<div class="layui-input-inline w300">
					<input type="text" class="layui-input" name="title">
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">标识</label>
				<div class="layui-input-inline w300">
					<input type="text" class="layui-input" name="slug">
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">外部链接</label>
				<div class="layui-input-inline w300">
					<input type="text" class="layui-input" name="url">
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">分类</label>
				<div class="layui-input-block w300">
					<select name="cid" lay-verify="required">
						{foreach name="category" item="v"}
							<option value="{$v.id}">{$v.name}</option>
						{/foreach}
					</select>
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">作者</label>
				<div class="layui-input-inline w300">
					<input type="text" class="layui-input" name="author">
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">概要</label>
				<div class="layui-input-inline w800">
					<textarea name="summary" placeholder="" class="layui-textarea"></textarea>
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
					<textarea id="mytextarea" name="content"></textarea>
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">SEO标题</label>
				<div class="layui-input-inline w800">
					<input type="text" class="layui-input" name="seo_title">
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">SEO关键词</label>
				<div class="layui-input-inline w800">
					<input type="text" class="layui-input" name="seo_keyword">
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">SEO描述</label>
				<div class="layui-input-inline w800">
					<textarea name="seo_description" placeholder="" class="layui-textarea"></textarea>
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">发布时间</label>
				<div class="layui-input-inline w300">
					<input type="text" class="layui-input time" name="created_at" value="{:date('Y-m-d H:i:s',time())}" placeholder="发布日期">
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">首页显示</label>
				<div class="layui-input-block">
					<input type="radio" name="show_home" value="1" title="是" checked>
					<input type="radio" name="show_home" value="0" title="否">
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">状态</label>
				<div class="layui-input-block">
					<input type="radio" name="status" value="1" title="开启" checked>
					<input type="radio" name="status" value="0" title="关闭">
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
        url: "{:url('Info/get_infos')}",
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
            url: "{:url('Info/get_info_content')}",
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
        plugins: "{$tinymce.plugins}",
        toolbar: "{$tinymce.toolbar}",
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
		data.field.content = tinyMCE.activeEditor.getContent();
		$('button').attr('disabled',true);
		button.text('请稍候...');
		$.ajax({
			type:'POST',url:"{:url('add')}",data:data.field,dataType:'json',
			success:function(data){
				if(data.code == 1){
					layer.alert(data.msg,{icon:1,closeBtn:0,title:false,btnAlign:'c'},function(){
						location.href = "{:url('index')}";
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

{include file="public/footer" /}
