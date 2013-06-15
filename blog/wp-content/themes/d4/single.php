<?php 
/*
 * haozi / hao.chen@qq.com / www.daqianduan.com / t.qq.com/daqianduan && weibo.com/daqianduan / 2011.11.06
 * Theme D4 => 文章页
*/
get_header();
?>
<div class="main">
	<div class="submain">
		<?php while (have_posts()) : the_post(); ?>
		<div class="article single">
			<div class="postmeta">
				<p class="time"><?php the_date_xml(); ?>　By <?php the_author_posts_link(); ?>　<?php edit_post_link('[编辑]'); ?></p>
				<h1 class="tit"><?php the_title(); ?><span><?php comments_popup_link('抢沙发', '+1', '+%'); ?></span></h1>
				<p class="tag">分类：<?php the_category('、'); ?>　<?php the_tags(__('标签：'), "、") ?>　<?php dtheme_views(); ?>人浏览</p>
			</div>
			<?php if (get_option('d_adpost_01_b') == 'Open') { ?>
				<div class="article-info-text"><?php echo stripslashes(get_option('d_adpost_01')) ?></div>
			<?php }; ?>
			<div class="entry">
				<?php the_content(); ?>
			</div>
		</div>
		<?php dtheme_share(); dtheme_post_related(); ?>
		<?php endwhile; comments_template('', true); ?>
    </div>
</div>
<?php get_sidebar(); get_footer(); ?>