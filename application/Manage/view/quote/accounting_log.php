
{include file="public/header" /}

<!-- 主体内容 -->
<div class="layui-body" id="LAY_app_body">
    <div class="right">
        <a href="{:session('back_url', '', 'manage')}" class="layui-btn layui-btn-danger layui-btn-sm fr"><i class="layui-icon">&#xe603;</i>返回上一页</a>
        <div class="title">核价记录</div>

        <div class="layui-form">
            <table class="layui-table" lay-size="sm">
                <colgroup>
                    <col class="w80">
                    <col>
                    <col>
                    <col>
                    <col class="w80">
                    <col class="w60">
                    <col class="w180">
                    <col class="w100">
                </colgroup>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>产品编号</th>
                    <th>采购价格（¥）</th>
                    <th>Fob价（$）</th>
                    <th>类型</th>
                    <th>创建人</th>
                    <th>创建时间</th>
                    <th class="tc">操作</th>
                </tr>
                </thead>
                <tbody>
                {foreach name="list" item="v"}
                <tr>
                    <td>{$v.id}</td>
                    <td>{$v.product_code}</td>
                    <td class="tr">{$v.cost}</td>
                    <td class="tr">{$v.fob}</td>
                    <td>{:$v['type'] == 1 ? '报价核价' : '样品核价'}</td>
                    <td>{$v.user.nickname}</td>
                    <td>{$v.created_time}</td>
                    <td class="tc">
                        <button data-url="{:url('Quote/accounting_detail', ['id' => $v['id']])}" class="layui-btn layui-btn-sm" lay-submit lay-filter="Detail">核价详情</button>
                    </td>
                </tr>
                {/foreach}
                </tbody>
            </table>
        </div>

    </div>
</div>
<script>
    layui.use(['form', 'upload', 'jquery'], function(){
        let $ = layui.jquery,
            upload = layui.upload,
            form = layui.form;

        form.on('submit(Detail)', function(data) {
            let url = $(this).data('url');

            let index = layer.open({
                type: 2,  // type: 2 表示使用 iframe
                title: '核价详情',
                area: ['80%', '80%']
            });

            // 使用 iframeSrc 动态改变 iframe 的 src
            layer.iframeSrc(index, url);  // 设置 iframe 的 URL
        });
    });
</script>

{include file="public/footer" /}
