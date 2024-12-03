
{include file="public/header" /}

<!-- 主体内容 -->
<div class="layui-body" id="LAY_app_body">
    <div class="right">
        <a href="{:session('manage.back_url')}" class="layui-btn layui-btn-danger layui-btn-sm fr"><i class="layui-icon">&#xe603;</i>返回上一页</a>
        <div class="title">编辑产品</div>
        <div class="layui-form">
            <div class="layui-form-item">
                <label class="layui-form-label">长</label>
                <div class="layui-input-inline w300">
                    <input type="text" class="layui-input" name="product_length" value="{$info.product_length}">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">宽</label>
                <div class="layui-input-inline w300">
                    <input type="text" class="layui-input" name="product_width" value="{$info.product_width}">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">高</label>
                <div class="layui-input-inline w300">
                    <input type="text" class="layui-input" name="product_height" value="{$info.product_height}">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">毛重</label>
                <div class="layui-input-inline w300">
                    <input type="text" class="layui-input" name="gross_weight" value="{$info.gross_weight}">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">净重</label>
                <div class="layui-input-inline w300">
                    <input type="text" class="layui-input" name="net_weight" value="{$info.net_weight}">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">产品描述</label>
                <div class="layui-input-inline w300">
                    <textarea name="product_desc" class="layui-textarea">{$info.product_desc}</textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">含税出厂价（人民币）</label>
                <div class="layui-input-inline w300">
                    <input type="text" class="layui-input" name="cost" value="{$info.cost}">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">FOB价（美金）</label>
                <div class="layui-input-inline w300">
                    <input type="text" class="layui-input" name="fob" value="{$info.fob}">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">推荐销售市场</label>
                <div class="layui-input-inline w300">
                    <input type="text" class="layui-input" name="region" value="{$info.region}">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">推荐理由</label>
                <div class="layui-input-inline w300">
                    <textarea name="recommendation_reason" class="layui-textarea">{$info.recommendation_reason}</textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">竞品链接</label>
                <div class="layui-input-inline w300">
                    <textarea name="purchaser_competitor_url" class="layui-textarea">{$info.purchaser_competitor_url}</textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">是否多箱装</label>
                <div class="layui-input-block">
                    <input type="radio" name="is_multiple_boxes" value="0" title="否" {if condition="$info.is_multiple_boxes eq 0"}checked{/if}>
                    <input type="radio" name="is_multiple_boxes" value="1" title="是" {if condition="$info.is_multiple_boxes eq 1"}checked{/if}>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn w200" lay-submit lay-filter="formCoding">提交保存</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
    layui.use(['form', 'jquery', 'laydate'], function(){
        var $ = layui.jquery,
            form = layui.form,
            laydate = layui.laydate;

        // 显示日期选择器
        laydate.render({
            elem: '#sample_date',
            type: 'date'
        });

        //监听提交
        form.on('submit(formCoding)', function(data){
            var text = $(this).text(),
                button = $(this);
            $('button').attr('disabled',true);
            button.text('请稍候...');
            axios.post("{:url('edit', ['id' => $info['id']])}", data.field)
                .then(function (response) {
                    var res = response.data;
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
</script>

{include file="public/footer" /}
