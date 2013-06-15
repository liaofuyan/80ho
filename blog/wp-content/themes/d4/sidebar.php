<?php 
/*
 * haozi / hao.chen@qq.com / www.daqianduan.com / t.qq.com/daqianduan && weibo.com/
 * Theme D4 => 侧栏
*/
?>
<div class="sidebar">
	<div class="search">
		<form method="get" class="searchform" action="<?php echo $_SERVER['include/PHP_SELF']; ?>" >
			<input type="text" onfocus="if (this.value == '回车搜索 直接有效') {this.value = '';}" onblur="if (this.value == '') {this.value = '回车搜索 直接有效';}" value="回车搜索 直接有效" name="s" class="s" /><input class="btn searchsubmit" type="submit" value="搜索">
		</form>
	</div>

	<a class="feed" target="_blank" href="<?php echo stripslashes(get_option('d_rss')); ?>"><strong>订阅<?php bloginfo('name'); ?>Feed</strong><?php echo stripslashes(get_option('d_rss')); ?></a>
	
	<?php if (get_option('d_adsid_01_b') == 'Open') { ?>
	<div class="aside"><?php echo stripslashes(get_option('d_adsid_01')); ?></div>
	<?php } ?>
	
	<?php if (get_option('d_adsid_02_b') == 'Open') { ?>
	<div class="aside"><?php echo stripslashes(get_option('d_adsid_02')); ?></div>
	<?php } ?>
	
	<div class="greater">
		<h3><span class="more"><a href="<?php echo stripslashes(get_option('d_readers_page_url')); ?>">读者墙&raquo;</a></span>活跃读者 （他们很给力）</h3>
		<div class="sub-greater">
			<?php dtheme_readers($outer='',$timer='1',$limit='14'); ?>
		</div>
	</div>
	
	<div class="post-list">
		<h3 class="tit"><strong class="on">最新评论</strong><strong>近期热门</strong><strong>最新发布</strong><strong>猜你喜欢</strong></h3>
		<ul><?php dtheme_recent_comments( '' , '10' );?></ul>
		<ul class="hide"><?php dtheme_posts_list( 'comment_count' , '' ,'10' ); ?></ul>
		<ul class="hide"><?php dtheme_posts_list( 'date' , '' ,'10' ); ?></ul>
		<ul class="hide"><?php dtheme_posts_list( 'rand' , '' ,'10' ); ?></ul>
	</div>
	
	<?php if (get_option('d_adsid_03_b') == 'Open') { ?>
	<div class="aside"><?php echo stripslashes(get_option('d_adsid_03')); ?></div>
	<?php } ?>
	
	<?php if (get_option('d_maillist_b') == 'Open') { ?>
	<div class="feed-mail">
		<form action="http://list.qq.com/cgi-bin/qf_compose_send" target="_blank" method="post">
			<input type="hidden" name="t" value="qf_booked_feedback">
			<input type="hidden" name="id" value="<?php echo stripslashes(get_option('d_maillist')); ?>">
			<input id="to" onfocus="if (this.value == '输入邮箱 订阅本站') {this.value = '';}" onblur="if (this.value == '') {this.value = '输入邮箱 订阅本站';}" value="输入邮箱 订阅本站" name="to" type="text" class="feed-mail-input"><input class="feed-mail-btn" type="submit" value="订阅">
		</form>
	</div>
	<?php } ?>
	
	<div class="post-list tags">
		<h3 class="tit"><strong class="on">热门标签</strong></h3>
		<div class="sub-tags">
			<?php wp_tag_cloud('number='.stripslashes(get_option('d_tags_num')).'&orderby=count&order=DESC&smallest=12&largest=12&unit=px'); ?>
		</div>
	</div>
	
	<?php if (get_option('d_flinks_b') == 'Open') { ?>
	<div class="post-list flinks">
		<h3 class="tit"><strong class="on">友情链接</strong></h3>
		<ul><?php wp_list_bookmarks('orderby=id&categorize=0&category=2&title_li=&limit='.stripslashes(get_option('d_flinks_num'))); ?></ul>
	</div>
	<?php } ?>
</div>