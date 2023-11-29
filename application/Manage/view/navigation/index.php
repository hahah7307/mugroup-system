
{include file="public/header" /}

<!-- 主体内容 -->
<div class="layui-body" id="LAY_app_body">
    <div class="right">
        <div class="title">导航管理</div>

		<div class="layui-form">
			<a class="layui-btn" href="{:url('add')}">添加</a>
			<button class="layui-btn layui-btn-normal" lay-submit lay-filter="Sort">排序</button>
			<table class="layui-table">
				<colgroup>
					<col>
					<col>
					<col width="80">
					<col width="80">
					<col width="80">
					<col width="150">
				</colgroup>
				<thead>
					<tr>
						<th>导航名称</th>
						<th>导航地址</th>
						<th class="tc">排序</th>
						<th class="tc">下拉</th>
						<th class="tc">新窗口</th>
						<th class="tc">操作</th>
					</tr> 
				</thead>
				<tbody>
					{foreach name="list" item="v"}
						<tr>
							<td>{$v.nav_name}</td>
							<td>{$v.nav_url}</td>
							<td class="tc">
								<input type="text" class="layui-input w50 h30" name="sort[{$v.id}]" value="{$v.sort}" placeholder="排序">
							</td>
							<td class="tc">
								<input type="checkbox" class="h30" name="dropdown" value="{$v.id}" lay-skin="switch" lay-text="是|否" lay-filter="formDrop" {if condition="$v.dropdown eq 1"}checked{/if}>
							</td>
							<td class="tc">
								<input type="checkbox" class="h30" name="new_target" value="{$v.id}" lay-skin="switch" lay-text="是|否" lay-filter="formTarget" {if condition="$v.new_target eq 1"}checked{/if}>
							</td>
							<td class="tc">
								<a href="{:url('edit', ['id' => $v.id])}" class="layui-btn layui-btn-normal layui-btn-sm">编辑</a>
								<button data-id="{$v.id}" class="layui-btn layui-btn-sm layui-btn-danger ml0" lay-submit lay-filter="Detele">删除</button>
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

	// 排序
	form.on('submit(Sort)', function(data){
		var text = $(this).text(), button = $(this);
		$('button').attr('disabled',true);
		button.text('请稍候...');
		$.ajax({
			type:'POST',url:"{:url('sort')}",data:data.field,dataType:'json',
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

	// 下拉
	form.on('switch(formDrop)', function(data){
		$('button').attr('disabled',true);
		$.ajax({
			type:'POST',url:"{:url('drop')}",data:{id:data.value,type:'look'},dataType:'json',
			success:function(data){
				if(data.code == 0){
					layer.alert(data.msg,{icon:2,closeBtn:0,title:false,btnAlign:'c'},function(){
						location.reload();
					});
				}
			}
		});
	});

	// 新窗口
	form.on('switch(formTarget)', function(data){
		$('button').attr('disabled',true);
		$.ajax({
			type:'POST',url:"{:url('target')}",data:{id:data.value,type:'look'},dataType:'json',
			success:function(data){
				if(data.code == 0){
					layer.alert(data.msg,{icon:2,closeBtn:0,title:false,btnAlign:'c'},function(){
						location.reload();
					});
				}
			}
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
