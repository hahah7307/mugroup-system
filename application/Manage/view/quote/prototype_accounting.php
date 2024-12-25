
{include file="public/header" /}

<style>
    .layui-body {left: 220px!important;}
    .layui-form-label {font-size: 12px; padding: 8px 8px;width: 120px}
    .layui-form-item .layui-inline {margin-right: 0!important;}
    .layui-form-label {width: 160px!important;}
    .layui-divider {border-top: 1px solid #eee;  /* 设置灰色的边框 */}
    .competitor-item {border-right: #eee 1px solid;border-bottom: #eee 1px solid;padding: 0 10px 10px 0;margin: 0 0 20px;}
    .layui-col-md3 {width: 24%}
    #lc_tail_end {cursor: pointer}
    #le_tail_end {cursor: pointer}
    .layui-layer-btn1 {background-color: #fff !important; color: #333 !important; border: 1px solid #dedede !important;}
    .layui-layer-btn0 {background-color: #1E9FFF !important; color: #fff !important; border: 1px solid #1E9FFF !important;}
    .layui-layer-btn2 {background-color: #FF5722 !important; color: #fff !important; border: 1px solid #FF5722 !important;}
</style>
<div class="layui-body">
<div class="right">
    <a href="{:session('manage.back_url')}" class="layui-btn layui-btn-danger layui-btn-sm fr"><i class="layui-icon">&#xe603;</i>返回上一页</a>
    <div class="title">产品核价</div>
    <div class="layui-form">
        {foreach name="list" item="product"}
        <div class="layui-form-item">
            <div class="layui-inline layui-col-md2">
                <label class="layui-form-label">包装长(cm)<span class="red">*</span></label>
                <div class="layui-input-inline w80">
                    <input type="text" autocomplete="off" class="layui-input w150" name="length[]" id="length" value="{:$product.prototype_product_length ?? $product.product_length}">
                </div>
            </div>
            <div class="layui-inline layui-col-md2">
                <label class="layui-form-label">包装宽(cm)<span class="red">*</span></label>
                <div class="layui-input-inline w80">
                    <input type="text" autocomplete="off" class="layui-input w150" name="width[]" id="width" value="{:$product.prototype_product_width ?? $product.product_width}">
                </div>
            </div>
            <div class="layui-inline layui-col-md2">
                <label class="layui-form-label">包装高(cm)<span class="red">*</span></label>
                <div class="layui-input-inline w80">
                    <input type="text" autocomplete="off" class="layui-input w150" name="height[]" id="height" value="{:$product.prototype_product_height ?? $product.product_height}">
                </div>
            </div>
            <div class="layui-inline layui-col-md2">
                <label class="layui-form-label">毛重(kg)<span class="red">*</span></label>
                <div class="layui-input-inline w80">
                    <input type="text" autocomplete="off" class="layui-input w150" name="gross_weight[]" value="{:$product.prototype_gross_weight ?? $product.gross_weight}">
                </div>
            </div>
            <div class="layui-inline layui-col-md2">
                <label class="layui-form-label">净重(kg)<span class="red">*</span></label>
                <div class="layui-input-inline w80">
                    <input type="text" autocomplete="off" class="layui-input w150" name="net_weight[]" value="{:$product.prototype_net_weight ?? $product.net_weight}">
                </div>
            </div>
            <div class="red layui-text" id="red-warn" style="line-height:36px"></div>
            <input type="hidden" name="product_id[]" value="{$product.id}">
        </div>
        {/foreach}
        <hr class="layui-divider">
        <div class="layui-form-item">
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">含税出厂价(¥)<span class="red">*</span></label>
                <div class="layui-input-inline">
                    <input type="text" autocomplete="off" class="layui-input w200" name="cost" value="{:$info.prototype_cost ?? $info.cost}">
                </div>
            </div>
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">FOB价($)<span class="red">*</span></label>
                <div class="layui-input-inline">
                    <input type="text" autocomplete="off" class="layui-input w200" name="fob" value="{:$info.prototype_fob ?? $info.fob}">
                </div>
            </div>
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">最低市场售价($)<span class="red">*</span></label>
                <div class="layui-input-inline">
                    <input type="text" autocomplete="off" class="layui-input w200" name="min_price" value="{$accounting.product.min_price}">
                </div>
            </div>
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">目标定价($)<span class="red">*</span></label>
                <div class="layui-input-inline">
                    <input type="text" autocomplete="off" class="layui-input w200" name="target_pricing" value="{$accounting.product.target_pricing}">
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">头程价格标准(元/CBM)</label>
                <div class="layui-input-inline">
                    <input type="text" autocomplete="off" class="layui-input w200" name="flp_standard" value="{$accounting.product.flp_standard}">
                </div>
            </div>
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">关税率</label>
                <div class="layui-input-inline">
                    <input type="text" autocomplete="off" class="layui-input w200" name="tariff_rate" value="{$accounting.product.tariff_rate}">
                </div>
            </div>
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">汇率</label>
                <div class="layui-input-inline">
                    <input type="text" autocomplete="off" class="layui-input w200" name="exchange_rate" value="{$accounting.product.exchange_rate}">
                </div>
            </div>
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">派送方式</label>
                <div class="layui-input-inline">
                    <input type="text" autocomplete="off" class="layui-input w200" name="delivery" value="{$accounting.product.delivery}">
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">广告费占比</label>
                <div class="layui-input-inline">
                    <input type="text" autocomplete="off" class="layui-input w200" name="ad_rate" value="{$accounting.product.ad_rate}">
                </div>
            </div>
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">退货率</label>
                <div class="layui-input-inline">
                    <input type="text" autocomplete="off" class="layui-input w200" name="return_rate" value="{$accounting.product.return_rate}">
                </div>
            </div>
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">平台费占比</label>
                <div class="layui-input-inline">
                    <input type="text" autocomplete="off" class="layui-input w200" name="platform_rate" value="{$accounting.product.platform_rate}">
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">产品图片</label>
                <div class="layui-input-inline">
                    <a href="/{$info.img_url}" target="_blank"><img src="/{$info.img_url}" width="200"></a>
                </div>
            </div>
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">产品描述</label>
                <div class="layui-input-inline">
                    <textarea class="layui-textarea w200" name="product_desc" disabled>{$info.product_desc}</textarea>
                </div>
            </div> 
        </div>
        <div class="layui-form-item tr">
            <div class="layui-input-block">
                <button class="layui-btn layui-btn-normal w100 button" lay-submit lay-filter="formCoding">核价提交</button>
                <button class="layui-btn layui-btn-normal w100 button" lay-submit lay-filter="formSave">核价保存</button>
            </div>
        </div>
    </div>
</div>

{if condition="$info.prototype_accounting"}
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
<div class="right">
    <div class="title">样品分析&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button class="layui-btn layui-btn-sm btn-lc" lay-submit lay-filter="AttrAdd">+</button></div>
        <div class="layui-form">
            <div class="layui-competitor" style="display: flex;flex-wrap: wrap;">
                {if condition="$prototype_competitor neq null"}
                {foreach name="prototype_competitor" key="k" item="item"}
                <div class="competitor-item">
                    <div class="layui-form-item fr">
                        <button class="layui-btn layui-btn-danger layui-btn-sm btn-lc" lay-submit lay-filter="attrDel">×</button>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">竞品图片</label>
                        <div class="layui-input-inline w200">
                            <span class="input-group-btn">
                                <button type="button" data-index="{$k}" class="layui-btn layui-btn-sm upload-0">上传</button>
                                <ul class="YanNanQiu-upload-list">
                                    {foreach name="item.competitor_image" item="image"}
                                        <li style="margin: 2px">
                                            <a href="{$image}" target="_blank">
                                                <img src="{$image}">
                                            </a>
                                            <span>
                                                <i class="fa fa-times"></i>
                                            </span>
                                            <input type="hidden" name="competitor_image[{$k}][]" value="{$image}">
                                        </li>
                                    {/foreach}
                                </ul>
                            </span>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">竞品链接</label>
                        <div class="layui-input-inline w200" style="display: flex">
                            <input type="text" class="layui-input" name="competitor_url[{$k}]" value="{$item.competitor_url}">
                            {if condition="$item.competitor_url"}
                            <a href="{$item.competitor_url}" target="_blank"><i class="layui-icon iconfont icon-chaolianjie" style="line-height: 38px; font-size: 24px; margin-left: 8px"></i></a>
                            {/if}
                        </div>
                    </div>
                </div>
                {/foreach}
                {else/}
                <div class="competitor-item">
                    <div class="layui-form-item fr">
                        <button class="layui-btn layui-btn-danger layui-btn-sm btn-lc" lay-submit lay-filter="attrDel">×</button>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">竞品图片</label>
                        <div class="layui-input-inline w200">
                            <span class="input-group-btn">
                                <button type="button" data-index="0" class="layui-btn layui-btn-sm upload-0">上传</button>
                                <ul class="YanNanQiu-upload-list">
                                </ul>
                            </span>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">竞品链接</label>
                        <div class="layui-input-inline w200" style="display: flex">
                            <input type="text" class="layui-input" name="competitor_url[0]" value="">
                        </div>
                    </div>
                </div>
                {/if}
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">竞品集合链接</label>
                <div class="layui-input-inline w800" style="display: flex">
                    <input type="text" class="layui-input" name="prototype_competitor_addr" value="{$info.prototype_competitor_addr}">
                    {if condition="$info.prototype_competitor_addr"}
                    <a href="{$info.prototype_competitor_addr}" target="_blank"><i class="layui-icon iconfont icon-chaolianjie" style="line-height: 38px; font-size: 24px; margin-left: 8px"></i></a>
                    {/if}
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">结论</label>
                <div class="layui-input-inline w800">
                    <textarea name="prototype_conclusion" class="layui-textarea">{$info.prototype_conclusion}</textarea>
                </div>
            </div>
            <div class="layui-form-item tr">
                <div class="layui-input-block">
                    <button class="layui-btn layui-btn-normal w100 button" lay-submit lay-filter="formAnalysis">分析提交</button>
                    {if condition="$info.status eq 7"}
                    <button class="layui-btn layui-btn-normal w100 button" data-id="{$info.id}" lay-submit lay-filter="Audit">样品审核</button>
                    {/if}
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

        let domIndex = 0;
        // 添加属性
        form.on('submit(AttrAdd)', function(data) {
            domIndex ++;
            let newDom = '<div class="competitor-item">'
                + '<div class="layui-form-item fr">'
                + '<button class="layui-btn layui-btn-danger layui-btn-sm btn-lc" lay-submit lay-filter="attrDel">×</button>'
                + '</div>'
                + '<div class="layui-form-item">'
                + '<label class="layui-form-label">竞品图片</label>'
                + '<div class="layui-input-inline w200">'
                + '<span class="input-group-btn">'
                + '<button type="button" data-index="' + domIndex + '" class="layui-btn layui-btn-sm upload-' + domIndex + '">上传</button>'
                + '<ul class="YanNanQiu-upload-list">'
                + '</ul>'
                + '</span>'
                + '</div>'
                + '</div>'
                + '<div class="layui-form-item">'
                + '<label class="layui-form-label">竞品链接</label>'
                + '<div class="layui-input-inline w200" style="display: flex">'
                + '<input type="text" class="layui-input" name="competitor_url[' + domIndex + ']" value="">'
                + '</div>'
                + '</div>'
                + '</div>';
            $(".layui-competitor").append(newDom);
            form.render();
            initUploadButtons(domIndex);
            return false;
        });

        // 删除属性
        form.on('submit(attrDel)', function(data) {
            $(this).parent().parent().remove();
        });

        initUploadButtons();
        function initUploadButtons(index = 0) {
            // 上传
            let uploadInst = upload.render({
                elem: '.upload-' + index //绑定元素
                ,url: '/Manage/upload/image_upload' //上传接口
                ,exts: 'png|jpg|jpge|gif'
                ,multiple: true
                ,before: function (obj){
                    layer.load(1);
                }
                ,done: function(res, index, elem){
                    console.log(this.item.next().next().html());
                    //上传完毕回调
                    if (res.code === 1) {
                        console.log(this.item.data('index'));
                        let html = this.item.next().next().html();
                        this.item.next().next().html(html + '<li style="margin: 2px">' +
                            '<a href="/upload/images/' + res.data + '" target="_blank">' +
                            '<img src="/upload/images/' + res.data + '">' +
                            '</a>' +
                            '<span><i class="fa fa-times"></i></span>' +
                            '<input type="hidden" name="competitor_image[' + this.item.data('index') + '][]" value="/upload/images/' + res.data + '">' +
                            '</li>');
                        layer.closeAll();
                    } else {
                        layer.alert(res.msg,{icon:2,closeBtn:0,title:false,btnAlign:'c'},function(){
                            layer.closeAll();
                        });
                    }
                }
                ,error: function(){
                    //请求异常回调
                }
            });
        }

        // 图片删除
        $('body').on('click','.YanNanQiu-upload-list li>span',function(){
            $(this).parent().remove();
        });

        // 核价提交
        form.on('submit(formCoding)', function(data){
            let text = $(this).text(),
                button = $(this);
            $('button').attr('disabled',true);
            button.text('请稍候...');
            layer.confirm('确认核价吗？',{icon:3,closeBtn:0,title:false,btnAlign:'c'},function(){
                axios.post("{:url('prototype_accounting', ['id' => $info['id']])}", data.field, {
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
            }, function () {
                layer.closeAll();
                $('button').attr('disabled',false);
                button.text(text);
            });
            return false;
        });

        // 核价保存
        form.on('submit(formSave)', function(data){
            let text = $(this).text(),
                button = $(this);
            $('button').attr('disabled',true);
            button.text('请稍候...');
            layer.confirm('确认保存吗？',{icon:3,closeBtn:0,title:false,btnAlign:'c'},function(){
                axios.post("{:url('accounting_save', ['id' => $info['id'], 'type' => 2])}", data.field, {
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
            }, function () {
                layer.closeAll();
                $('button').attr('disabled',false);
                button.text(text);
            });
            return false;
        });

        // 分析提交
        form.on('submit(formAnalysis)', function(data){
            let text = $(this).text(),
                button = $(this);
            $('button').attr('disabled',true);
            button.text('请稍候...');
            layer.confirm('确认提交吗？',{icon:3,closeBtn:0,title:false,btnAlign:'c'},function() {
                axios.post("{:url('prototype_analysis', ['id' => $info['id']])}", data.field, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                    .then(function (response) {
                        let res = response.data;
                        if (res.code === 1) {
                            layer.alert(res.msg, {icon: 1, closeBtn: 0, title: false, btnAlign: 'c',}, function () {
                                location.reload();
                            });
                        } else {
                            layer.alert(res.msg, {icon: 2, closeBtn: 0, title: false, btnAlign: 'c'}, function () {
                                layer.closeAll();
                                $('button').attr('disabled', false);
                                button.text(text);
                            });
                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }, function () {
                layer.closeAll();
                $('button').attr('disabled',false);
                button.text(text);
            });
            return false;
        });

        // 报价审核
        form.on('submit(Audit)', function(data){
            let text = $(this).text(),
                button = $(this),
                id = $(this).data('id');
            $('button').attr('disabled',true);
            button.text('请稍候...');
            layer.open({
                type: 1,  // 页面层
                title: '报价审核意见',  // 弹出层标题
                content: '<div style="padding: 20px;">' +
                    '<input type="text" id="inputValue" class="layui-input" />' +
                    '</div>',  // 弹出层内容，包含输入框
                area: ['400px', '200px'],  // 设置弹出层的大小
                btn: ['审核通过', '审核驳回', '报价失败', '关闭'],  // 三个按钮
                yes: function(index, layero){
                    let userInput = $("#inputValue").val();  // 获取输入框的值``
                    axios.post("{:url('sample_approve')}", {id: id, suggestion: userInput})
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
                },
                btn2: function(index, layero){
                    let userInput = $("#inputValue").val();  // 获取输入框的值
                    axios.post("{:url('sample_dismiss')}", {id: id, suggestion: userInput})
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
                },
                btn3: function(index, layero){
                    let userInput = $("#inputValue").val();  // 获取输入框的值
                    axios.post("{:url('sample_deny')}", {id: id, suggestion: userInput})
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
                },
                btn4: function(index, layero){
                    // 取消按钮回调
                    layer.closeAll();
                    $('button').attr('disabled',false);
                    button.text(text);
                },
                end: function() {
                    // 取消按钮回调
                    layer.closeAll();
                    $('button').attr('disabled',false);
                    button.text(text);
                }
            });
        });
    });
</script>

{include file="public/footer" /}
