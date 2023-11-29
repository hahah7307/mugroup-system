<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:93:"D:\phpstudy_pro\WWW\hardware-tools\public/../application/Home\view\default\article\detail.php";i:1607310067;s:82:"D:\phpstudy_pro\WWW\hardware-tools\application\Home\view\default\public\header.php";i:1607996284;s:82:"D:\phpstudy_pro\WWW\hardware-tools\application\Home\view\default\public\footer.php";i:1607561991;}*/ ?>

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

<style type="text/css">
	.ynq-HeaderBanner {
		background: url("<?php echo imageurl_to_path($banner['pictures']); ?>") no-repeat;
		background-size:cover;
		background-position:center center;
	}
</style>
<section class="ynq-HeaderBanner">
	<div width="1200px" class="ynq-HeaderBanner-text">
		<h1>新闻中心</h1>
		<p><cite class="fa fa-home"></cite>
		<a href="/">首页</a><span>/</span>
		<a href="<?php echo jump('Article/index', ['slug' => 'commerce-news']); ?>">新闻中心</a><span>/</span>
		<?php if($slug == 'commerce-news'): ?>
		<a href="<?php echo jump('Article/index', ['slug' => $slug]); ?>">商会新闻</a></p>
		<?php elseif($slug == 'live-news'): ?>
		<a href="<?php echo jump('Article/index', ['slug' => $slug]); ?>">商会风采</a></p>
		<?php elseif($slug == 'member-news'): ?>
		<a href="<?php echo jump('Article/index', ['slug' => $slug]); ?>">会员动态</a></p>
		<?php endif; ?>
	</div>
</section>
<!--新闻中心-->
<section class="ynq-block-sub">
	<div width="1200px" class="ynq-news-block">
		<ul class="ynq-subpage-menu" flex="">
			<li <?php if($slug == 'commerce-news'): ?>class="subpage-menu-active"<?php endif; ?>><a href="<?php echo jump('Article/index', ['slug' => 'commerce-news']); ?>"><?php if($slug == 'commerce-news'): ?><cite class="fa fa-check-circle"></cite><?php else: ?><cite class="fa fa-circle-o"></cite><?php endif; ?>商会新闻</a></li>
			<li <?php if($slug == 'live-news'): ?>class="subpage-menu-active"<?php endif; ?>><a href="<?php echo jump('Article/index', ['slug' => 'live-news']); ?>"><?php if($slug == 'live-news'): ?><cite class="fa fa-check-circle"></cite><?php else: ?><cite class="fa fa-circle-o"></cite><?php endif; ?>商会风采</a></li>
			<li <?php if($slug == 'member-news'): ?>class="subpage-menu-active"<?php endif; ?>><a href="<?php echo jump('Article/index', ['slug' => 'member-news']); ?>"><?php if($slug == 'member-news'): ?><cite class="fa fa-check-circle"></cite><?php else: ?><cite class="fa fa-circle-o"></cite><?php endif; ?>会员动态</a></li>
		</ul>
		<div class="ynq-content">
			<h3><?php echo $info['title']; ?><span>发布时间：<?php echo date("Y-m-d", $info['created_at']); ?></span></h3>
			<div><?php echo $info['content']; ?></div>
		</div>
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

