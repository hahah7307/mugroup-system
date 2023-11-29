
{include file="public/header" /}

<!-- 主体内容 -->
<div class="layui-body" id="LAY_app_body">
    <div class="right">
        <div class="title">控制台</div>

		<div class="layui-card-body">
			<div class="layui-carousel layadmin-carousel layadmin-backlog">
				<ul class="layui-row layui-col-space10 layui-this">
					<li class="layui-col-xs3">
						<a href="{:url('Member/index')}" class="layadmin-backlog-body">
							<h3>会员</h3>
							<p>
								<cite>{:count($member)}</cite>
								<i class="layui-icon iconfont icon-huiyuan"></i>
							</p>
						</a>
					</li>
					<li class="layui-col-xs3">
						<a href="{:url('Notice/index')}" class="layadmin-backlog-body">
							<h3>公告</h3>
							<p>
								<cite>{:count($notice)}</cite>
								<i class="layui-icon iconfont icon-gonggao"></i>
							</p>
						</a>
					</li>
					<li class="layui-col-xs3">
						<a href="{:url('Article/index')}" class="layadmin-backlog-body">
							<h3>文章</h3>
							<p>
								<cite>{:count($article)}</cite>
								<i class="layui-icon iconfont icon-wenzhang"></i>
							</p>
						</a>
					</li>
					<li class="layui-col-xs3">
						<a href="{:url('Page/index')}" class="layadmin-backlog-body">
							<h3>单页</h3>
							<p>
								<cite>{:count($page)}</cite>
								<i class="layui-icon iconfont icon-danye"></i>
							</p>
						</a>
					</li>
				</ul>
			</div>
		</div>

		<div class="console-block fl">
			<table class="layui-table" lay-even lay-skin="nob">
				<thead>
					<tr>
						<th>最受关注的文章</th>
						<th class="tr view-more"><a href="{:url('Article/index')}">查看更多>></a></h3></th>
					</tr> 
				</thead>
				<tbody>
					{foreach name="article_list" item="article"}
					<tr>
						<td>
							<a href="/news/{$article.slug}.html" target="_blank">{$article.title}</a>
						</td>
						<td class="tr">{$article.view_num}</td>
					</tr>
					{/foreach}
				</tbody>
			</table>
		</div>
		<div class="clear"></div>

    </div>
</div>

{include file="public/footer" /}
