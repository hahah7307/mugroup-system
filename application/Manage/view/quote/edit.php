
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
                    <textarea name="" class="layui-textarea">{$info.product_desc}</textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">采购价</label>
                <div class="layui-input-inline w300">
                    <input type="text" class="layui-input" name="cost" value="{$info.cost}">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">采购价币种</label>
                <div class="layui-input-inline w300">
                    <input type="text" class="layui-input" name="currency" value="{$info.currency}">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">地区</label>
                <div class="layui-input-inline w300">
                    <input type="text" class="layui-input" name="region" value="{$info.region}">
                </div>
            </div>
            {if condition="$info.status egt 3"}
            <div class="layui-form-item">
                <label class="layui-form-label">完成时间</label>
                <div class="layui-input-inline w300">
                    <input type="text" class="layui-input" id="sample_date" name="sample_date" placeholder="打样完成时间">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">打样完成</label>
                <div class="layui-input-block">
                    <input type="checkbox" name="is_sample" value="1" lay-skin="switch">
                </div>
            </div>
            {/if}
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
