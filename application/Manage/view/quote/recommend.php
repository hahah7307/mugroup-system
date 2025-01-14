
{include file="public/header" /}

<style>
    .total {padding: 0 10px}
</style>
<!-- 主体内容 -->
<div class="layui-body" id="LAY_app_body">
    <div class="right">
        <div class="title">推荐计数</div>
        <form class="layui-form search-form" method="get">
            <div class="layui-input-inline">
                <input type="text" class="layui-input" id="month" name="month" value="{$month}" placeholder="月份">
            </div>
            <div class="layui-inline">
                <button class="layui-btn" lay-submit lay-filter="Search"><i class="layui-icon">&#xe615;</i> 查询</button>
            </div>
        </form>

        <span class="total">月推荐合计：{$monthSum}</span>

        <table class="layui-table">
            <colgroup>
                <col>
                <col>
            </colgroup>
            <thead>
            <tr>
                <th>采购人员</th>
                <th>月推荐合计</th>
            </tr>
            </thead>
            <tbody>
            {foreach name="list" item="v"}
            <tr>
                <td>{$v.nickname}</td>
                <td>{$v.count}</td>
            </tr>
            {/foreach}
            </tbody>
        </table>
    </div>
</div>
<script>
    layui.use(['form', 'jquery', 'laydate'], function(){
        let $ = layui.jquery,
            form = layui.form,
            laydate = layui.laydate;

        //执行一个laydate实例
        laydate.render({
            elem: '#month' //指定元素
            ,type: 'month'
        });
    });
</script>

{include file="public/footer" /}
