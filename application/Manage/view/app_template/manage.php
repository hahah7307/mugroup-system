
{include file="public/header" /}

<!-- 主体内容 -->
<div class="layui-body" id="LAY_app_body">
    <div class="right">
        <div class="title">模板管理</div>

		<div class="layui-form">
			<a class="layui-btn" href="{:url('add')}">添加</a>
			<table class="layui-table">
				<colgroup>
					<col width="80">
					<col>
					<col>
					<col width="80">
					<col width="150">
				</colgroup>
				<thead>
					<tr>
						<th class="tc">预览图</th>
						<th>模板名称</th>
						<th>模板标识</th>
						<th class="tc">状态</th>
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
								<input type="checkbox" class="h30" name="look" value="{$v.id}" lay-skin="switch" lay-text="是|否" lay-filter="formLock" {if condition="$v.status eq 1"}checked{/if}>
							</td>
							<td class="tc">
								{if condition="$v.current eq 1"}
									<button type="button" class="layui-btn layui-btn-sm layui-btn-danger">默认模板</button>
									<button data-id="{$v.id}" class="layui-btn layui-btn-sm layui-btn-danger ml0" lay-submit lay-filter="Detele">删除</button>
								{else/}
									<button data-id="{$v.id}" class="layui-btn layui-btn-sm layui-btn-normal" lay-submit lay-filter="Default">设为默认</button>
									<button data-id="{$v.id}" class="layui-btn layui-btn-sm layui-btn-danger ml0" lay-submit lay-filter="Detele">删除</button>
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

	// 状态
	form.on('switch(formLock)', function(data){
		$('button').attr('disabled',true);
		$.ajax({
			type:'POST',url:"{:url('status')}",data:{id:data.value,type:'look'},dataType:'json',
			success:function(data){
				if(data.code == 0){
					layer.alert(data.msg,{icon:2,closeBtn:0,title:false,btnAlign:'c'},function(){
						location.reload();
					});
				} else {
					location.reload();
				}
			}
		});
	});

	// 设为默认
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

	// 删除
	form.on('submit(Detele)', function(data){
		var text = $(this).text(),
			button = $(this),
			id = $(this).data('id');
		layer.confirm('确定删除吗？',{icon:3,closeBtn:0,title:false,btnAlign:'c'},function(){
			$('button').attr('disabled',true);
			button.text('请稍候...');
			$.ajax({
				type:'POST',url:"{:url('delete')}",data:{id:id},dataType:'json',
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
