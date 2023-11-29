
{include file="public/header" /}

<!-- 主体内容 -->
<div class="layui-body" id="LAY_app_body">
    <div class="right">
		<a href="{:session('manage.back_url')}" class="layui-btn layui-btn-danger layui-btn-sm fr"><i class="layui-icon">&#xe603;</i>返回上一页</a>
		<div class="title">添加{$tag}</div>

		<div class="layui-form">
			<div class="layui-form-item">
				<label class="layui-form-label">头像</label>
				<div class="layui-input-inline w300">
					<input type="text" class="layui-input" name="image" style="display: none;">
					<span class="input-group-btn">
						<button type="button" name="image" class="layui-btn layui-btn-primary layui-btn-sm YanNanQiu_ViewsUploader">选择图片</button>
						<ul class="YanNanQiu-upload-list">
							{if condition="$info.image neq null"}
                            <li style="margin: 2px">
                                <img src="/upload/{$info.image}">
                                <span>
                                    <i class="fa fa-times"></i>
                                </span>
                                <input type="hidden" name="image[]" value="{$info.image}">
                            </li>
                            {/if}
						</ul>
					</span>
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">名称</label>
				<div class="layui-input-inline w300">
					<input type="text" class="layui-input" name="name" value="{$info.name}">
				</div>
				<span class="layui-form-mid"></span>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">分类</label>
				<div class="layui-input-block w300">
					<select name="type" lay-verify="required">
						<option value="">请选择</option>
						{foreach name="type" item="v" key="k"}
						<option value="{$k}" {if condition="$info.type eq $k"}selected{/if}>{$v}</option>
						{/foreach}
					</select>
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">账号</label>
				<div class="layui-input-inline w300">
					<input type="text" class="layui-input" name="account" value="{$info.account}">
				</div>
				<span class="layui-form-mid"></span>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">状态</label>
				<div class="layui-input-block">
					<input type="radio" name="status" value="1" title="开启" {if condition="$info.status eq 1"}checked{/if}>
					<input type="radio" name="status" value="0" title="关闭" {if condition="$info.status eq 2"}checked{/if}>
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
