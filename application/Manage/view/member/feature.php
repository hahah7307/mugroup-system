
{include file="public/header" /}

<!-- 主体内容 -->
<style type="text/css">
	#ul-info {padding-left:0; margin-bottom: 0}
</style>
<div class="layui-body" id="LAY_app_body">
    <div class="right">
		<a href="{:session('manage.back_url')}" class="layui-btn layui-btn-danger layui-btn-sm fr"><i class="layui-icon">&#xe603;</i>返回上一页</a>
		<div class="title">会员风采</div>

		<div class="layui-form">
			<div class="layui-form-item" id="info">
				<label class="layui-form-label">详情模板</label>
				<div class="">
					<ul class="YanNanQiu_TemplateImg" id="ul-info">
						<li class="YanNanQiu_TempCont_Active"><a href="javascript:;" ><img src="" alt=""></a></li>
					</ul>
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">会员风采</label>
				<div class="layui-input-inline tiny-mce-text w800">
					<textarea id="mytextarea" name="feature">{$info.feature}</textarea>
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
<script src='/static/manage/js/tinymce/js/tinymce/tinymce.min.js'></script>
<script>
layui.use(['form', 'jquery'], function(){
	var $ = layui.jquery,
		form = layui.form;

    $.ajax({
        type: 'POST',
        url: "{:url('Info/get_infos')}",
        data: {
            id: 4,
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
		data.field.feature = tinyMCE.activeEditor.getContent()
		$('button').attr('disabled',true);
		button.text('请稍候...');
		$.ajax({
			type:'POST',url:"{:url('feature', ['id' => $info['id']])}",data:data.field,dataType:'json',
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
