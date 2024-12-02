
{include file="public/header" /}

<!-- 主体内容 -->
<div class="layui-body" id="LAY_app_body">
    <div class="right">
        <a href="{:url('Quote/table')}" class="layui-btn layui-btn-danger layui-btn-sm fr"><i class="layui-icon">&#xe603;</i>返回上一页</a>
        <div class="title">产品列表</div>

        <div class="layui-form">
            <table class="layui-table">
                <colgroup>
                    <col class="w80">
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
                    <col class="w180">
                </colgroup>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>产品编号</th>
                    <th>供应商名称</th>
                    <th>供应商代码</th>
                    <th>产品图片</th>
                    <th>长（cm）</th>
                    <th>宽（cm）</th>
                    <th>高（cm）</th>
                    <th>毛重（kg）</th>
                    <th>净重（kg）</th>
                    <th class="tc">产品描述</th>
                    <th>采购价</th>
                    <th>采购价币种</th>
                    <th>销售地区</th>
                    <th>开发人员</th>
                    <th class="tc">状态</th>
                    <th class="tc">操作</th>
                </tr>
                </thead>
                <tbody>
                {foreach name="list" item="v"}
                <tr>
                    <td>{$v.id}</td>
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
                    <td>{$v.currency}</td>
                    <td>{$v.region}</td>
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
                        <p class="green">已完成</p>
                        {elseif condition="$v.status eq 7" /}
                        <p class="red">已废弃</p>
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
