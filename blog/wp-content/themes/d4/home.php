<?php
/*
 * haozi / hao.chen@qq.com / www.daqianduan.com / t.qq.com/daqianduan && weibo.com/daqianduan / 2011.11.06
 * Theme D4 => 首页
*/
get_header();
?>
<div class="main">
	<div class="submain thelist">
		<?php if (get_option('d_sticky_b') == 'Open') { ?>
		<div class="excerpt sticky">
			<?php $sticky = get_option('sticky_posts');rsort( $sticky );$sticky = array_slice( $sticky, 0, stripslashes(get_option('d_sticky_post_num')) );query_posts( array( 'post__in' => $sticky, 'caller_get_posts' => 1 ) );while (have_posts()) : the_post();?>
			<ul>
				<li>
					<h2 class="tit">
						<em>[顶]</em><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>-<?php bloginfo('name'); ?>"><?php the_title(); ?></a>
					</h2>
					<strong><?php comments_number('', '1条评论', '%条评论'); ?></strong>　<?php dtheme_views(); ?>人浏览
				</li>
			</ul>
			<?php endwhile;?>
		</div>
		<?php } ?>
		
		<div class="post-hot">
			<?php for ($i=1; $i<=4; $i++) { if (get_option('d_column_0'.$i.'_b') == 'Open') { ?>
			<dl>
				<dd>
					<h2><?php echo stripslashes(get_option('d_column_0'.$i.'_show')) ?></h2>
					<ul>
						<?php query_posts( stripslashes(get_option('d_column_0'.$i.'_sort')).'='.stripslashes(get_option('d_column_0'.$i.'')).'&showposts=4'); while ( have_posts() ) : the_post();?>
						<li><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>-<?php bloginfo('name'); ?>"><?php the_title(); ?></a><strong><?php comments_number('0', '1', '%'); ?></strong> / <?php dtheme_views(); ?></li>
						<?php endwhile;?>
					</ul>
				</dd>
			</dl>
			<?php }} ?>
		</div>

		<div class="excerpt">
		<?php query_posts('showposts='.stripslashes(get_option('d_new_post_num')).'&caller_get_posts=1&orderby=date&order=DESC'); while (have_posts()) : the_post(); ?>
			<ul>
				<li>
					<?php dm_the_thumbnail(); ?>
					<p class="time"><?php the_date_xml(); ?></p>
					<h2 class="tit">
						<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>-<?php bloginfo('name'); ?>"><?php the_title(); ?></a><?php dtheme_new('48'); ?>
					</h2>
					<strong><?php comments_number('', '1条评论', '%条评论'); ?></strong>　<?php dtheme_views(); ?>人浏览
				</li>
			</ul>
		<?php endwhile; ?>
		</div>

	</div>
</div>
<?php get_sidebar(); ?>
<div class="homeb">
	<h2><a href="<?php echo stripslashes(get_option('d_homeb_tit_link')) ?>"><?php echo stripslashes(get_option('d_homeb_tit')) ?></a></h2>
	<p>
		<?php query_posts( stripslashes(get_option('d_homeb_sort')).'='.stripslashes(get_option('d_homeb')).'&showposts=5'); while ( have_posts() ) : the_post();?><a href="<?php the_permalink() ?>"><?php the_title(); ?></a><?php endwhile;?>
	</p>
</div>
<?php get_footer(); ?>