
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
    <div class="title">产品核价</div>
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
                <label class="layui-form-label">含税出厂价(¥)<span class="red">*</span></label>
                <div class="layui-input-inline">
                    <input type="text" autocomplete="off" class="layui-input w300" name="cost" value="{$info.cost}" disabled>
                </div>
            </div>
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">FOB价($)<span class="red">*</span></label>
                <div class="layui-input-inline">
                    <input type="text" autocomplete="off" class="layui-input w300" name="fob" value="{$info.fob}" disabled>
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
                <button class="layui-btn layui-btn-normal w100 button" lay-submit lay-filter="formCoding">核价提交</button>
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
<div class="right">
    <div class="title">产品分析</div>
    <div class="layui-form">
        <div class="layui-form-item">
            <label class="layui-form-label">竞品图片</label>
            <div class="layui-input-inline w300">
                <span class="input-group-btn">
                    <button type="button" class="layui-btn layui-btn-sm" id="upload">上传</button>
                    <ul class="YanNanQiu-upload-list">
                        {foreach name="competitor_image" item="v"}
                            <li style="margin: 2px">
                                <a href="{$v}" target="_blank">
                                    <img src="{$v}">
                                </a>
                                <span>
                                    <i class="fa fa-times"></i>
                                </span>
                                <input type="hidden" name="competitor_image[]" value="{$v}">
                            </li>
                        {/foreach}
                    </ul>
                </span>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">竞品地址</label>
            <div class="layui-input-inline w300" style="display: flex">
                <input type="text" class="layui-input" name="competitor_url" value="{$info.competitor_url}">
                {if condition="$info.competitor_url"}
                <a href="{$info.competitor_url}" target="_blank"><i class="layui-icon iconfont icon-chaolianjie" style="line-height: 38px; font-size: 24px; margin-left: 8px"></i></a>
                {/if}
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">结论</label>
            <div class="layui-input-inline w300">
                <textarea name="conclusion" class="layui-textarea">{$info.conclusion}</textarea>
            </div>
        </div>
        <div class="layui-form-item tr">
            <div class="layui-input-block">
                <button class="layui-btn layui-btn-normal w100 button" lay-submit lay-filter="formAnalysis">分析提交</button>
                {if condition="$info.status eq 2"}
                <button class="layui-btn layui-btn-normal" data-id="{$info.id}" lay-submit lay-filter="APPROVED">审核通过</button>
                <button class="layui-btn layui-btn-danger" data-id="{$info.id}" lay-submit lay-filter="REJECT">审核驳回</button>
                {/if}
            </div>
        </div>
    </div>
</div>
{/if}
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

        // 上传
        let uploadInst = upload.render({
            elem: '#upload' //绑定元素
            ,url: '/Manage/upload/image_upload' //上传接口
            ,exts: 'png|jpg|jpge|gif'
            ,multiple: true
            ,before: function (obj){
                layer.load(1);
            }
            ,done: function(res){
                //上传完毕回调
                console.log(res);
                if (res.code === 1) {
                    let html = $(".YanNanQiu-upload-list").html();
                    $(".YanNanQiu-upload-list").html(html + '<li style="margin: 2px">' +
                        '<a href="/upload/images/' + res.data + '" target="_blank">' +
                        '<img src="/upload/images/' + res.data + '">' +
                        '</a>' +
                        '<span><i class="fa fa-times"></i></span>' +
                        '<input type="hidden" name="competitor_image[]" value="/upload/images/' + res.data + '">' +
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
            });
            return false;
        });

        // 分析提交
        form.on('submit(formAnalysis)', function(data){
            let text = $(this).text(),
                button = $(this);
            $('button').attr('disabled',true);
            button.text('请稍候...');
            axios.post("{:url('analysis', ['id' => $info['id']])}", data.field, {
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

        // 审核通过
        form.on('submit(APPROVED)', function(data){
            let text = $(this).text(),
                button = $(this),
                id = $(this).data('id');
            layer.confirm('确定审核通过吗？',{icon:3,closeBtn:0,title:false,btnAlign:'c'},function(){
                $('button').attr('disabled',true);
                button.text('请稍候...');
                axios.post("{:url('approved')}", {id: id})
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
        });

        // 审核驳回
        form.on('submit(REJECT)', function(data){
            let text = $(this).text(),
                button = $(this),
                id = $(this).data('id');
            layer.confirm('确定驳回吗？',{icon:3,closeBtn:0,title:false,btnAlign:'c'},function(){
                $('button').attr('disabled',true);
                button.text('请稍候...');
                axios.post("{:url('reject')}", {id: id})
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
        });
    });
</script>

{include file="public/footer" /}
