
{include file="public/header" /}

<!-- 主体内容 -->
<div class="layui-body" id="LAY_app_body">
    <div class="right">
        <div class="title">TKD标签</div>

		<div class="layui-form">
			{foreach name="btn" item="b" key="k"}
			<a class='layui-btn {if condition="$model eq $k"}layui-btn-warm{/if}' href="{:url('Seo/tkd', ['model' => $k])}">{$b}</a>
			{/foreach}
			<table class="layui-table">
				<colgroup>
					<col>
					<col>
					<col>
					<col>
					<col width="80">
				</colgroup>
				<thead>
					<tr>
						<th>页面</th>
						<th class="tc">标题</th>
						<th class="tc">关键词</th>
						<th class="tc">描述</th>
						<th class="tc">操作</th>
					</tr> 
				</thead>
				<tbody>
					{foreach name="list" item="v"}
						<tr>
							<td>
								{if condition="($model eq 'PageModel') or ($model eq 'ArticleModel')"}
									{$v.title}
								{else/}
									{$v.name}
								{/if}
							</td>
							<td class="tc">
								<div class="layui-input-inline w200">
									<input type="hidden" name="seo_id[]" value="{$v.id}">
									<input type="text" class="layui-input" name="seo_title[]" value="{$v.seo_title}">
								</div>
							</td>
							<td class="tc">
								<div class="layui-input-inline w200">
									<input type="text" class="layui-input" name="seo_keyword[]" value="{$v.seo_keyword}">
								</div>
							</td>
							<td class="tc">
								<div class="layui-input-inline w200">
									<textarea name="seo_description[]" class="layui-textarea mh40">{$v.seo_description}</textarea>
								</div>
							</td>
							<td class="tc">
								<button class="layui-btn layui-btn-normal layui-btn-sm"  data-id="{$v.id}" lay-submit lay-filter="formCoding">编辑</button>
							</td>
						</tr>
					{/foreach}
				</tbody>
			</table>
			{$list->render()}
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
			data.field.id = $(this).data('id');
			data.field.model = "{$model}";
		button.text('请稍候...');
		$.ajax({
			type:'POST',url:"{:url('tkd_edit')}",data:data.field,dataType:'json',
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
