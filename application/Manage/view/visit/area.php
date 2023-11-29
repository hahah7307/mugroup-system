
{include file="public/header" /}

<!-- 主体内容 -->
<div class="layui-body" id="LAY_app_body">
    <div class="right">
        <div class="title">地域统计</div>
		<form class="layui-form search-form" method="get">
			<div class="layui-inline w100">
				<input type="text" class="layui-input time" name="start" value="{$start}" placeholder="开始日期">
			</div>
			<div class="layui-inline w100">
				<input type="text" class="layui-input time" name="end" value="{$end}" placeholder="结束日期">
			</div>
			<div class="layui-inline">
				<button class="layui-btn" lay-submit lay-filter="Search"><i class="layui-icon">&#xe615;</i> 搜索</button>
			</div>
			<div class="layui-inline">
				<a class="layui-btn layui-btn-normal" href="{:url('area')}"><i class="layui-icon">&#xe621;</i> 重置</a>
			</div>
		</form>

		<div class="visit-block-left fl">
			<table class="layui-table" lay-even lay-skin="nob">
				<colgroup>
					<col>
					<col>
				</colgroup>
				<thead>
					<tr>
						<th>来源国家</th>
						<th class="tr view-more"><a href="{:url('area_more',['start' => $start, 'end' => $end])}">查看更多>></a></h3></th>
					</tr> 
				</thead>
				<tbody>
					{foreach name="country" item="coun"}
					<tr>
						<td>{$coun.country}</td>
						<td class="tr">{$coun.csum}</td>
					</tr>
					{/foreach}
				</tbody>
			</table>
		</div>

		<div class="visit-block-right fr">
			<div id="rate" class="area-echarts"></div>
		</div>
		<div class="clear"></div>
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
