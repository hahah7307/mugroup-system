
{include file="public/header" /}

<!-- 主体内容 -->
<div class="layui-body" id="LAY_app_body">
    <div class="right">
		<a href="{:session('manage.back_url')}" class="layui-btn layui-btn-danger layui-btn-sm fr"><i class="layui-icon">&#xe603;</i>返回上一页</a>
		<div class="title">添加{$tag}</div>

		<div class="layui-form">
			<div class="layui-form-item">
				<label class="layui-form-label">广告位名称</label>
				<div class="layui-input-inline w300">
					<input type="text" class="layui-input" name="title" value="{$info.title}">
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">类型</label>
				<div class="layui-input-block w300">
					<select name="type" lay-verify="required">
						{foreach name="type" item="va" key="ka"}
							<option value="{$ka}" {if condition="$info.type eq $ka"}selected{/if}>{$va}</option>
						{/foreach}
					</select>
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">模块标识</label>
				<div class="layui-input-block w300">
					<select name="block_code" lay-verify="required">
						{foreach name="block_index" item="v" key="k"}
							<option value="{$k}" {if condition="$info.block_code eq $k"}selected{/if}>{$v.title}</option>
						{/foreach}
					</select>
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">前台标识</label>
				<div class="layui-input-inline w300">
					<input type="text" class="layui-input" name="index_code" value="{$info.index_code}">
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">展示条目数</label>
				<div class="layui-input-inline w300">
					<input type="text" class="layui-input" name="number" value="{$info.number}">
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">内容</label>
				<div class="layui-input-block w300">
					<textarea name="content" placeholder="" class="layui-textarea">{$info.content}</textarea>
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">状态</label>
				<div class="layui-input-block">
					<input type="radio" name="status" value="1" title="开启" {if condition="$info.status eq 1"}selected{/if}>
					<input type="radio" name="status" value="0" title="关闭" {if condition="$info.status eq 0"}selected{/if}>
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
						location.reload();
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
