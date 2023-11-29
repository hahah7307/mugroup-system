
{include file="public/header" /}

<!-- 主体内容 -->
<div class="layui-body" id="LAY_app_body">
    <div class="right">
		<a href="{:session('manage.back_url')}" class="layui-btn layui-btn-danger layui-btn-sm fr"><i class="layui-icon">&#xe603;</i>返回上一页</a>
        <div class="title">来源统计</div>

		<table class="layui-table" lay-even lay-skin="nob">
			<colgroup>
				<col>
				<col>
			</colgroup>
			<thead>
				<tr>
					<th>来源网址</th>
					<th class="tr view-more"></h3></th>
				</tr> 
			</thead>
			<tbody>
				{foreach name="list" item="coun"}
				<tr>
					<td>{$coun.referrer}</td>
					<td class="tr">{$coun.rsums}</td>
				</tr>
				{/foreach}
			</tbody>
		</table>
		
		{$list->render()}
    </div>

</div>

{include file="public/footer" /}
