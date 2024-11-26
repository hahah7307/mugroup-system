
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
                    <th>产品描述</th>
                    <th>采购价</th>
                    <th>采购价币种</th>
                    <th>开发建议</th>
                    <th>开发人员</th>
                </tr>
                </thead>
                <tbody>
                {foreach name="list" item="v"}
                <tr>
                    <td>{$v.id}</td>
                    <td>{$v.product_code}</td>
                    <td>{$v.supplier_name}</td>
                    <td>{$v.supplier_code}</td>
                    <td><img src="/{$v.img_url}" alt="" height="80"></td>
                    <td>{$v.product_length}</td>
                    <td>{$v.product_width}</td>
                    <td>{$v.product_height}</td>
                    <td>{$v.gross_weight}</td>
                    <td>{$v.net_weight}</td>
                    <td>{$v.product_desc}</td>
                    <td>{$v.cost}</td>
                    <td>{$v.currency}</td>
                    <td>{$v.suggestion}</td>
                    <td>{$v.developer.nickname}</td>
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

    });
</script>

{include file="public/footer" /}
