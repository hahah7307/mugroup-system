
{include file="public/header" /}

<!-- 主体内容 -->
<div class="layui-body" id="LAY_app_body">
    <div class="right">
		<a href="{:session('manage.back_url')}" class="layui-btn layui-btn-danger layui-btn-sm fr"><i class="layui-icon">&#xe603;</i>返回上一页</a>
		<div class="title">添加{$tag}</div>

		<div class="layui-form">
			<div class="layui-form-item">
				<label class="layui-form-label">图片</label>
				<div class="layui-input-inline w300">
					<input type="text" class="layui-input" name="pictures" style="display: none;">
					<span class="input-group-btn">
						<button type="button" name="pictures" class="layui-btn layui-btn-primary layui-btn-sm YanNanQiu_ViewsUploader">选择图片</button>
						<ul class="YanNanQiu-upload-list">
						</ul>
					</span>
				</div>
				<div class="red tips"></div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">广告标题</label>
				<div class="layui-input-inline w300">
					<input type="text" class="layui-input" name="title">
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">广告位分类</label>
				<div class="layui-input-block w300">
					<select name="block" lay-verify="required" lay-filter="block_id" id="block">
						{foreach name="banners" item="v" key="k"}
							<option value="{$k}">{$k|index_to_title}</option>
						{/foreach}
					</select>
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label"></label>
				<div class="layui-input-block w300">
					<select name="block_id" lay-verify="required" lay-filter="block" id="block_id">
					</select>
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">链接地址</label>
				<div class="layui-input-inline w300">
					<input type="text" class="layui-input" name="url">
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">链接方式</label>
				<div class="layui-input-block w300">
					<select name="link" lay-verify="required">
						<option value="1">内连接</option>
						<option value="2">外连接</option>
					</select>
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">内容</label>
				<div class="layui-input-block w300">
					<textarea name="content" placeholder="" class="layui-textarea"></textarea>
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
<script>
layui.use(['form', 'jquery'], function(){
	var $ = layui.jquery,
		form = layui.form;

	var block_index = $("select[name='block']").val();
	$.ajax({
		type:'POST',url:"{:url('get_template_banner')}",data:{"index":block_index},dataType:'json',
		success:function(data){
			if(data.code == 1){
				var html = "";
				for (var i = 0; i <= data.info.length - 1; i++) {
					data.info[i].title
					html += "<option value='" + data.info[i].id + "' title='" + data.info[i].tips + "'>" + data.info[i].title + "</option>";
				}
				$("#block_id").html(html);
				form.render('select');
				$("#block_id").siblings("div.layui-form-select").find('dl').find(".layui-this").click();
			}
		}
	});

	form.on('select(block_id)', function (data) {
		var index = data.value;
		$.ajax({
			type:'POST',url:"{:url('get_template_banner')}",data:{"index":index},dataType:'json',
			success:function(data){
				if(data.code == 1){
					var html = "";
					for (var i = 0; i <= data.info.length - 1; i++) {
						html += "<option value='" + data.info[i].id + "' title='" + data.info[i].tips + "'>" + data.info[i].title + "</option>";
					}
					$("#block_id").html(html);
					form.render('select');
					$("#block_id").siblings("div.layui-form-select").find('dl').find(".layui-this").click();
				}
			}
		});
		return false;
	});

	form.on('select(block)', function (data) {
		var tips = $(data.elem).find("option:selected").attr("title");
		$(".tips").html(tips);
		return false;
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
