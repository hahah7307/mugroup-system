<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:90:"D:\phpstudy_pro\WWW\hardware-tools\public/../application/Home\view\default\index\index.php";i:1607477226;s:82:"D:\phpstudy_pro\WWW\hardware-tools\application\Home\view\default\public\header.php";i:1607996284;s:82:"D:\phpstudy_pro\WWW\hardware-tools\application\Home\view\default\public\footer.php";i:1607561991;}*/ ?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<?php if($info != null): ?>
		<title><?php if($info['seo_title']): ?><?php echo $info['seo_title']; else: ?>宁波鄞州区五金工具国际商会<?php endif; ?></title>
		<meta name="keywords" content="<?php echo $info['seo_keyword']; ?>"/>
		<mate name="description" content="<?php echo $info['seo_description']; ?>"/>
		<?php else: ?>
		<title><?php if($info['seo_title']): ?><?php echo $website['seo_title']; else: ?>宁波鄞州区五金工具国际商会<?php endif; ?></title>
		<meta name="keywords" content="<?php echo $website['seo_keyword']; ?>"/>
		<mate name="description" content="<?php echo $website['seo_description']; ?>"/>
		<?php endif; ?>
		<link rel="stylesheet" href="/static/home/css/css.css">
		<script src="/static/home/js/jquery.min.js" type="text/javascript"></script>
		<script src="/static/home/js/layui/layui.js" type="text/javascript"></script>
		<script src="/static/home/js/ft-carousel.min.js" type="text/javascript"></script>
		<script src="/static/home/js/main.js" type="text/javascript"></script>
	</head>
	<body>
<!--新样式-->
<section class="ynq-header" pc>
	<div width="1200px">
		<div class="ynq-header-tools" flex="">
			<a href="<?php echo jump('Member/page'); ?>">入会申请</a>
			<!-- |<div class="ynq-search-btn">
				<a href="javascript:;"><i class="fa fa-search"></i></a>
				<div class="ynq-header-search">
					<form action="">
						<input type="text" name="keyword" placeholder="请输入关键字">
						<button><i class="fa fa-search"></i></button>
					</form>
				</div>
			</div> -->
		</div>
	</div>
	
	<div width="1200px" flex="">
		<div class="ynq-headerlogo"><a href="/"><img src="<?php echo imageurl_to_path($website['logo']); ?>" alt=""></a></div>
		<div class="ynq-header-menu">
			<ul flex="" class="ynq-header-menunav">
				<?php if(is_array($navigation) || $navigation instanceof \think\Collection || $navigation instanceof \think\Paginator): if( count($navigation)==0 ) : echo "" ;else: foreach($navigation as $key=>$navi): ?>
				<li><a href="<?php echo $navi['nav_url']; ?>"><?php echo $navi['nav_name']; ?></a>
					<?php if($navi['dropdown'] == 1): ?>
					<ul class="ynq-headerSmnav">
						<?php if(is_array($navi['child']) || $navi['child'] instanceof \think\Collection || $navi['child'] instanceof \think\Paginator): if( count($navi['child'])==0 ) : echo "" ;else: foreach($navi['child'] as $key=>$nav): ?>
						<li><a href="<?php echo $nav['nav_url']; ?>"><?php echo $nav['nav_name']; ?></a></li>
						<?php endforeach; endif; else: echo "" ;endif; ?>
					</ul>
					<?php endif; ?>
				</li>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
		</div>
    </div>
</section>

<section class="ynq-mob-header" flex="" mob>
	<div class="ynq-moblie-logo"><img src="<?php echo imageurl_to_path($website['logo']); ?>" alt=""></div>
	<div class="ynq-mob-menu" flex="">
		<div class="ynq-mob-search"><a href="javascript:;"><i class="fa fa-search"></i></a>
		<div class="ynq-mob-searchform">
			<form action="">
				<input type="text" name="keyword" placeholder="请输入关键字">
				<button><i class="fa fa-search"></i></button>
			</form>
		</div>
		</div>
		<div class="ynq-mob-nav"><a href="javascript:;"><i class="fa fa-bars"></i></a>
		 <ul class="ynq-mob-navlist">
			<?php if(is_array($navigation) || $navigation instanceof \think\Collection || $navigation instanceof \think\Paginator): if( count($navigation)==0 ) : echo "" ;else: foreach($navigation as $key=>$navi): ?>
			<li><a href="<?php echo $navi['nav_url']; ?>"><?php echo $navi['nav_name']; ?></a>
				<?php if($navi['dropdown'] == 1): ?>
				<ul class="ynq-mob-smnav">
					<?php if(is_array($navi['child']) || $navi['child'] instanceof \think\Collection || $navi['child'] instanceof \think\Paginator): if( count($navi['child'])==0 ) : echo "" ;else: foreach($navi['child'] as $key=>$nav): ?>
					<li><a href="<?php echo $nav['nav_url']; ?>"><?php echo $nav['nav_name']; ?></a></li>
					<?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>
				<?php endif; ?>
			</li>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		 </ul>
		</div>
	</div>
</section>

<section class="ynq-baner-swiper">
	<div class="layui-carousel" id="ynq-indexSwiper" lay-filter="ynq-indexSwiper">
	  <ul carousel-item="">
		  <?php if(is_array($block) || $block instanceof \think\Collection || $block instanceof \think\Paginator): if( count($block)==0 ) : echo "" ;else: foreach($block as $key=>$blo): ?>
	    <li><a href="<?php echo $blo['url']; ?>"><img src="<?php echo imageurl_to_path($blo['pictures']); ?>"/></a></li>
		<?php endforeach; endif; else: echo "" ;endif; ?>
	    
	  </ul>
	</div> 

</section>

<!--新闻中心-->
<section class="ynq-block">
	<div width="1200px" flex="" class="ynq-news-block">
		<div class="ynq-newsleft">
			<h1>商会公告<span>announcement</span><a href="<?php echo jump('Notice/index'); ?>">更多 <cite class="fa fa-angle-double-right"></cite></a></h1>
			<ul class="ynq-newslist">
				<?php if(is_array($notice) || $notice instanceof \think\Collection || $notice instanceof \think\Paginator): if( count($notice)==0 ) : echo "" ;else: foreach($notice as $k3=>$art3): if($k3 < 4): ?>
				<li>
					<h2><cite class="fa fa-angle-right"></cite><?php echo date("Y-m-d", $art3['created_at']); ?></h2>
					<p><a href="<?php echo jump('Notice/detail', ['slug' => $art3['slug']]); ?>" data-row="2"><?php echo $art3['title']; ?></a></p>
				</li>
				<?php endif; endforeach; endif; else: echo "" ;endif; ?>
			</ul>
		</div>
		<div class="ynq-newsrightbox">
			<h1>商会新闻<span>news</span><a href="<?php echo jump('Article/index', ['slug' => 'commerce-news']); ?>">更多 <cite class="fa fa-angle-double-right"></cite></a></h1>
			<ul flex="" class="ynq-newsphoto">
				<?php if(is_array($article[0]['index_article']) || $article[0]['index_article'] instanceof \think\Collection || $article[0]['index_article'] instanceof \think\Paginator): if( count($article[0]['index_article'])==0 ) : echo "" ;else: foreach($article[0]['index_article'] as $k0=>$art0): if($k0 < 2): ?>
				<li>
					<a href="<?php echo jump('Article/detail', ['slug' => $art0['slug']]); ?>"><div class="ynq-newboximg"><img src="<?php echo imageurl_to_path($art0['thumb']); ?>" alt=""></div></a>
					<h2 data-row="1"><?php echo $art0['title']; ?></h2>
					<p class="ynq-date"><?php echo date("Y-m-d", $art0['created_at']); ?></p>
					<p data-row="2"><?php echo $art0['summary']; ?></p>
				</li>
				<?php endif; endforeach; endif; else: echo "" ;endif; ?>
			</ul>
		</div>
	</div>
</section>

<!--商会风采-->
<section class="ynq-block ynq-fengcai">
	<div width="1200px">
		<h1>商会风采<span>Elegant demeanour</span><a href="<?php echo jump('Article/index', ['slug' => 'live-news']); ?>">更多 <cite class="fa fa-angle-double-right"></cite></a></h1>
		<div class="ynq-fengcai-photo" flex="">
			<div class="ynq-fengcai-index">
				<em><a href=""><img src="/static/home/image/views.png" alt=""></a></em>
				<a href="<?php echo jump('Article/detail', ['slug' => $article[1]['index_article'][0]['slug']]); ?>"><img src="<?php echo imageurl_to_path($article[1]['index_article'][0]['thumb']); ?>" alt=""></a>
				<span data-row="1"><?php echo $article[1]['index_article'][0]['title']; ?></span>
			</div>
			<ul class="ynq-fengcai-two">
				<li>
					<a href="<?php echo jump('Article/detail', ['slug' => $article[1]['index_article'][1]['slug']]); ?>"><div><img src="<?php echo imageurl_to_path($article[1]['index_article'][1]['thumb']); ?>" alt=""></div></a>
					<span data-row="1"><?php echo $article[1]['index_article'][1]['title']; ?></span>
				</li>
				<li>
					<a href="<?php echo jump('Article/detail', ['slug' => $article[1]['index_article'][2]['slug']]); ?>"><div><img src="<?php echo imageurl_to_path($article[1]['index_article'][2]['thumb']); ?>" alt=""></div></a>
					<span data-row="1"><?php echo $article[1]['index_article'][2]['title']; ?></span>
				</li>
			</ul>
		</div>
	</div>
</section>

<!--入会申请-->
<section style="background: url(<?php echo imageurl_to_path($block1['pictures']); ?>) no-repeat;" class="ynq-regsit">
	<div width="1200px">
		<div class="ynq-regsit-box">
			<h1><?php echo $block1['title']; ?></h1>
			<p><?php echo $block1['content']; ?></p>
			<div class="ynq-regsit-href"><a href="<?php echo jump('Member/page'); ?>">入会申请</a></div>
		</div>
	</div>
</section>

<!--会员动态-->
<section class="ynq-block">
	<div width="1200px">
		<h1>会员动态<span>Member of the dynamic</span><a href="<?php echo jump('Article/index', ['slug' => 'member-news']); ?>">更多 <cite class="fa fa-angle-double-right"></cite></a></h1>
		<ul flex="" class="ynq-memberbox">
			<?php if(is_array($article[2]['index_article']) || $article[2]['index_article'] instanceof \think\Collection || $article[2]['index_article'] instanceof \think\Paginator): if( count($article[2]['index_article'])==0 ) : echo "" ;else: foreach($article[2]['index_article'] as $k2=>$art2): if($k2 < 3): ?>
			<li>
				<a href="<?php echo jump('Article/detail', ['slug' => $art2['slug']]); ?>"><div class="ynq-memberphoto"><img src="<?php echo imageurl_to_path($art2['thumb']); ?>" alt=""></div></a>
				<p data-row="2"><?php echo $art2['title']; ?></p>
			</li>
			<?php endif; endforeach; endif; else: echo "" ;endif; ?>
		</ul>
	</div>
</section>

<!--合作企业-->
<section class="ynq-block ynq-linkbox">
	<div width="1200px">
		<h1>合作企业<span>The cooperative enterprise</span></h1>
		<ul flex="" class="ynq-linkbox-list">
			<?php if(is_array($link[0]['link']) || $link[0]['link'] instanceof \think\Collection || $link[0]['link'] instanceof \think\Paginator): if( count($link[0]['link'])==0 ) : echo "" ;else: foreach($link[0]['link'] as $key=>$link0): ?>
			<li>
				<a href="<?php echo $link0['link_url']; ?>" target="_blank"><img src="<?php echo imageurl_to_path($link0['pictures']); ?>" alt=""></a>
			</li>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>
		
		<div class="ynq-friendlink">
			<form class="layui-form" action=""  flex="">
			<div class="ynq-friend-default">
				友情链接<span>link</span>
			</div>
			<select name="ynq-haoyou" id="ynq-haoyou" lay-filter="ynq-haoyou">
				<option>友好合作机构</option>
				<?php if(is_array($link[1]['link']) || $link[1]['link'] instanceof \think\Collection || $link[1]['link'] instanceof \think\Paginator): if( count($link[1]['link'])==0 ) : echo "" ;else: foreach($link[1]['link'] as $key=>$link1): ?>
				<option value="<?php echo $link1['link_url']; ?>"><?php echo $link1['link_name']; ?></option>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</select>
			
			<select name="ynq-jinwai" id="ynq-jinwai" lay-filter="ynq-jinwai">
				<option>境外经贸合作区</option>
				<?php if(is_array($link[2]['link']) || $link[2]['link'] instanceof \think\Collection || $link[2]['link'] instanceof \think\Paginator): if( count($link[2]['link'])==0 ) : echo "" ;else: foreach($link[2]['link'] as $key=>$link2): ?>
				<option value="<?php echo $link2['link_url']; ?>"><?php echo $link2['link_name']; ?></option>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</select>
			
			<select name="ynq-zhenwu" id="ynq-zhenwu" lay-filter="ynq-zhenwu">
				<option>政务机构网站</option>
				<?php if(is_array($link[3]['link']) || $link[3]['link'] instanceof \think\Collection || $link[3]['link'] instanceof \think\Paginator): if( count($link[3]['link'])==0 ) : echo "" ;else: foreach($link[3]['link'] as $key=>$link3): ?>
				<option value="<?php echo $link3['link_url']; ?>"><?php echo $link3['link_name']; ?></option>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</select>
		</div>
		</from>
	</div>
</section>

<section class="ynq-footer">
	<div width="1200px">
		<div class="ynq-footer-menu">
			<?php if(is_array($navigation) || $navigation instanceof \think\Collection || $navigation instanceof \think\Paginator): if( count($navigation)==0 ) : echo "" ;else: foreach($navigation as $k=>$navi): if($k != 0): ?><span>|</span><?php endif; ?><a href="<?php echo $navi['nav_url']; ?>"><?php echo $navi['nav_name']; ?></a>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		</div>
		<p>地址：<?php echo $website['address']; ?></p>
		<p>联系电话：<?php echo $website['telephone']; ?>&nbsp;&nbsp;&nbsp;&nbsp;传真：<?php echo $website['fax']; ?></p>
		<p><?php echo $website['copyrights']; ?><a href="https://beian.miit.gov.cn/"><?php echo $website['icp']; ?></a>       <a href="http://www.shimaotong.net" target="_blank">Powered by Shimaotong.net</a></p>
	</div>
		<a href="javascript:;" class="ynq-gotop" radius="3"><i class="fa fa-angle-double-up"></i><span>TOP</span></a>
		<a href="javascript:;" class="ynq-gotop2" radius="3"><i class="fa fa-angle-double-up"></i><span>TOP</span></a>
</section>
</body>
</html>
<script type="text/javascript">
	var _maq = _maq || [];
	_maq.push(['_setAccount', 'Ningbo Suntek']);
	(function() {
	var ma = document.createElement('script'); ma.type = 'text/javascript'; ma.async = true;
	ma.src = '/static/home/js/analytics.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ma, s);
	})();
</script>

