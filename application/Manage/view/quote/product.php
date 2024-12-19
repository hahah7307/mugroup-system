
{include file="public/header" /}

<style>
    .layui-table .purchaser_competitor_url {
        max-width: 120px;      /* 设置单元格最大宽度 */
        white-space: nowrap;   /* 防止换行 */
        overflow: hidden;      /* 超出部分隐藏 */
        text-overflow: ellipsis; /* 超出部分显示省略号 */
    }
</style>
<!-- 主体内容 -->
<div class="layui-body" id="LAY_app_body">
    <div class="right">
        <a href="{:url('Quote/table')}" class="layui-btn layui-btn-danger layui-btn-sm fr"><i class="layui-icon">&#xe603;</i>返回上一页</a>
        <div class="title">产品列表</div>

        <div class="layui-form">
            <table class="layui-table" lay-size="sm">
                <colgroup>
                    <col>
                    <col class="w180">
                    <col class="w120">
                    <col>
                    <col>
                    <col>
                    <col>
                    <col>
                    <col>
                    <col>
                    <col>
                    <col>
                    <col>
                    <col>
                    <col>
                    <col>
                    <col>
                    <col>
                    <col class="w180">
                </colgroup>
                <thead>
                <tr>
                    <th>产品编号</th>
                    <th>供应商名称</th>
                    <th>供应商初代码</th>
                    <th>产品图片</th>
                    <th>外箱长（cm）</th>
                    <th>外箱宽（cm）</th>
                    <th>外箱高（cm）</th>
                    <th>外箱毛重（kg）</th>
                    <th>产品净重（kg）</th>
                    <th class="tc">产品描述</th>
                    <th>含税出厂价（人民币）</th>
                    <th>FOB价（美金）</th>
                    <th>推荐市场</th>
                    <th>采购推荐理由</th>
                    <th>采购竞品链接</th>
                    <th>多箱装</th>
                    <th>开发人员</th>
                    <th class="tc">状态</th>
                    <th class="tc">操作</th>
                </tr>
                </thead>
                <tbody>
                {foreach name="list" item="v"}
                <tr>
                    <td>{$v.product_code}</td>
                    <td>{$v.supplier_name}</td>
                    <td>{$v.supplier_code}</td>
                    <td><img src="/{$v.img_url}" alt="" height="40"></td>
                    <td>{$v.product_length}</td>
                    <td>{$v.product_width}</td>
                    <td>{$v.product_height}</td>
                    <td>{$v.gross_weight}</td>
                    <td>{$v.net_weight}</td>
                    <td>{$v.product_desc}</td>
                    <td>{$v.cost}</td>
                    <td>{$v.fob}</td>
                    <td>{$v.region}</td>
                    <td>{$v.recommendation_reason}</td>
                    <td class="purchaser_competitor_url">{$v.purchaser_competitor_url|combineUrl2html=###, ','}</td>
                    <td class="tc">{:$v.is_multiple_boxes == 1 ? '<span class="red">是</span>' : '否'}</td>
                    <td>{$v.developer.nickname}</td>
                    <td class="tc">
                        {if condition="$v.status eq 0"}
                        <p class="blue">待核价</p>
                        {elseif condition="$v.status eq 1"/}
                        <p class="blue">待分析</p>
                        {elseif condition="$v.status eq 2" /}
                        <p class="blue">待审核</p>
                        {elseif condition="$v.status eq 3" /}
                        <p class="blue">待打样</p>
                        {elseif condition="$v.status eq 4" /}
                        <p class="blue">打样中</p>
                        {elseif condition="$v.status eq 5" /}
                        <p class="blue">打样完成</p>
                        {elseif condition="$v.status eq 6" /}
                        <p class="green">审核通过</p>
                        {elseif condition="$v.status eq 7" /}
                        <p class="red">未过审核</p>
                        {elseif condition="$v.status eq 8" /}
                        <p class="red">样品失败</p>
                        {/if}
                    </td>
                    <td class="tc">
                        <a href="{:url('edit', ['id' => $v.id])}" class="layui-btn layui-btn-normal">编辑</a>
                        <button data-id="{$v.id}" class="layui-btn layui-btn-danger ml0" lay-submit lay-filter="Detele">删除</button>
                    </td>
                </tr>
                {/foreach}
                </tbody>
            </table>
            {$list->render()}
        </div>

    </div>
</div>
<script>
    layui.use(['form', 'upload', 'jquery'], function(){
        let $ = layui.jquery,
            upload = layui.upload,
            form = layui.form;

        // 删除
        form.on('submit(Detele)', function(data){
            var text = $(this).text(),
                button = $(this),
                id = $(this).data('id');
            layer.confirm('确定删除吗？',{icon:3,closeBtn:0,title:false,btnAlign:'c'},function(){
                $('button').attr('disabled',true);
                button.text('请稍候...');
                $.ajax({
                    type:'POST',url:"{:url('delete')}",data:{id:id},dataType:'json',
                    success:function(data){
                        if(data.code === 1){
                            layer.alert(data.msg,{icon:1,closeBtn:0,title:false,btnAlign:'c'},function(){
                                location.reload();
                            });
                        }else{
                            layer.alert(data.msg,{icon:2,closeBtn:0,title:false,btnAlign:'c'},function(){
                                layer.closeAll();
                                $('button').attr('disabled',false);
                                button.text(text);
                            });
                        }
                    }
                });
            });
        });
    });
</script>

{include file="public/footer" /}
