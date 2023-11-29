
{include file="public/header" /}

<!-- 主体内容 -->
<div class="layui-body" id="LAY_app_body">
    <div class="right">
		<a href="{:session('manage.back_url')}" class="layui-btn layui-btn-danger layui-btn-sm fr"><i class="layui-icon">&#xe603;</i>返回上一页</a>
		<div class="title">添加{$tag}</div>

		<div class="layui-form">
			<div class="layui-form-item">
				<label class="layui-form-label">文件</label>
				<div class="layui-input-inline w800">
					<button type="button" class="layui-btn" id="upload">
						<i class="layui-icon">&#xe67c;</i>文件上传
					</button>
					<input type="hidden" name="url">
					<span id="upload-url"></span>
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">类型</label>
				<div class="layui-input-inline w300">
					<input type="text" class="layui-input" name="suffix" id="suffix">
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">标题</label>
				<div class="layui-input-inline w300">
					<input type="text" class="layui-input" name="title">
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
				<label class="layui-form-label">描述</label>
				<div class="layui-input-inline w800">
					<textarea name="short" placeholder="" class="layui-textarea"></textarea>
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
<script>
layui.use(['form', 'jquery', 'upload'], function(){
	var $ = layui.jquery,
		form = layui.form,
		upload = layui.upload;

	//执行实例
	var uploadInst = upload.render({
		elem: '#upload' //绑定元素
		,url: "{:url('upload/file_upload')}" //上传接口
		,accept: 'file' //允许上传的文件类型
		,size: 10240 //最大允许上传的文件大小
		,exts: 'zip|rar|7z|jpg|gif|jpeg|png|mp4|avi|doc|docx|xls|xlsx|ppt|pptx|ico|pdf' // 允许上传的文件后缀
		,number: 1 // 设置同时可上传的文件数量
		,done: function(res){
			//上传完毕回调
			if (res.code == 1) {
				$("input[name='url']").val(res.data.src);
				$("#upload-url").html(res.data.src);
				$('#suffix').val(res.ext);
			}
		}
		,error: function(){
			//请求异常回调
		}
	});

	// 提交
	form.on('submit(formCoding)', function(data) {
		var text = $(this).text(),
			button = $(this);
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
