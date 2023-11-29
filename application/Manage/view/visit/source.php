
{include file="public/header" /}

<!-- 主体内容 -->
<div class="layui-body" id="LAY_app_body">
    <div class="right">
        <div class="title">来源统计</div>
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
				<a class="layui-btn layui-btn-normal" href="{:url('source')}"><i class="layui-icon">&#xe621;</i> 重置</a>
			</div>
		</form>

		<div class="visit-body">
			<div class="visit-bing-left">
				<table class="layui-table" lay-even lay-skin="nob">
					<colgroup>
						<col>
						<col>
					</colgroup>
					<thead>
						<tr>
							<th>来源网址</th>
							<th class="tr"><a href="{:url('source_more',['start' => $start, 'end' => $end])}">查看更多>></a></h3></th>
						</tr> 
					</thead>
					<tbody>
						{foreach name="query" item="web"}
						<tr>
							<td><span class="span-left">{$web.referrer}</span></td>
							<td class="tr"><span class="span-right">{$web.rsum}</span></td>
						</tr>
						{/foreach}
					</tbody>
				</table>
			</div>

			<div class="visit-bing-mid">
				<div class="source-title">浏览器分布</div>
				<div id="rate" class="source-echarts"></div>
			</div>

			<div class="visit-bing-right">
				<div class="source-title">访问终端</div>
				<div class="terminal-block-pc">
					<span><img src="/static/images/icon-source-pc.png"></span>
					<span class="terminal-num">{$max_width}%</span>
				</div>
				<div class="terminal-block-mobile">
					<span><img src="/static/images/icon-source-mobile.png"></span>
					<span class="terminal-num">{$min_width}%</span>
				</div>
			</div>
			
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
        backgroundColor: '#f2f2f2',

        title: {
            text: 'Browser',
            left: 'center',
            top: 20,
            textStyle: {
                color: '#ccc'
            }
        },

        tooltip: {
            trigger: 'item',
            formatter: '{a} <br/>{b} : {c} ({d}%)'
        },

        visualMap: {
            show: false,
            min: 0,
            max: 10000,
            inRange: {
                colorLightness: [0, 1]
            }
        },
        series: [
            {
                name: '访问来源',
                type: 'pie',
                radius: '55%',
                center: ['50%', '50%'],
                data: [
                    {$agent}
                ].sort(function (a, b) { return a.value - b.value; }),
                roseType: 'radius',
                label: {
                    color: 'rgba(0, 0, 0, 0.3)'
                },
                labelLine: {
                    lineStyle: {
                        color: 'rgba(0, 0, 0, 0.3)'
                    },
                    smooth: 0.2,
                    length: 10,
                    length2: 20
                },
                itemStyle: {
                    color: '',
                    shadowBlur: 200,
                    shadowColor: 'rgba(100, 100, 0, 0.5)'
                },

                animationType: 'scale',
                animationEasing: 'elasticOut',
                animationDelay: function (idx) {
                    return Math.random() * 200;
                }
            }
        ]
    });
});
</script>

{include file="public/footer" /}
