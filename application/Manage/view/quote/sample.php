
{include file="public/header" /}

<!-- 主体内容 -->
<div class="layui-body" id="LAY_app_body">
    <div class="right">
        <a href="{:url('Quote/table')}" class="layui-btn layui-btn-danger layui-btn-sm fr"><i class="layui-icon">&#xe603;</i>返回上一页</a>
        <div class="title">报价产品列表</div>
        <form class="layui-form search-form" method="get">
            <div class="layui-inline w200">
                <input type="text" class="layui-input" name="keyword" value="{$keyword}" placeholder="">
            </div>
            <div class="layui-inline">
                <button class="layui-btn" lay-submit lay-filter="Search"><i class="layui-icon">&#xe615;</i> 查询</button>
            </div>
        </form>

        <div class="layui-form">
            <table class="layui-table" lay-size="sm">
                <colgroup>
                    <col class="w80">
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
                    <col class="w180">
                </colgroup>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>产品编号</th>
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
                    <th>状态</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                {foreach name="list" item="v"}
                <tr>
                    <td>{$v.id}</td>
                    <td>{$v.product_code}</td>
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
                    <td>{$v.status}</td>
                    <td class="tc">
                        <a href="{:url('accounting', ['id' => $v.id])}" class="layui-btn layui-btn-normal layui-btn-sm">核价</a>
                        <a href="{:url('index_edit', ['id' => $v.id])}" class="layui-btn layui-btn-normal layui-btn-sm">编辑</a>
                        <button data-id="{$v.id}" class="layui-btn layui-btn-sm layui-btn-danger ml0" lay-submit lay-filter="Detele">删除</button>
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

    });
</script>

{include file="public/footer" /}
