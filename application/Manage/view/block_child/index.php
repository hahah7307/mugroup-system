
{include file="public/header" /}

<!-- 主体内容 -->
<div class="layui-body" id="LAY_app_body">
    <div class="right">
        <div class="title">广告列表</div>
        <form class="layui-form search-form" method="get">
			<div class="layui-inline w80">
				<select name="sort">
					<option value="asc" {if condition="$sort eq 'asc'"}selected{/if}>正序</option>
					<option value="desc" {if condition="$sort eq 'desc'"}selected{/if}>倒序</option>
				</select>
			</div>
			<div class="layui-inline w150">
				<select name="cid">
					<option value="0">请选择分类</option>
					{foreach name="group" item="cate" key="k"}
					<optgroup label="{$k|index_to_title}">
						{foreach name="cate" item="ca"}
						<option value="{$ca.id}" {if condition="$cid eq $ca['id']"}selected{/if}>{$ca.title}</option>
						{/foreach}
					</optgroup>
					{/foreach}
				</select>
			</div>
			<div class="layui-inline w200">
				<input type="text" class="layui-input" name="keyword" value="{$keyword}" placeholder="搜索标题">
			</div>
			<div class="layui-inline">
				<button class="layui-btn" lay-submit lay-filter="Search"><i class="layui-icon">&#xe615;</i> 查询</button>
			</div>
			<div class="layui-inline">
				<a class="layui-btn layui-btn-normal" href="{:url('index')}"><i class="layui-icon">&#xe621;</i> 重置</a>
			</div>
		</form>

		<div class="layui-form">
			<a class="layui-btn" href="{:url('add')}">添加</a>
			<button class="layui-btn layui-btn-normal" lay-submit lay-filter="Sort">排序</button>
			<table class="layui-table">
				<colgroup>
					<col>
					<col>
					<col>
					<col>
					<col width="80">
					<col width="80">
					<col width="150">
				</colgroup>
				<thead>
					<tr>
						<th>图片</th>
						<th>标题</th>
						<th class="tc">链接地址</th>
						<th class="tc">广告位</th>
						<th class="tc">排序</th>
						<th class="tc">状态</th>
						<th class="tc">操作</th>
					</tr> 
				</thead>
				<tbody>
					{foreach name="list" item="v"}
						<tr>
							<td><a href="{:imageurl_to_path($v['pictures'])}" target="_blank"><img src="{:imageurl_to_path($v['pictures'])}" height="40"></a></td>
							<td>{$v.title}</td>
							<td>{$v.url}</td>
							<td class="tc">{$v.block.title}</td>
							<td class="tc">
								<input type="text" class="layui-input w50 h30" name="sort[{$v.id}]" value="{$v.sort}" placeholder="排序">
							</td>
							<td class="tc">
								<input type="checkbox" class="h30" name="look" value="{$v.id}" lay-skin="switch" lay-text="是|否" lay-filter="formLock" {if condition="$v.status eq 1"}checked{/if}>
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
