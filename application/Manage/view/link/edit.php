
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
							{if condition="$info.pictures neq null"}
                            <li style="margin: 2px">
                                <img src="/upload/{$info.pictures}">
                                <span>
                                    <i class="fa fa-times"></i>
                                </span>
                                <input type="hidden" name="pictures[]" value="{$info.pictures}">
                            </li>
                            {/if}
						</ul>
					</span>
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">链接名称</label>
				<div class="layui-input-inline w300">
					<input type="text" class="layui-input" name="link_name" value="{$info.link_name}">
				</div>
				<span class="layui-form-mid"></span>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">链接地址</label>
				<div class="layui-input-inline w300">
					<input type="text" class="layui-input" name="link_url" value="{$info.link_url}">
				</div>
				<span class="layui-form-mid"></span>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">分类</label>
				<div class="layui-input-block w300">
					<select name="type" lay-verify="required">
						{foreach name="category" item="v"}
							<option value="{$v.id}" {if condition="$info.type eq $v['id']"}selected{/if}>{$v.name}</option>
						{/foreach}
					</select>
				</div>
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
