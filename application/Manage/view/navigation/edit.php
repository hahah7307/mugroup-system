
{include file="public/header" /}

<!-- 主体内容 -->
<div class="layui-body" id="LAY_app_body">
    <div class="right">
		<a href="{:session('manage.back_url')}" class="layui-btn layui-btn-danger layui-btn-sm fr"><i class="layui-icon">&#xe603;</i>返回上一页</a>
		<div class="title">修改{$tag}</div>

		<div class="layui-form">
			<div class="layui-form-item">
				<label class="layui-form-label">上级导航</label>
				<div class="layui-input-block w300">
					<select name="pid" lay-verify="required">
						<option value="0">顶级导航</option>
						{foreach name="navis" item="v"}
							<option value="{$v.id}" {if condition="$v.id eq $info['pid']"}selected{/if}>{$v.navi_newname}</option>
						{/foreach}
					</select>
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">导航名称</label>
				<div class="layui-input-inline w300">
					<input type="text" class="layui-input" name="nav_name" value="{$info.nav_name}">
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">导航地址</label>
				<div class="layui-input-inline w300">
					<input type="text" class="layui-input" name="nav_url" value="{$info.nav_url}">
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">下拉</label>
				<div class="layui-input-block">
					<input type="radio" name="dropdown" value="1" title="开启" {if condition="$info.dropdown eq 1"}checked{/if}>
					<input type="radio" name="dropdown" value="0" title="关闭" {if condition="$info.dropdown eq 0"}checked{/if}>
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">新窗口</label>
				<div class="layui-input-block">
					<input type="radio" name="new_target" value="1" title="开启" {if condition="$info.new_target eq 1"}checked{/if}>
					<input type="radio" name="new_target" value="0" title="关闭" {if condition="$info.new_target eq 0"}checked{/if}>
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
