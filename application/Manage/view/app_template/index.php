
{include file="public/header" /}

<!-- 主体内容 -->
<div class="layui-body" id="LAY_app_body">
    <div class="right">
        <div class="title">模板设置</div>

		<div class="layui-form">
			<table class="layui-table">
				<colgroup>
					<col width="80">
					<col>
					<col>
					<col width="120">
				</colgroup>
				<thead>
					<tr>
						<th>预览图</th>
						<th>模板名称</th>
						<th>模板标识</th>
						<th class="tc">操作</th>
					</tr> 
				</thead>
				<tbody>
					{foreach name="list" item="v"}
						<tr>
							<td><img src="{:imageurl_to_path($v['pic'])}" height="80"></td>
							<td>{$v.mark}</td>
							<td>{$v.title}</td>
							<td class="tc">
								{if condition="$v.current eq 1"}
									<button type="button" class="layui-btn layui-btn-sm layui-btn-danger">默认模板</button>
								{else/}
									<button data-id="{$v.id}" class="layui-btn layui-btn-sm layui-btn-normal" lay-submit lay-filter="Default">设为默认</button>
								{/if}
							</td>
						</tr>
					{/foreach}
				</tbody>
			</table>
		</div>

    </div>
</div>
<script>
layui.use(['form', 'jquery'], function(){
	var $ = layui.jquery,
		form = layui.form;

	// 删除
	form.on('submit(Default)', function(data){
		var text = $(this).text(),
			button = $(this),
			id = $(this).data('id');
		layer.confirm('确定设为默认模板吗？',{icon:3,closeBtn:0,title:false,btnAlign:'c'},function(){
			$('button').attr('disabled',true);
			button.text('请稍候...');
			$.ajax({
				type:'POST',url:"{:url('set_default')}",data:{id:id},dataType:'json',
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
		});
	});
});
</script>

{include file="public/footer" /}
