
{include file="public/header" /}

<style>
    .layui-layer-btn0 {background-color: #fff !important; color: #333 !important; border: 1px solid #dedede !important;}
    .layui-layer-btn1 {background-color: #1E9FFF !important; color: #fff !important; border: 1px solid #1E9FFF !important;}
    .layui-layer-btn2 {background-color: #FF5722 !important; color: #fff !important; border: 1px solid #FF5722 !important;}
</style>
<!-- 主体内容 -->
<div class="layui-body" id="LAY_app_body">
    <div class="right">
        <a href="{:url('Quote/table')}" class="layui-btn layui-btn-danger layui-btn-sm fr"><i class="layui-icon">&#xe603;</i>返回上一页</a>
        <div class="title">报价产品列表</div>
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
                    <option value="5" {if condition="$status eq 5"}selected{/if}>打样完成</option>
                    <option value="6" {if condition="$status eq 6"}selected{/if}>已完成</option>
                    <option value="7" {if condition="$status eq 7"}selected{/if}>已废弃</option>
                </select>
            </div>
            <div class="layui-inline">
                <button class="layui-btn" lay-submit lay-filter="Search"><i class="layui-icon">&#xe615;</i> 查询</button>
            </div>
        </form>

        <div class="layui-form">
            <table class="layui-table">
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
                    <col>
                    <col>
                    <col class="w100">
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
                    <th>地区</th>
                    <th>开发建议</th>
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
                    <td><a href="/{$v.img_url}" target="_blank"><img src="/{$v.img_url}" alt="" height="40"></a></td>
                    <td>{$v.product_length}</td>
                    <td>{$v.product_width}</td>
                    <td>{$v.product_height}</td>
                    <td>{$v.gross_weight}</td>
                    <td>{$v.net_weight}</td>
                    <td>{$v.product_desc}</td>
                    <td>{$v.cost}</td>
                    <td>{$v.currency}</td>
                    <td>{$v.region}</td>
                    <td>{$v.suggestion}</td>
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
                        {if condition="$role eq 'Super' or $role eq 'Developer'"}
                        <a href="{:url('accounting', ['id' => $v.id])}" class="layui-btn layui-btn layui-btn-sm">查看</a>
                        <button data-id="{$v.id}" class="layui-btn layui-btn-sm layui-btn-normal ml0" lay-submit lay-filter="Audit">审核</button>
                        {/if}
                        {if condition="$role eq 'Super' or $role eq 'Purchaser'"}
                        <a href="{:url('edit', ['id' => $v.id])}" class="layui-btn layui-btn-normal layui-btn-sm">编辑</a>
                        <button data-id="{$v.id}" class="layui-btn layui-btn-sm layui-btn-danger ml0" lay-submit lay-filter="Detele">删除</button>
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
                btn: ['意见', '通过', '废弃', '取消'],  // 三个按钮
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
                    axios.post("{:url('audit')}", {id: id})
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
                    axios.post("{:url('refuse')}", {id: id})
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
