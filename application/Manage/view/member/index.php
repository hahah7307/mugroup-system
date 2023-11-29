
{include file="public/header" /}

<!-- 主体内容 -->
<div class="layui-body" id="LAY_app_body">
    <div class="right">
        <div class="title">会员列表</div>
        <form class="layui-form search-form" method="get">
			<div class="layui-inline w80">
				<select name="sort">
					<option value="asc" {if condition="$sort eq 'asc'"}selected{/if}>正序</option>
					<option value="desc" {if condition="$sort eq 'desc'"}selected{/if}>倒序</option>
				</select>
			</div>
			<div class="layui-inline w150">
				<select name="rank">
					<option value="0" {if condition="$rank eq 0"}selected{/if}>请选择职位</option>
					{foreach name="ranks" item="ran"}
						<option value="{$ran.id}" {if condition="$rank eq $ran['id']"}selected{/if}>{$ran.name}</option>
					{/foreach}
				</select>
			</div>
			<div class="layui-inline w200">
				<input type="text" class="layui-input" name="keyword" value="{$keyword}" placeholder="搜索企业名称">
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
			<table class="layui-table">
				<colgroup>
					<col>
					<col>
					<col>
					<col>
					<col width="80">
					<col width="180">
				</colgroup>
				<thead>
					<tr>
						<th class="tc">企业名称</th>
						<th class="tc">职位</th>
						<th class="tc">法人代表</th>
						<th class="tc">联系人</th>
						<th class="tc">状态</th>
						<th class="tc">操作</th>
					</tr> 
				</thead>
				<tbody>
					{foreach name="list" item="v"}
						<tr>
							<td class="tc"><a href="{$v.site_url}" target="_blank">{$v.company_name}</a></td>
							<td class="tc">
								{foreach name="v.member_relation" item="rank"}
								<p>{$rank.category.name}</p>
								{/foreach}
							</td>
							<td class="tc">
								<p class="blue">{$v.legal_name}</p>
								<p>{$v.legal_tel}</p>
								<p>{$v.legal_phone}
							</td>
							<td class="tc">
								<p class="blue">{$v.lxr_name}</p>
								<p>{$v.lxr_post}</p>
								<p>{$v.lxr_tel}</p>
								<p>{$v.lxr_phone}</p>
							</td>
							<td class="tc">
								<input type="checkbox" class="h30" name="look" value="{$v.id}" lay-skin="switch" lay-text="是|否" lay-filter="formLock" {if condition="$v.status eq 1"}checked{/if}>
							</td>
							<td class="tc">
								<a href="{:url('feature', ['id' => $v.id])}" class="layui-btn layui-btn-sm">风采</a>
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
