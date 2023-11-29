
{include file="public/header" /}

<!-- 主体内容 -->
<div class="layui-body" id="LAY_app_body">
    <div class="right">
		<a href="{:session('manage.back_url')}" class="layui-btn layui-btn-danger layui-btn-sm fr"><i class="layui-icon">&#xe603;</i>返回上一页</a>
        <div class="title">地域统计</div>

		<table class="layui-table" lay-even lay-skin="nob">
			<colgroup>
				<col>
				<col>
			</colgroup>
			<thead>
				<tr>
					<th>来源国家</th>
					<th class="tr view-more"></h3></th>
				</tr> 
			</thead>
			<tbody>
				{foreach name="list" item="coun"}
				<tr>
					<td>{$coun.country}</td>
					<td class="tr">{$coun.csum}</td>
				</tr>
				{/foreach}
			</tbody>
		</table>
		
		{$list->render()}
    </div>

</div>
<script type="text/javascript" src="/static/manage/js/echarts.min.js"></script>
<script>
layui.use(['form', 'jquery', 'laydate'], function(){
	var $ = layui.jquery,
		form = layui.form,
		laydate = layui.laydate;

	lay('.time').each(function(){
		laydate.render({
			elem: this
		});
	});

    var rateChart = echarts.init(document.getElementById('rate'));

    rateChart.setOption({
        xAxis: {
            type: 'category',
            data: {$areaX}
        },
        yAxis: {
            type: 'value'
        },
        series: [{
            data: {$areaY},
            type: 'bar',
            showBackground: true,
            backgroundStyle: {
                color: 'rgba(220, 220, 220, 0.8)'
            }
        }]
    });
});
</script>

{include file="public/footer" /}
