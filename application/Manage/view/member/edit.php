
{include file="public/header" /}

<!-- 主体内容 -->
<style type="text/css">
	#ul-info {padding-left:0; margin-bottom: 0}
</style>
<div class="layui-body" id="LAY_app_body">
    <div class="right">
		<a href="{:session('manage.back_url')}" class="layui-btn layui-btn-danger layui-btn-sm fr"><i class="layui-icon">&#xe603;</i>返回上一页</a>
		<div class="title">编辑{$tag}</div>

		<div class="layui-form">
			<div class="layui-form-item">
				<label class="layui-form-label">Logo</label>
				<div class="layui-input-inline w300">
					<input type="text" class="layui-input" name="logo" style="display: none;">
					<span class="input-group-btn">
						<button type="button" name="logo" class="layui-btn layui-btn-primary layui-btn-sm YanNanQiu_ViewsUploader">选择图片</button>
						<ul class="YanNanQiu-upload-list">
						{if condition="$info.logo neq null"}
							<li style="margin: 2px">
								<img src="/upload/{$info.logo}">
								<span>
									<i class="fa fa-times"></i>
								</span>
								<input type="hidden" name="logo[]" value="{$info.logo}">
							</li>
						{/if}
						</ul>
					</span>
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">企业名称</label>
				<div class="layui-input-inline w300">
					<input type="text" class="layui-input" name="company_name" value="{$info.company_name}">
				</div>
				<label class="layui-form-label">企业性质</label>
				<div class="layui-input-inline w300">
					<input type="text" class="layui-input" name="company_property" value="{$info.company_property}">
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">企业地址</label>
				<div class="layui-input-inline w720">
					<input type="text" class="layui-input" name="company_address" value="{$info.company_address}">
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">法人代表</label>
				<div class="layui-input-inline w300">
					<input type="text" class="layui-input" name="legal_name" value="{$info.legal_name}">
				</div>
				<label class="layui-form-label">法人手机</label>
				<div class="layui-input-inline w300">
					<input type="text" class="layui-input" name="legal_tel" value="{$info.legal_tel}">
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">法人电话</label>
				<div class="layui-input-inline w300">
					<input type="text" class="layui-input" name="legal_phone" value="{$info.legal_phone}">
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">联系人姓名</label>
				<div class="layui-input-inline w300">
					<input type="text" class="layui-input" name="lxr_name" value="{$info.lxr_name}">
				</div>
				<label class="layui-form-label">联系人职位</label>
				<div class="layui-input-inline w300">
					<input type="text" class="layui-input" name="lxr_post" value="{$info.lxr_post}">
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">联系人手机</label>
				<div class="layui-input-inline w300">
					<input type="text" class="layui-input" name="lxr_tel" value="{$info.lxr_tel}">
				</div>
				<label class="layui-form-label">联系人电话</label>
				<div class="layui-input-inline w300">
					<input type="text" class="layui-input" name="lxr_phone" value="{$info.lxr_phone}">
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">网址</label>
				<div class="layui-input-inline w300">
					<input type="text" class="layui-input" name="site_url" value="{$info.site_url}">
				</div>
				<label class="layui-form-label">邮箱</label>
				<div class="layui-input-inline w300">
					<input type="text" class="layui-input" name="email" value="{$info.email}">
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">传真</label>
				<div class="layui-input-inline w300">
					<input type="text" class="layui-input" name="fax" value="{$info.fax}">
				</div>
				<label class="layui-form-label">QQ/微信</label>
				<div class="layui-input-inline w300">
					<input type="text" class="layui-input" name="qq_wechat" value="{$info.qq_wechat}">
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">企业简介</label>
				<div class="layui-input-inline w720">
					<textarea name="company_profile" placeholder="" class="layui-textarea">{$info.company_profile}</textarea>
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">主要产品</label>
				<div class="layui-input-inline w720">
					<textarea name="products" placeholder="" class="layui-textarea">{$info.products}</textarea>
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">通过认证</label>
				<div class="layui-input-inline w720">
					<textarea name="certification" placeholder="" class="layui-textarea">{$info.certification}</textarea>
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">企业别名</label>
				<div class="layui-input-inline w300">
					<input type="text" class="layui-input" name="slug" value="{$info.slug}">
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">职位</label>
				<div class="layui-input-inline w300">
					<input type="hidden" name="rank">
            		<div id="rank" class="xm-select-demo"></div>
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">状态</label>
				<div class="layui-input-block">
					<input type="radio" name="status" value="1" title="开启" {if condition="$info.status eq 1"}checked{/if}>
					<input type="radio" name="status" value="0" title="关闭" {if condition="$info.status eq 0"}checked{/if}>
				</div>
			</div>
			<div class="layui-form-item">
				<div class="layui-input-block">
					<button class="layui-btn w200 button" lay-submit lay-filter="formCoding">提交保存</button>
				</div>
			</div>
		</div>

    </div>
</div>
<script src="/static/manage/js/uploader-use.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src='/static/manage/js/tinymce/js/tinymce/tinymce.min.js'></script>
<script>
layui.use(['form', 'jquery'], function(){
	var $ = layui.jquery,
		form = layui.form;

    // 下拉框多选
    var cid = xmSelect.render({
        el: '#rank',
        name: 'rank',
        layVerify: 'required',
        filterable: true,
        remoteSearch: true,
        remoteMethod: function(val, cb, show){
            axios({
                method: 'post',
                url: '/Manage/Check/get_full_memberRank',
                data: {rank: "{$info.rank}", keyword: val},
                params: {
                    keyword: val,
                }
            }).then(response => {
                var res = response.data;
                cb(res.data)
            }).catch(err => {
                cb([]);
            });
        },
        data: []
    })

	// 提交
	form.on('submit(formCoding)', function(data) {
		var text = $(this).text(),
			button = $(this);
		$('button').attr('disabled',true);
		button.text('请稍候...');
		$.ajax({
			type:'POST',url:"{:url('edit', ['id' => $info['id']])}",data:data.field,dataType:'json',
			success:function(data){
				if(data.code == 1){
					layer.alert(data.msg,{icon:1,closeBtn:0,title:false,btnAlign:'c'},function(){
						location.href = "{:url('index')}";
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
		return false;
	});

});
</script>

{include file="public/footer" /}
