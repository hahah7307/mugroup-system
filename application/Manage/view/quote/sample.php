
{include file="public/header" /}

<style>
    .layui-layer-btn0 {background-color: #fff !important; color: #333 !important; border: 1px solid #dedede !important;}
    .layui-layer-btn1 {background-color: #1E9FFF !important; color: #fff !important; border: 1px solid #1E9FFF !important;}
    .layui-layer-btn2 {background-color: #FF5722 !important; color: #fff !important; border: 1px solid #FF5722 !important;}
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
        {if condition="$role neq 'Developer'"}
        <a href="{:url('Quote/table')}" class="layui-btn layui-btn-danger layui-btn-sm fr"><i class="layui-icon">&#xe603;</i>返回上一页</a>
        {/if}
        <div class="title">报价列表</div>
        <form class="layui-form search-form" method="get">
            <div class="layui-inline w200">
                <input type="text" class="layui-input" name="keyword" value="{$keyword}" placeholder="">
            </div>
            <div class="layui-inline w120">
                <select name="status" lay-verify="">
                    <option value="-1">状态</option>
                    <option value="0" {if condition="$status eq '0'"}selected{/if}>待核价</option>
                    <option value="1" {if condition="$status eq 1"}selected{/if}>待分析</option>
                    <option value="2" {if condition="$status eq 2"}selected{/if}>待审核</option>
                    <option value="3" {if condition="$status eq 3"}selected{/if}>待打样</option>
                    <option value="4" {if condition="$status eq 4"}selected{/if}>打样中</option>
                    <option value="5" {if condition="$status eq 5"}selected{/if}>样品待核价</option>
                    <option value="6" {if condition="$status eq 6"}selected{/if}>样品待分析</option>
                    <option value="7" {if condition="$status eq 7"}selected{/if}>样品待审核</option>
                    <option value="8" {if condition="$status eq 8"}selected{/if}>样品通过</option>
                    <option value="11" {if condition="$status eq 11"}selected{/if}>报价失败</option>
                    <option value="12" {if condition="$status eq 12"}selected{/if}>样品失败</option>
                </select>
            </div>
            <div class="layui-inline">
                <button class="layui-btn" lay-submit lay-filter="Search"><i class="layui-icon">&#xe615;</i> 查询</button>
            </div>
        </form>

        <div class="layui-form">
            <table class="layui-table" lay-size="sm">
                <colgroup>
                    <col class="w100">
                    <col>
                    <col>
                    <col>
                    <col>
                    <col>
                    <col>
                    <col>
                    <col>
                    <col class="w60">
                    <col class="w60">
                    <col class="w100">
                    <col class="w150">
                    <col class="w200">
                </colgroup>
                <thead>
                <tr>
                    <th>产品编号</th>
                    <th>产品图片</th>
                    <th>包装尺寸</th>
                    <th class="tc">产品描述</th>
                    <th>含税出厂价（¥）</th>
                    <th>FOB价（$）</th>
                    <th>推荐市场</th>
                    <th>采购推荐理由</th>
                    <th>采购竞品链接</th>
                    <th>采购</th>
                    <th>开发</th>
                    <th class="tc">状态</th>
                    <th class="tc">创建时间</th>
                    <th class="tc">操作</th>
                </tr>
                </thead>
                <tbody>
                {foreach name="list" item="v"}
                <tr>
                    <td>{$v.product_code}</td>
                    <td><a href="/{$v.img_url}" target="_blank"><img src="/{$v.img_url}" alt="" height="40"></a></td>
                    <td>{$v.product_length}*{$v.product_width}*{$v.product_height}<br>{$v.gross_weight}({$v.net_weight})</td>
                    <td>{$v.product_desc}</td>
                    <td>{$v.cost}</td>
                    <td>{$v.fob}</td>
                    <td>{$v.region}</td>
                    <td>{$v.recommendation_reason}</td>
                    <td class="purchaser_competitor_url">{$v.purchaser_competitor_url|combineUrl2html=###, ','}</td>
                    <td>{$v.purchaser.nickname}</td>
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
                        <p class="blue">样品待核价</p>
                        {elseif condition="$v.status eq 6" /}
                        <p class="blue">样品待分析</p>
                        {elseif condition="$v.status eq 7" /}
                        <p class="blue">样品待审核</p>
                        {elseif condition="$v.status eq 8" /}
                        <p class="green">样品通过</p>
                        {elseif condition="$v.status eq 11" /}
                        <p class="red">报价失败</p>
                        {elseif condition="$v.status eq 12" /}
                        <p class="red">样品失败</p>
                        {/if}
                    </td>
                    <td>{$v.quote.created_time}</td>
                    <td class="tc">
                        {if condition="$role eq 'Super' or $role eq 'Developer'"}
                        <a href="{:url('accounting', ['id' => $v.id])}" class="layui-btn layui-btn layui-btn-sm">查看</a>
                        <a href="{:url('transfer', ['id' => $v.id])}" class="layui-btn layui-btn layui-btn-sm">转交</a>
                        <a href="{:url('accounting_log', ['id' => $v.id])}" class="layui-btn layui-btn layui-btn-sm">核价记录</a>
                        {/if}
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
    layui.use(['form', 'upload', 'jquery', 'layer'], function(){
        let $ = layui.jquery,
            upload = layui.upload,
            form = layui.form,
            layer = layui.layer;

        // 监听按钮点击事件，打开带输入框的弹出层
        form.on('submit(Audit)', function(data){
            let text = $(this).text(),
                button = $(this),
                id = $(this).data('id');
            $('button').attr('disabled',true);
            button.text('请稍候...');
            layer.open({
                type: 1,  // 页面层
                title: '开发意见',  // 弹出层标题
                content: '<div style="padding: 20px;">' +
                    '<input type="text" id="inputValue" class="layui-input" placeholder="请填写开发意见" />' +
                    '</div>',  // 弹出层内容，包含输入框
                area: ['400px', '200px'],  // 设置弹出层的大小
                btn: ['修改意见', '审核通过', '样品失败', '关闭'],  // 三个按钮
                yes: function(index, layero){
                    let userInput = $("#inputValue").val();  // 获取输入框的值
                    axios.post("{:url('suggestion')}", {id: id, suggestion: userInput})
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
                    axios.post("{:url('audit')}", {id: id, suggestion: userInput})
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
                    axios.post("{:url('refuse')}", {id: id, suggestion: userInput})
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
