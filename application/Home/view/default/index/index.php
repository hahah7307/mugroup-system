<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>网站后台</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/static/layuiadmin/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/static/layuiadmin/style/admin.css" media="all">
    <link rel="stylesheet" href="/static/manage/css/manage.css" media="all">
    <link rel="stylesheet" href="/static/manage/css/common.css" media="all">
    <link rel="stylesheet" href="/static/manage/css/tab_style.css"/>
    <link rel="stylesheet" href="/static/manage/css/iconfont.css"/>
    <link rel="stylesheet" href="/static/fonts/font-awesome.min.css"/>
    <script src="/static/layuiadmin/layui/layui.js"></script>
    <script src="/static/manage/js/xm-select.js"></script>
</head>
<style>
    .layui-body {left: 20px!important;}
    .layui-form-label {width: 100px!important;}
    .layui-form-item .layui-inline {margin-right: 0!important;}
</style>
<body class="layui-body">
    <div class="right">
        <div class="title">核价模板</div>
        <div class="layui-form">
            <div class="layui-form-item">
                <div class="layui-inline layui-col-md3">
                    <label class="layui-form-label">包装长(cm)</label>
                    <div class="layui-input-inline">
                        <input type="text" autocomplete="off" class="layui-input w300" name="length" id="length" onkeyup="value=value.replace(/^\D*(\d*(?:\.\d{0,2})?).*$/g, '$1')" value="{:input('length')}">
                    </div>
                </div>
                <div class="layui-inline layui-col-md3">
                    <label class="layui-form-label">包装宽(cm)</label>
                    <div class="layui-input-inline">
                        <input type="text" autocomplete="off" class="layui-input w300" name="width" id="width" onkeyup="value=value.replace(/^\D*(\d*(?:\.\d{0,2})?).*$/g, '$1')" value="{:input('width')}">
                    </div>
                </div>
                <div class="layui-inline layui-col-md3">
                    <label class="layui-form-label">包装高(cm)</label>
                    <div class="layui-input-inline">
                        <input type="text" autocomplete="off" class="layui-input w300" name="height" id="height" onkeyup="value=value.replace(/^\D*(\d*(?:\.\d{0,2})?).*$/g, '$1')" value="{:input('height')}">
                    </div>
                </div>
                <div class="red layui-text" id="red-warn" style="line-height:36px"></div>
            </div>
            <div class="layui-form-item">
                <div class="layui-inline layui-col-md3">
                    <label class="layui-form-label">毛重(kg)</label>
                    <div class="layui-input-inline">
                        <input type="text" autocomplete="off" class="layui-input w300" name="gross_weight" value="{:input('gross_weight')}">
                    </div>
                </div>
                <div class="layui-inline layui-col-md3">
                    <label class="layui-form-label">关税率</label>
                    <div class="layui-input-inline">
                        <input type="text" autocomplete="off" class="layui-input w300" name="tariff_rate" value="{:input('tariff_rate', 0.25)}">
                    </div>
                </div>
                <div class="layui-inline layui-col-md3">
                    <label class="layui-form-label">汇率</label>
                    <div class="layui-input-inline">
                        <input type="text" autocomplete="off" class="layui-input w300" name="exchange_rate" value="{:input('exchange_rate', 6.95)}">
                    </div>
                </div>
                <div class="layui-inline layui-col-md3">
                    <label class="layui-form-label">派送方式</label>
                    <div class="layui-input-inline">
                        <input type="text" autocomplete="off" class="layui-input w300" name="delivery" value="{:input('delivery', 'FBM')}">
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-inline layui-col-md3">
                    <label class="layui-form-label">头程价格标准(元/CBM)</label>
                    <div class="layui-input-inline">
                        <input type="text" autocomplete="off" class="layui-input w300" name="flp_standard" value="{:input('flp_standard', 500)}">
                    </div>
                </div>
                <div class="layui-inline layui-col-md3">
                    <label class="layui-form-label">采购成本</label>
                    <div class="layui-input-inline">
                        <input type="text" autocomplete="off" class="layui-input w300" name="cost" value="{:input('cost')}">
                    </div>
                </div>
                <div class="layui-inline layui-col-md3">
                    <label class="layui-form-label">最低市场售价</label>
                    <div class="layui-input-inline">
                        <input type="text" autocomplete="off" class="layui-input w300" name="min_price" value="{:input('min_price')}">
                    </div>
                </div>
                <div class="layui-inline layui-col-md3">
                    <label class="layui-form-label">目标定价</label>
                    <div class="layui-input-inline">
                        <input type="text" autocomplete="off" class="layui-input w300" name="target_pricing" value="{:input('target_pricing')}">
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-inline layui-col-md3">
                    <label class="layui-form-label">广告费占比</label>
                    <div class="layui-input-inline">
                        <input type="text" autocomplete="off" class="layui-input w300" name="ad_rate" value="{:input('ad_rate', 0.1)}">
                    </div>
                </div>
                <div class="layui-inline layui-col-md3">
                    <label class="layui-form-label">退货率</label>
                    <div class="layui-input-inline">
                        <input type="text" autocomplete="off" class="layui-input w300" name="return_rate" value="{:input('return_rate', 0.05)}">
                    </div>
                </div>
                <div class="layui-inline layui-col-md3">
                    <label class="layui-form-label">平台费占比</label>
                    <div class="layui-input-inline">
                        <input type="text" autocomplete="off" class="layui-input w300" name="platform_rate" value="{:input('platform_rate', 0.15)}">
                    </div>
                </div>
            </div>
            <div class="layui-form-item tr">
                <div class="layui-input-block">
                    <button class="layui-btn w200 button" lay-submit lay-filter="formCoding">提交</button>
                    <a href="{:url('excel')}?data=$jsonData" class="layui-btn layui-btn-normal w200">导出</a>
                </div>
            </div>
        </div>
    </div>

    {if condition="($show_reason == 1)"}
    <div class="right">
        <div class="title">良仓新</div>
        <div class="layui-row">
            <div class="layui-col-md3">
                <div class="layui-form-item">
                    <label class="layui-form-label">体积(m³)</label>
                    <div class="layui-text-inline">{$volume}</div>
                </div>
            </div>
            <div class="layui-col-md3">
                <div class="layui-form-item">
                    <label class="layui-form-label">毛重(lbs)</label>
                    <div class="layui-text-inline">{$gross_weight_lbs}</div>
                </div>
            </div>
            <div class="layui-col-md3">
                <div class="layui-form-item">
                    <label class="layui-form-label">体积重(lbs)</label>
                    <div class="layui-text-inline">{$volume_lbs}</div>
                </div>
            </div>
        </div>
        <div class="layui-row">
            <div class="layui-col-md3">
                <div class="layui-form-item">
                    <label class="layui-form-label">装箱数</label>
                    <div class="layui-text-inline">1</div>
                </div>
            </div>
            <div class="layui-col-md3">
                <div class="layui-form-item">
                    <label class="layui-form-label">装柜数</label>
                    <div class="layui-text-inline">{$loading_qty}</div>
                </div>
            </div>
            <div class="layui-col-md3">
                <div class="layui-form-item">
                    <label class="layui-form-label">FOB成本</label>
                    <div class="layui-text-inline">{$fob}</div>
                </div>
            </div>
        </div>
        <div class="layui-row">
            <div class="layui-col-md3">
                <div class="layui-form-item">
                    <label class="layui-form-label">头程成本</label>
                    <div class="layui-text-inline">{$initial_cost}</div>
                </div>
            </div>
            <div class="layui-col-md3">
                <div class="layui-form-item">
                    <label class="layui-form-label">关税</label>
                    <div class="layui-text-inline">{$tariff}</div>
                </div>
            </div>
            <div class="layui-col-md3">
                <div class="layui-form-item">
                    <label class="layui-form-label">4个月仓储费</label>
                    <div class="layui-text-inline">{$liang_storage_charge}</div>
                </div>
            </div>
            <div class="layui-col-md3">
                <div class="layui-form-item">
                    <label class="layui-form-label">尾程</label>
                    <div class="layui-text-inline" id="liang_tail_end">{$liang_tail_end}</div>
                </div>
            </div>
        </div>
        <div class="layui-row">
            <div class="layui-col-md3">
                <div class="layui-form-item">
                    <label class="layui-form-label">头程成本占比</label>
                    <div class="layui-text-inline">{$initial_cost_rate}</div>
                </div>
            </div>
            <div class="layui-col-md3">
                <div class="layui-form-item">
                    <label class="layui-form-label">关税占比</label>
                    <div class="layui-text-inline">{$tariff_proportion}</div>
                </div>
            </div>
            <div class="layui-col-md3">
                <div class="layui-form-item">
                    <label class="layui-form-label">仓储费占比</label>
                    <div class="layui-text-inline">{$liang_storage_charge_proportion}</div>
                </div>
            </div>
            <div class="layui-col-md3">
                <div class="layui-form-item">
                    <label class="layui-form-label">尾程占比</label>
                    <div class="layui-text-inline">{$liang_tail_end_proportion}</div>
                </div>
            </div>
        </div>
        <div class="layui-row">
            <div class="layui-col-md3">
                <div class="layui-form-item">
                    <label class="layui-form-label">广告费</label>
                    <div class="layui-text-inline">{$advertising_expenses}</div>
                </div>
            </div>
            <div class="layui-col-md3">
                <div class="layui-form-item">
                    <label class="layui-form-label">退货费</label>
                    <div class="layui-text-inline">{$return_fee}</div>
                </div>
            </div>
            <div class="layui-col-md3">
                <div class="layui-form-item">
                    <label class="layui-form-label">平台费</label>
                    <div class="layui-text-inline">{$platform_fees}</div>
                </div>
            </div>
            <div class="layui-col-md3">
                <div class="layui-form-item">
                    <label class="layui-form-label">零利润售价</label>
                    <div class="layui-text-inline">{$liang_no_profit_price}</div>
                </div>
            </div>
        </div>
        <div class="layui-row">
            <div class="layui-col-md3">
                <div class="layui-form-item">
                    <label class="layui-form-label">最低售价利润</label>
                    <div class="layui-text-inline">{$liang_min_selling_profit}</div>
                </div>
            </div>
            <div class="layui-col-md3">
                <div class="layui-form-item">
                    <label class="layui-form-label">最低售价利润率</label>
                    <div class="layui-text-inline">{$liang_min_selling_profit_rate}</div>
                </div>
            </div>
            <div class="layui-col-md3">
                <div class="layui-form-item">
                    <label class="layui-form-label">目标定价利润</label>
                    <div class="layui-text-inline">{$liang_target_pricing_profit}</div>
                </div>
            </div>
            <div class="layui-col-md3">
                <div class="layui-form-item">
                    <label class="layui-form-label">目标定价利润率</label>
                    <div class="layui-text-inline">{$liang_target_pricing_profit_rate}</div>
                </div>
            </div>
        </div>

        <div class="title">乐歌</div>
        <div class="layui-row">
            <div class="layui-col-md3">
                <div class="layui-form-item">
                    <label class="layui-form-label">体积(m³)</label>
                    <div class="layui-text-inline">{$volume}</div>
                </div>
            </div>
            <div class="layui-col-md3">
                <div class="layui-form-item">
                    <label class="layui-form-label">毛重(lbs)</label>
                    <div class="layui-text-inline">{$gross_weight_lbs}</div>
                </div>
            </div>
            <div class="layui-col-md3">
                <div class="layui-form-item">
                    <label class="layui-form-label">体积重(lbs)</label>
                    <div class="layui-text-inline">{$volume_lbs}</div>
                </div>
            </div>
        </div>
        <div class="layui-row">
            <div class="layui-col-md3">
                <div class="layui-form-item">
                    <label class="layui-form-label">装箱数</label>
                    <div class="layui-text-inline">1</div>
                </div>
            </div>
            <div class="layui-col-md3">
                <div class="layui-form-item">
                    <label class="layui-form-label">装柜数</label>
                    <div class="layui-text-inline">{$loading_qty}</div>
                </div>
            </div>
            <div class="layui-col-md3">
                <div class="layui-form-item">
                    <label class="layui-form-label">FOB成本</label>
                    <div class="layui-text-inline">{$fob}</div>
                </div>
            </div>
        </div>
        <div class="layui-row">
            <div class="layui-col-md3">
                <div class="layui-form-item">
                    <label class="layui-form-label">头程成本</label>
                    <div class="layui-text-inline">{$initial_cost}</div>
                </div>
            </div>
            <div class="layui-col-md3">
                <div class="layui-form-item">
                    <label class="layui-form-label">关税</label>
                    <div class="layui-text-inline">{$tariff}</div>
                </div>
            </div>
            <div class="layui-col-md3">
                <div class="layui-form-item">
                    <label class="layui-form-label">4个月仓储费</label>
                    <div class="layui-text-inline">{$loctek_storage_charge}</div>
                </div>
            </div>
            <div class="layui-col-md3">
                <div class="layui-form-item">
                    <label class="layui-form-label">尾程</label>
                    <div class="layui-text-inline" id="loctek_tail_end">{$loctek_tail_end}</div>
                </div>
            </div>
        </div>
        <div class="layui-row">
            <div class="layui-col-md3">
                <div class="layui-form-item">
                    <label class="layui-form-label">头程成本占比</label>
                    <div class="layui-text-inline">{$initial_cost_rate}</div>
                </div>
            </div>
            <div class="layui-col-md3">
                <div class="layui-form-item">
                    <label class="layui-form-label">关税占比</label>
                    <div class="layui-text-inline">{$tariff_proportion}</div>
                </div>
            </div>
            <div class="layui-col-md3">
                <div class="layui-form-item">
                    <label class="layui-form-label">仓储费占比</label>
                    <div class="layui-text-inline">{$loctek_storage_charge_proportion}</div>
                </div>
            </div>
            <div class="layui-col-md3">
                <div class="layui-form-item">
                    <label class="layui-form-label">尾程占比</label>
                    <div class="layui-text-inline">{$loctek_tail_end_proportion}</div>
                </div>
            </div>
        </div>
        <div class="layui-row">
            <div class="layui-col-md3">
                <div class="layui-form-item">
                    <label class="layui-form-label">广告费</label>
                    <div class="layui-text-inline">{$advertising_expenses}</div>
                </div>
            </div>
            <div class="layui-col-md3">
                <div class="layui-form-item">
                    <label class="layui-form-label">退货费</label>
                    <div class="layui-text-inline">{$return_fee}</div>
                </div>
            </div>
            <div class="layui-col-md3">
                <div class="layui-form-item">
                    <label class="layui-form-label">平台费</label>
                    <div class="layui-text-inline">{$platform_fees}</div>
                </div>
            </div>
            <div class="layui-col-md3">
                <div class="layui-form-item">
                    <label class="layui-form-label">零利润售价</label>
                    <div class="layui-text-inline">{$loctek_no_profit_price}</div>
                </div>
            </div>
        </div>
        <div class="layui-row">
            <div class="layui-col-md3">
                <div class="layui-form-item">
                    <label class="layui-form-label">最低售价利润</label>
                    <div class="layui-text-inline">{$loctek_min_selling_profit}</div>
                </div>
            </div>
            <div class="layui-col-md3">
                <div class="layui-form-item">
                    <label class="layui-form-label">最低售价利润率</label>
                    <div class="layui-text-inline">{$loctek_min_selling_profit_rate}</div>
                </div>
            </div>
            <div class="layui-col-md3">
                <div class="layui-form-item">
                    <label class="layui-form-label">目标定价利润</label>
                    <div class="layui-text-inline">{$loctek_target_pricing_profit}</div>
                </div>
            </div>
            <div class="layui-col-md3">
                <div class="layui-form-item">
                    <label class="layui-form-label">目标定价利润率</label>
                    <div class="layui-text-inline">{$loctek_target_pricing_profit_rate}</div>
                </div>
            </div>
        </div>
    </div>
    {/if}
</body>
</html>
<script>
    layui.config({
        base: '/static/layuiadmin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use('index');

    layui.use(['form', 'jquery', 'laydate'], function() {
        var $ = layui.jquery,
            form = layui.form;

        var excelUrl = "{:url('excel')}" + "?data=" + '{$jsonData}';
        $("a").attr("href", excelUrl);

        var length = $("#length").val(),
            width = $("#width").val(),
            height = $("#height").val();
        $(function(){
            $("#length").on("input",function(e){
                length = e.delegateTarget.value;
                $.ajax({
                    type: 'POST',
                    url: "{:url('Index/ajaxLengthRule')}",
                    data: {
                        length: length,
                        width: width,
                        height: height
                    },
                    success: function(res) {
                        if(res.code === 2){
                            $("#red-warn").html(res.info);
                        } else {
                            $("#red-warn").html('');
                        }
                    }
                });
            });
        });

        $(function(){
            $("#width").on("input",function(e){
                width = e.delegateTarget.value;
                $.ajax({
                    type: 'POST',
                    url: "{:url('Index/ajaxLengthRule')}",
                    data: {
                        length: length,
                        width: width,
                        height: height
                    },
                    success: function(res) {
                        if(res.code === 2){
                            $("#red-warn").html(res.info);
                        } else {
                            $("#red-warn").html('');
                        }
                    }
                });
            });
        });

        $(function(){
            $("#height").on("input",function(e){
                height = e.delegateTarget.value;
                $.ajax({
                    type: 'POST',
                    url: "{:url('Index/ajaxLengthRule')}",
                    data: {
                        length: length,
                        width: width,
                        height: height
                    },
                    success: function(res) {
                        if(res.code === 2){
                            $("#red-warn").html(res.info);
                        } else {
                            $("#red-warn").html('');
                        }
                    }
                });
            });
        });

        //
        $("#liang_tail_end").click(function(){
            layer.alert("{$liang_tail_end_count}",{
                title: "费用详情",
                icon: 7,
                area: ['500px', '180px'],
                btn: ['关闭'],
                btnAlign: 'c'
            });
        });

        //
        $("#loctek_tail_end").click(function(){
            layer.alert("{$loctek_tail_end_count}",{
                title: "费用详情",
                icon: 7,
                area: ['500px', '180px'],
                btn: ['关闭'],
                btnAlign: 'c'
            });
        });

        // 提交
        form.on('submit(formCoding)', function(data) {
            var text = $(this).text(),
                button = $(this);
            $('button').attr('disabled',true);
            button.text('请稍候...');
            console.log(data.field);
            var arr = [];
            $.each(data.field, function(index,value){
                console.log("jQuery-each方法遍历数组：",index,value);
                arr.push(index + "=" + value);
            })
            console.log(arr);
            var urlData;
            urlData = arr.join("&");
            console.log(urlData);
            console.log("{:url('index')}");
            location.href = "{:url('index')}?" + urlData;
        });
    });
</script>
</body>
</html>


