
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
                        <a href="{:url('accounting', ['id' => $v.id])}" class="layui-btn layui-btn layui-btn-sm">查看</a>
                        <a href="{:url('edit', ['id' => $v.id])}" class="layui-btn layui-btn-normal layui-btn-sm">编辑</a>
                        <button data-id="{$v.id}" class="layui-btn layui-btn-sm layui-btn-normal ml0" lay-submit lay-filter="Audit">打样审核</button>
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

    });
</script>

{include file="public/footer" /}
