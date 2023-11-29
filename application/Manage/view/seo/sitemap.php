
{include file="public/header" /}

<!-- 主体内容 -->
<div class="layui-body" id="LAY_app_body">
    <div class="right">
        <div class="title">网站地图</div>

		<div class="layui-form">
			<div class="layui-form-item">
				<label class="layui-form-label">域名</label>
				<div class="layui-form-mid layui-word-aux w300">
					<span><a href="{$website.domain}">{$website.domain}</a></span>
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">网站地图</label>
				<div class="layui-form-mid layui-word-aux w300">
					<span><a href="{$website.sitemap}" target="_blank">{$website.sitemap}</a></span>
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">更新时间</label>
				<div class="layui-form-mid layui-word-aux w300">
					<span>{$atime}</span>
				</div>
			</div>
			<div class="layui-form-item">
				<div class="layui-input-block">
					<button class="layui-btn w200 button" lay-submit lay-filter="formCoding">更新网站地图</button>
				</div>
			</div>
		</div>

    </div>
</div>
<script>
layui.use(['form', 'jquery'], function(){
	var $ = layui.jquery,
		form = layui.form;

	// 更新
	form.on('submit(formCoding)', function(data) {
		var text = $(this).text(),
			button = $(this);
		$('button').attr('disabled',true);
		button.text('请稍候...');
		$.ajax({
			type:'POST',url:"{:url('sitemap')}",data:data.field,dataType:'json',
			success:function(data){
				if(data.code == 1){
					layer.alert(data.msg,{icon:1,closeBtn:0,title:false,btnAlign:'c'},function(){
						location.href = "{:url('sitemap')}";
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
