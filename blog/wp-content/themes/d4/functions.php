<?php
/*
 * haozi / hao.chen@qq.com / www.daqianduan.com / t.qq.com/daqianduan && weibo.com/daqianduan / 2011.11.06
 * Theme D4 => 配置文件
*/
add_action( 'after_setup_theme', 'dtheme_setup' );

//主题后台配置文件
include('inc/opt/theme-opt.php');

function dtheme_setup(){

	require( dirname( __FILE__ ) . '/inc/function-opt.php' );
	
	//去除头部冗余代码
	remove_action( 'wp_head', 'feed_links_extra', 3 ); 
	remove_action( 'wp_head', 'rsd_link' ); 
	remove_action( 'wp_head', 'wlwmanifest_link' ); 
	remove_action( 'wp_head', 'index_rel_link' ); 
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 ); 
	remove_action( 'wp_head', 'wp_generator' ); 
	
	add_action('wp_head', 			'dtheme_keywords');			//关键字
	add_action('wp_head', 			'dtheme_description');		//页面描述
	add_action('pre_ping', 			'dtheme_noself_ping');		//阻止站内PingBack
	add_action('init', 				'dtheme_gzip');				//Gzip压缩
	add_action('login_head', 		'dtheme_login_logo');		//登陆页面Logo改造
	add_action('comment_post', 		'comment_mail_notify');		//评论回复邮件通知
	add_action('comment_form', 		'dtheme_add_checkbox');		//自动勾选评论回复邮件通知，不勾选则注释掉
	add_filter('smilies_src',		'dtheme_smilies_src',1,10);	//评论表情改造，如需更换表情，img/smilies/下替换
	add_filter('admin_footer_text', 'dtheme_admin_footer');		//后台页脚增加主题作者联系及主题链接等信息	
	add_filter('the_content', 		'dtheme_copyright');		//文章末尾增加版权
	add_filter('get_avatar', 		'dtheme_avatar');			//头像缓存	
	
	//移除自动保存和修订版本
	add_action('wp_print_scripts',	'dtheme_disable_autosave' );
	remove_action('pre_post_update','wp_save_post_revision' );
	
	//去除自带js
	wp_deregister_script( 'l10n' );	
	
	//缩略图设置
	add_theme_support('post-thumbnails');
	set_post_thumbnail_size(140, 98, true); 
	
	//修改默认发信地址
	add_filter('wp_mail_from', 'dtheme_res_from_email');
	add_filter('wp_mail_from_name', 'dtheme_res_from_name');
	
	//评论链接重定向	
	add_action('init', 'dtheme_redirect_comment_link');
	add_filter('get_comment_author_link', 'dtheme_add_redirect_comment_link', 5);
	add_filter('comment_text', 'dtheme_add_redirect_comment_link', 99);
	
	//后台文章列表显示访问量，将wp-postviews插件js放置底部，需要 wp-postviews 插件支持
	add_action('manage_posts_custom_column','dtheme_postviews_admin',10,2);
	if ( has_action('wp_head', 'process_postviews' ) ) {
		remove_action('wp_head', 'process_postviews');
		add_action('wp_footer', 'process_postviews');
	}
	
	//定义菜单
	if (function_exists('register_nav_menus')){
		register_nav_menus( array(
		'nav' => __('站点导航'),
		'menu' => __('顶部菜单'),
		'footbar' => __('底部菜单')
		) );
	}

}
?>
