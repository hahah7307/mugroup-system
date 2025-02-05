
<head>
    <title></title>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/static/layuiadmin/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/static/layuiadmin/style/admin.css" media="all">
    <link rel="stylesheet" href="/static/manage/css/manage.css" media="all">
    <link rel="stylesheet" href="/static/manage/css/common.css" media="all">
    <link rel="stylesheet" href="/static/manage/css/tab_style.css"/>
    <script src="/static/layuiadmin/layui/layui.js"></script>
    <style>
        .layui-body {position: unset}
        .layui-col-md3 {width: 24%}
        .layui-form-label {font-size: 12px; padding: 8px 8px;width: 120px}
    </style>
</head>
<div class="layui-body">
<div class="right">
    <div class="layui-form">
        {foreach name="$accounting.product.width" key="k" item="v"}
        <div class="layui-form-item">
            <div class="layui-inline layui-col-md2">
                <label class="layui-form-label w80">包装长(cm)<span class="red">*</span></label>
                <div class="layui-text-inline w150">{:$accounting['product']['length'][$k]}</div>
            </div>
            <div class="layui-inline layui-col-md2">
                <label class="layui-form-label w80">包装宽(cm)<span class="red">*</span></label>
                <div class="layui-text-inline w150">{:$accounting['product']['height'][$k]}</div>
            </div>
            <div class="layui-inline layui-col-md2">
                <label class="layui-form-label w80">包装高(cm)<span class="red">*</span></label>
                <div class="layui-text-inline w150">{:$accounting['product']['width'][$k]}</div>
            </div>
            <div class="layui-inline layui-col-md2">
                <label class="layui-form-label w80">毛重(kg)<span class="red">*</span></label>
                <div class="layui-text-inline w150">{:$accounting['product']['gross_weight'][$k]}</div>
            </div>
            <div class="layui-inline layui-col-md2">
                <label class="layui-form-label w80">净重(kg)<span class="red">*</span></label>
                <div class="layui-text-inline w150">{:$accounting['product']['net_weight'][$k]}</div>
            </div>
            <div class="red layui-text" id="red-warn" style="line-height:36px"></div>
            <input type="hidden" name="product_id[]" value="{$product.id}">
        </div>
        {/foreach}
        <hr class="layui-divider">
        <div class="layui-form-item">
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">含税出厂价(¥)<span class="red">*</span></label>
                <div class="layui-text-inline">{$accounting.product.cost}</div>
            </div>
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">FOB价($)<span class="red">*</span></label>
                <div class="layui-text-inline">{$accounting.product.fob}</div>
            </div>
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">最低市场售价($)<span class="red">*</span></label>
                <div class="layui-text-inline">{$accounting.product.min_price}</div>
            </div>
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">目标定价($)<span class="red">*</span></label>
                <div class="layui-text-inline">{$accounting.product.target_pricing}</div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">头程价格标准(元/CBM)</label>
                <div class="layui-text-inline">{$accounting.product.flp_standard}</div>
            </div>
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">关税率</label>
                <div class="layui-text-inline">{$accounting.product.tariff_rate}</div>
            </div>
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">汇率</label>
                <div class="layui-text-inline">{$accounting.product.exchange_rate}</div>
            </div>
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">派送方式</label>
                <div class="layui-text-inline">{$accounting.product.delivery}</div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">广告费占比</label>
                <div class="layui-text-inline">{$accounting.product.ad_rate}</div>
            </div>
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">退货率</label>
                <div class="layui-text-inline">{$accounting.product.return_rate}</div>
            </div>
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">平台费占比</label>
                <div class="layui-text-inline">{$accounting.product.platform_rate}</div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">产品描述</label>
                <div class="layui-text-inline">{$accounting.product.product_desc}</div>
            </div> 
        </div>
    </div>
</div>

<div class="right">
    <div class="title"><b class="black">良仓</b></div>
    <div class="layui-row">
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">体积(m³)</label>
                <div class="layui-text-inline">{$accounting.storage.0.data.volume}</div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">毛重(lbs)</label>
                <div class="layui-text-inline">{$accounting.storage.0.data.gross_weight_lbs}</div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">体积重(lbs)</label>
                <div class="layui-text-inline">{$accounting.storage.0.data.volume_lbs}</div>
            </div>
        </div>
    </div>
    <div class="layui-row">
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">装箱数</label>
                <div class="layui-text-inline">{$accounting.product.product|count}</div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">装柜数</label>
                <div class="layui-text-inline">{$accounting.storage.0.data.loading_qty}</div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">FOB成本($)</label>
                <div class="layui-text-inline">{$accounting.storage.0.data.fob}</div>
            </div>
        </div>
    </div>
    <div class="layui-row">
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">头程成本($)</label>
                <div class="layui-text-inline">{$accounting.storage.0.data.initial_cost}</div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">关税($)</label>
                <div class="layui-text-inline">{$accounting.storage.0.data.tariff}</div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">4个月仓储费($)</label>
                <div class="layui-text-inline">{$accounting.storage.0.data.storage_charge}</div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label"><b class="black">尾程($)</b></label>
                <div class="layui-text-inline" id="lc_tail_end"><b class="black">{$accounting.storage.0.data.tail_end}</b></div>
            </div>
        </div>
    </div>
    <div class="layui-row">
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">头程成本占比</label>
                <div class="layui-text-inline">{$accounting.storage.0.data.initial_cost_rate|decimal2percentage}</div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">关税占比</label>
                <div class="layui-text-inline">{$accounting.storage.0.data.tariff_proportion|decimal2percentage}</div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">仓储费占比</label>
                <div class="layui-text-inline">{$accounting.storage.0.data.storage_charge_proportion|decimal2percentage}</div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">尾程占比</label>
                <div class="layui-text-inline">{$accounting.storage.0.data.tail_end_proportion|decimal2percentage}</div>
            </div>
        </div>
    </div>
    <div class="layui-row">
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">广告费($)</label>
                <div class="layui-text-inline">{$accounting.storage.0.data.advertising_expenses}</div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">退货费($)</label>
                <div class="layui-text-inline">{$accounting.storage.0.data.return_fee}</div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">平台费($)</label>
                <div class="layui-text-inline">{$accounting.storage.0.data.platform_fees}</div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label"><b class="black">零利润售价($)</b></label>
                <div class="layui-text-inline"><b class="black">{$accounting.storage.0.data.no_profit_price}</b></div>
            </div>
        </div>
    </div>
    <div class="layui-row">
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label"><b class="black">最低售价利润($)</b></label>
                <div class="layui-text-inline"><b class="black">{$accounting.storage.0.data.min_selling_profit}</b></div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label"><b class="black">最低售价利润率</b></label>
                <div class="layui-text-inline"><b class="black">{$accounting.storage.0.data.min_selling_profit_rate|decimal2percentage}</b></div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label"><b class="black">目标定价利润($)</b></label>
                <div class="layui-text-inline"><b class="black">{$accounting.storage.0.data.target_pricing_profit}</b></div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label"><b class="black">目标定价利润率</b></label>
                <div class="layui-text-inline"><b class="black">{$accounting.storage.0.data.target_pricing_profit_rate|decimal2percentage}</b></div>
            </div>
        </div>
    </div>

    <div class="title"><b class="black">乐歌</b></div>
    <div class="layui-row">
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">体积(m³)</label>
                <div class="layui-text-inline">{$accounting.storage.1.data.volume}</div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">毛重(lbs)</label>
                <div class="layui-text-inline">{$accounting.storage.1.data.gross_weight_lbs}</div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">体积重(lbs)</label>
                <div class="layui-text-inline">{$accounting.storage.1.data.volume_lbs}</div>
            </div>
        </div>
    </div>
    <div class="layui-row">
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">装箱数</label>
                <div class="layui-text-inline">{$accounting.product.product|count}</div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">装柜数</label>
                <div class="layui-text-inline">{$accounting.storage.1.data.loading_qty}</div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">FOB成本($)</label>
                <div class="layui-text-inline">{$accounting.storage.1.data.fob}</div>
            </div>
        </div>
    </div>
    <div class="layui-row">
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">头程成本($)</label>
                <div class="layui-text-inline">{$accounting.storage.1.data.initial_cost}</div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">关税($)</label>
                <div class="layui-text-inline">{$accounting.storage.1.data.tariff}</div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">4个月仓储费($)</label>
                <div class="layui-text-inline">{$accounting.storage.1.data.storage_charge}</div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label"><b class="black">尾程($)</b></label>
                <div class="layui-text-inline" id="le_tail_end"><b class="black">{$accounting.storage.1.data.tail_end}</b></div>
            </div>
        </div>
    </div>
    <div class="layui-row">
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">头程成本占比</label>
                <div class="layui-text-inline">{$accounting.storage.1.data.initial_cost_rate|decimal2percentage}</div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">关税占比</label>
                <div class="layui-text-inline">{$accounting.storage.1.data.tariff_proportion|decimal2percentage}</div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">仓储费占比</label>
                <div class="layui-text-inline">{$accounting.storage.1.data.storage_charge_proportion|decimal2percentage}</div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">尾程占比</label>
                <div class="layui-text-inline">{$accounting.storage.1.data.tail_end_proportion|decimal2percentage}</div>
            </div>
        </div>
    </div>
    <div class="layui-row">
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">广告费($)</label>
                <div class="layui-text-inline">{$accounting.storage.1.data.advertising_expenses}</div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">退货费($)</label>
                <div class="layui-text-inline">{$accounting.storage.1.data.return_fee}</div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">平台费($)</label>
                <div class="layui-text-inline">{$accounting.storage.1.data.platform_fees}</div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label"><b class="black">零利润售价($)</b></label>
                <div class="layui-text-inline"><b class="black">{$accounting.storage.1.data.no_profit_price}</b></div>
            </div>
        </div>
    </div>
    <div class="layui-row">
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label"><b class="black">最低售价利润($)</b></label>
                <div class="layui-text-inline"><b class="black">{$accounting.storage.1.data.min_selling_profit}</b></b></div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label"><b class="black">最低售价利润率</b></label>
                <div class="layui-text-inline"><b class="black">{$accounting.storage.1.data.min_selling_profit_rate|decimal2percentage}</b></div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label"><b class="black">目标定价利润($)</b></label>
                <div class="layui-text-inline"><b class="black">{$accounting.storage.1.data.target_pricing_profit}</b></div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label"><b class="black">目标定价利润率</b></label>
                <div class="layui-text-inline"><b class="black">{$accounting.storage.1.data.target_pricing_profit_rate|decimal2percentage}</b></div>
            </div>
        </div>
    </div>
</div>
</div>
<script>
    layui.use(['form', 'jquery', 'upload'], function() {
        let $ = layui.jquery,
            form = layui.form,
            upload = layui.upload;

        // 良仓尾程计算
        $("#lc_tail_end").click(function(){
            layer.alert("{$accounting.lc_tail_end_label}",{
                title: "费用详情",
                icon: 7,
                area: ['500px', '180px'],
                btn: ['关闭'],
                btnAlign: 'c'
            });
        });

        // 乐歌尾程计算
        $("#le_tail_end").click(function(){
            layer.alert("{$accounting.le_tail_end_label}",{
                title: "费用详情",
                icon: 7,
                area: ['500px', '180px'],
                btn: ['关闭'],
                btnAlign: 'c'
            });
        });
    });
</script>
