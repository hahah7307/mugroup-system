
{include file="public/header" /}

<style>
    .layui-body {left: 220px!important;}
    .layui-form-label {width: 100px!important;}
    .layui-form-item .layui-inline {margin-right: 0!important;}
    .layui-form-label {width: 160px!important;}
    .layui-divider {border-top: 1px solid #eee;  /* 设置灰色的边框 */}
</style>
<div class="layui-body">
<div class="right">
    <a href="{:session('manage.back_url')}" class="layui-btn layui-btn-danger layui-btn-sm fr"><i class="layui-icon">&#xe603;</i>返回上一页</a>
    <div class="title">核价模板</div>
    <div class="layui-form">
        {foreach name="list" item="product"}
        <div class="layui-form-item">
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">包装长(cm)<span class="red">*</span></label>
                <div class="layui-input-inline">
                    <input type="text" autocomplete="off" class="layui-input w300" name="length" id="length" value="{$product.product_length}" disabled>
                </div>
            </div>
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">包装宽(cm)<span class="red">*</span></label>
                <div class="layui-input-inline">
                    <input type="text" autocomplete="off" class="layui-input w300" name="width" id="width" value="{$product.product_width}" disabled>
                </div>
            </div>
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">包装高(cm)<span class="red">*</span></label>
                <div class="layui-input-inline">
                    <input type="text" autocomplete="off" class="layui-input w300" name="height" id="height" value="{$product.product_height}" disabled>
                </div>
            </div>
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">毛重(kg)<span class="red">*</span></label>
                <div class="layui-input-inline">
                    <input type="text" autocomplete="off" class="layui-input w300" name="gross_weight" value="{$product.gross_weight}" disabled>
                </div>
            </div>
            <div class="red layui-text" id="red-warn" style="line-height:36px"></div>
            <input type="hidden" name="product_id[]" value="{$product.id}">
        </div>
        {/foreach}
        <hr class="layui-divider">
        <div class="layui-form-item">
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">采购成本(¥)<span class="red">*</span></label>
                <div class="layui-input-inline">
                    <input type="text" autocomplete="off" class="layui-input w300" name="cost" value="{$info.cost}" disabled>
                </div>
            </div>
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">最低市场售价($)<span class="red">*</span></label>
                <div class="layui-input-inline">
                    <input type="text" autocomplete="off" class="layui-input w300" name="min_price" value="{$accounting.product.min_price}">
                </div>
            </div>
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">目标定价($)<span class="red">*</span></label>
                <div class="layui-input-inline">
                    <input type="text" autocomplete="off" class="layui-input w300" name="target_pricing" value="{$accounting.product.target_pricing}">
                </div>
            </div>
            <input type="hidden" name="currency" value="{$info.currency}">
        </div>
        <div class="layui-form-item">
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">头程价格标准(元/CBM)</label>
                <div class="layui-input-inline">
                    <input type="text" autocomplete="off" class="layui-input w300" name="flp_standard" value="{:input('flp_standard', $config['flp_standard'])}">
                </div>
            </div>
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">关税率</label>
                <div class="layui-input-inline">
                    <input type="text" autocomplete="off" class="layui-input w300" name="tariff_rate" value="{:input('tariff_rate', $config['tariff_rate'])}">
                </div>
            </div>
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">汇率</label>
                <div class="layui-input-inline">
                    <input type="text" autocomplete="off" class="layui-input w300" name="exchange_rate" value="{:input('exchange_rate', $config['exchange_rate'])}">
                </div>
            </div>
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">派送方式</label>
                <div class="layui-input-inline">
                    <input type="text" autocomplete="off" class="layui-input w300" name="delivery" value="{:input('delivery', $config['delivery'])}">
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">广告费占比</label>
                <div class="layui-input-inline">
                    <input type="text" autocomplete="off" class="layui-input w300" name="ad_rate" value="{:input('ad_rate', $config['ad_rate'])}">
                </div>
            </div>
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">退货率</label>
                <div class="layui-input-inline">
                    <input type="text" autocomplete="off" class="layui-input w300" name="return_rate" value="{:input('return_rate', $config['return_rate'])}">
                </div>
            </div>
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">平台费占比</label>
                <div class="layui-input-inline">
                    <input type="text" autocomplete="off" class="layui-input w300" name="platform_rate" value="{:input('platform_rate', $config['platform_rate'])}">
                </div>
            </div>
        </div>
        <div class="layui-form-item tr">
            <div class="layui-input-block">
                <button class="layui-btn w100 button" lay-submit lay-filter="formCoding">提交</button>
<!--                <a id="export" href="" class="layui-btn layui-btn-normal w100">导出</a>-->
            </div>
        </div>
    </div>
</div>

{if condition="$info.accounting"}
<div class="right">
    <div class="title"><b class="black">一号仓</b></div>
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
                <label class="layui-form-label w200"><b class="black">目标定价利润($)</b></label>
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

    <div class="title"><b class="black">二号仓</b></div>
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
{/if}
</div>
<script>
    layui.use(['form', 'jquery'], function() {
        let $ = layui.jquery,
            form = layui.form;

        //监听提交
        form.on('submit(formCoding)', function(data){
            console.log(data.field);
            let text = $(this).text(),
                button = $(this);
            $('button').attr('disabled',true);
            button.text('请稍候...');
            axios.post("{:url('accounting', ['id' => $info['id']])}", data.field, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then(function (response) {
                    let res = response.data;
                    if (res.code === 1) {
                        layer.alert(res.msg,{icon:1,closeBtn:0,title:false,btnAlign:'c',},function(){
                            location.reload();
                        });
                    } else {
                        layer.alert(res.msg,{icon:2,closeBtn:0,title:false,btnAlign:'c'},function(){
                            layer.closeAll();
                            $('button').attr('disabled',false);
                            button.text(text);
                        });
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
            return false;
        });

        //
        $("#lc_tail_end").click(function(){
            layer.alert("{$accounting.lc_tail_end_label}",{
                title: "费用详情",
                icon: 7,
                area: ['500px', '180px'],
                btn: ['关闭'],
                btnAlign: 'c'
            });
        });

        //
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

{include file="public/footer" /}
