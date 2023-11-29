
{include file="public/header" /}

<!-- 主体内容 -->
<div class="layui-body" id="LAY_app_body">
    <div class="right">
        <div class="title">访客统计</div>
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
				<a class="layui-btn layui-btn-normal" href="{:url('index')}"><i class="layui-icon">&#xe621;</i> 重置</a>
			</div>
		</form>

		<div class="layui-card-body">
			<div class="layui-carousel layadmin-carousel layadmin-backlog">
				<ul class="layui-row layui-col-space10 layui-this">
					<li class="layui-col-xs3">
						<a href="javascript:;" class="layadmin-backlog-body">
							<h3>浏览量（PV）</h3>
							<p>
								<cite>{$data.pv}</cite>
								<i class="layui-icon iconfont icon-liulanliang"></i>
							</p>
						</a>
					</li>
					<li class="layui-col-xs3">
						<a href="javascript:;" class="layadmin-backlog-body">
							<h3>人均浏览</h3>
							<p>
								<cite>{$data.average}</cite>
								<i class="layui-icon iconfont icon-fangke"></i>
							</p>
						</a>
					</li>
					<li class="layui-col-xs3">
						<a href="javascript:;" class="layadmin-backlog-body">
							<h3>IP</h3>
							<p>
								<cite>{$data.clientIp}</cite>
								<i class="layui-icon iconfont icon-ip"></i>
							</p>
						</a>
					</li>
					<li class="layui-col-xs3">
						<a href="javascript:;" class="layadmin-backlog-body">
							<h3>独立访客（UV）</h3>
							<p>
								<cite>{$data.uv}</cite>
								<i class="layui-icon iconfont icon-geren"></i>
							</p>
						</a>
					</li>
				</ul>
			</div>
		</div>

		<div class="layadmin-backlog-body zhu-body">
			<div class="zhu-title">
				<h3>概况</h3>
			</div>
			<div id="rate" class="zhu-echarts"></div>
		</div>

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
            boundaryGap: false
        },
        yAxis: {
            type: 'value',
            boundaryGap: [0, '30%']
        },
        visualMap: {
            type: 'piecewise',
            show: false,
            dimension: 0,
            seriesIndex: 0,
            pieces: [
                {$highData}
            ]
        },
        series: [
            {
                type: 'line',
                smooth: 0.6,
                symbol: 'none',
                lineStyle: {
                    color: 'green',
                    width: 5
                },
                markLine: {
                    symbol: ['none', 'none'],
                    label: {show: false},
                    data: [
                        {$shadow}
                    ]
                },
                areaStyle: {},
                data: {$visit}
            }
        ]
    });
});
</script>

{include file="public/footer" /}
