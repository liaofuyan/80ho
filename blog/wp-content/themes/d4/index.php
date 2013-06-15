<?php
/*
 * haozi / hao.chen@qq.com / www.daqianduan.com / t.qq.com/daqianduan && weibo.com/daqianduan / 2011.11.06
 * Theme D4 => 分类列表页
*/
get_header();
?>
<div class="main">
	<div class="submain thelist">
		<?php dtheme_queryinfo(); ?>
		<div class="excerpt">
			<?php while (have_posts()) : the_post(); ?>
			<ul>
				<li>
					<?php dm_the_thumbnail(); ?>
					<p class="time"><?php the_date_xml(); ?></p>
					<h2 class="tit">
						<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>-<?php bloginfo('name'); ?>"><?php the_title(); ?></a>
					</h2>
					<strong><?php comments_number('', '1条评论', '%条评论'); ?></strong>　<?php dtheme_views(); ?>人浏览
				</li>
			</ul>
			<?php endwhile; ?>
		</div>
		<?php dtheme_pagenav(); ?>
    </div>
</div>
<?php get_sidebar(); get_footer(); ?>