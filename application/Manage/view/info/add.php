
{include file="public/header" /}

<!-- 主体内容 -->
<div class="layui-body" id="LAY_app_body">
    <div class="right">
		<a href="{:session('manage.back_url')}" class="layui-btn layui-btn-danger layui-btn-sm fr"><i class="layui-icon">&#xe603;</i>返回上一页</a>
		<div class="title">添加{$tag}</div>

		<div class="layui-form">
			<div class="layui-form-item">
				<label class="layui-form-label">预览图</label>
				<div class="layui-input-inline w300">
					<input type="text" class="layui-input" name="pic" style="display: none;">
					<span class="input-group-btn">
						<button type="button" name="pic" class="layui-btn layui-btn-primary layui-btn-sm YanNanQiu_ViewsUploader">选择图片</button>
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
				<span class="layui-form-mid"></span>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">分类</label>
				<div class="layui-input-inline w300">
					<input type="hidden" name="cid">
					<div id="category" class="xm-select-demo"></div>
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">内容</label>
				<div class="layui-input-inline w800">
            		<textarea id="mytextarea" name="content"></textarea>
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
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src='/static/manage/js/tinymce/js/tinymce/tinymce.min.js'></script>
<script>
layui.use(['form', 'jquery'], function(){
	var $ = layui.jquery,
		form = layui.form;

    // 下拉框多选
    var cid = xmSelect.render({
        el: '#category',
        name: 'cid',
        layVerify: 'required',
        filterable: true,
        remoteSearch: true,
        remoteMethod: function(val, cb, show){
            axios({
                method: 'post',
                url: '/Manage/Check/get_full_infoCategory',
                data:'',
                params: {
                    keyword: val,
                }
            }).then(response => {
                var res = response.data;
                cb(res.data)
            }).catch(err => {
                cb([]);
            });
        },
        data: []
    })

    tinymce.init({
        selector: '#mytextarea',
        language:'zh_CN',
        width: "100%", //编辑器宽度
        height: 400, //编辑器高度
        menubar: false,
        branding: false,
        convert_urls: false,
        image_advtab: true,
        image_title: true, // 是否开启图片标题设置的选择，这里设置否
        plugins: "{$tinymce.plugins}",
        toolbar: "{$tinymce.toolbar}",
        toolbar_mode : 'wrap',
        images_upload_base_path: '/upload/tinyMCE/images',
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
