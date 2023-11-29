
{include file="public/header" /}

<!-- 主体内容 -->
<div class="layui-body" id="LAY_app_body">
    <div class="right">
        <div class="title">图册列表</div>
		<form class="layui-form search-form" method="get">
			<div class="layui-inline w80">
				<select name="sort">
					<option value="asc" {if condition="$sort eq 'asc'"}selected{/if}>正序</option>
					<option value="desc" {if condition="$sort eq 'desc'"}selected{/if}>倒序</option>
				</select>
			</div>
			<div class="layui-inline w150">
				<select name="cid">
					<option value="0">请选择分类</option>
					{foreach name="category" item="cate"}
					<option value="{$cate.id}" {if condition="$cid eq $cate['id']"}selected{/if}>{$cate.name}</option>
					{/foreach}
				</select>
			</div>
			<div class="layui-inline">
				<input type="text" class="layui-input" name="keyword" value="{$keyword}" placeholder="搜索图片名称">
			</div>
			<div class="layui-inline">
				<button class="layui-btn" lay-submit lay-filter="Search"><i class="layui-icon">&#xe615;</i> 搜索</button>
			</div>
			<div class="layui-inline">
				<a class="layui-btn layui-btn-normal" href="{:url('index')}"><i class="layui-icon">&#xe621;</i> 重置</a>
			</div>
		</form>

		<div class="layui-form">
			<button type="button" class="layui-btn YanNanQiu_SubUploaderall" style="margin-right: 5px">上传</button>
            <button type="submit" class="layui-btn layui-btn-danger" lay-submit="" lay-filter="DelImgAll">删除</button>
            <div class="layui-inline">
            	<div class="YanNanQiu_CheckAllbox"><input type="checkbox" lay-skin="primary" id="YanNanQiu_checkall" lay-filter="YanNanQiu_checkall" title="全选"></div>
            </div>
            <div class="YanNanQiu_UploaderManage">
                <ul class="YanNanQiu-UploaderList">
                	{foreach name="list" item="v"}
                   	<li>
                        <div class="YanNanQiu_img">
                            <img src="{$v.url|imageurl_to_path}">
                        </div>
                        <a href="javascript:;" class="YanNanQiu_imgViews" data-url="{$v.url|imageurl_to_path}"><cite class="layui-icon layui-icon-picture"></cite></a>
                        <a href="javascript:;" class="YanNanQiu_imgEdits" data-url="{$v.url|imageurl_to_path}" data-id="{$v.id}"><cite class="layui-icon layui-icon-edit"></cite></a>
                        <div class="YanNanQiu_Checkbox">
                            <input type="checkbox" name="img[]" lay-skin="primary" lay-filter="imgbox" class="YanNanQiu_imgId" value="{$v.id}">
                        </div>
                        <div class="YanNanQiu_ImgTitle">{$v.title}</div>
                    </li>
                    {/foreach}
                </ul>
            </div>
            {$list->render()}
		</div>

    </div>
</div>
<button type="button" class="YanNanQiu_SubUploaderall_img" style="display: none;"></button>
<div id="form-select" style="display: none;width: 80%;padding-top: 20px">
    <form class="layui-form">
        <div class="layui-form-item form-input">
            <label class="layui-form-label">标题</label>
            <div class="layui-input-block">
                <input type="text" name="title" placeholder="请输入标题" autocomplete="off" class="layui-input" id="form-title">
            </div>
        </div>
    </form>
</div>
<div id="form-edit" style="display: none;width: 80%;padding-top: 20px">
    <form class="layui-form">
        <div class="layui-form-item form-input">
            <label class="layui-form-label">标题</label>
            <div class="layui-input-block">
                <input type="text" name="title" placeholder="请输入标题" autocomplete="off" class="layui-input">
            </div>
        </div>
        <button type="button" class="layui-btn" lay-submit lay-filter="formSubmit" style="display: none" id="form-submit">立即提交</button>
    </form>
</div>
<script src="/static/manage/js/uploader.js"></script>
<script>
layui.use(['form', 'jquery'], function(){
	var $ = layui.jquery,
		form = layui.form;

});
</script>

{include file="public/footer" /}
