
{include file="public/header" /}

<!-- 主体内容 -->
<div class="layui-body" id="LAY_app_body">
    <div class="right">
		<a href="{:session('manage.back_url')}" class="layui-btn layui-btn-danger layui-btn-sm fr"><i class="layui-icon">&#xe603;</i>返回上一页</a>
		<div class="title">添加{$tag}</div>

		<div class="layui-form">
			<div class="layui-form-item">
				<label class="layui-form-label">名称</label>
				<div class="layui-input-inline w300">
					<input type="text" class="layui-input" name="name" value="{$info.name}">
				</div>
				<span class="layui-form-mid"></span>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">标识</label>
				<div class="layui-input-inline w300">
					<input type="text" class="layui-input" name="slug" value="{$info.slug}">
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">SEO标题</label>
				<div class="layui-input-inline w800">
					<input type="text" class="layui-input" name="seo_title" value="{$info.seo_title}">
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">SEO关键词</label>
				<div class="layui-input-inline w800">
					<input type="text" class="layui-input" name="seo_keyword" value="{$info.seo_keyword}">
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">SEO描述</label>
				<div class="layui-input-inline w800">
					<textarea name="seo_description" placeholder="" class="layui-textarea">{$info.seo_description}</textarea>
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">状态</label>
				<div class="layui-input-block">
					<input type="radio" name="status" value="1" title="开启" {if condition="$info.status eq 1"}checked{/if}>
					<input type="radio" name="status" value="0" title="关闭" {if condition="$info.status eq 0"}checked{/if}>
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
layui.use(['form', 'jquery'], function(){
	var $ = layui.jquery,
		form = layui.form;

	// 提交
	form.on('submit(formCoding)', function(data) {
		var text = $(this).text(),
			button = $(this);
		$('button').attr('disabled',true);
		button.text('请稍候...');
		$.ajax({
			type:'POST',url:"{:url('edit', ['id' => $info['id']])}",data:data.field,dataType:'json',
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
