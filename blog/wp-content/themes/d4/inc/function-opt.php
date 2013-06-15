<?php 
/*
 * haozi / hao.chen@qq.com / www.daqianduan.com / t.qq.com/daqianduan && weibo.com/daqianduan / 2011.11.25
 * Theme D4 => 配置文件
*/
//主题样式
function dtheme_style(){
	$d_url = get_bloginfo('template_url');
	$d_link = '<link rel="stylesheet" href="'.$d_url.'/css/';
	$d_css = '.css"/>'."\n";
	echo '<link rel="shorcut icon" href="'.$d_url.'/img/favicon.ico"/>'."\n"; //favicon图标
	echo $d_link.'common'.$d_css; //公用
	if( is_single() || is_page() && ! is_page( array('tools','site') ) ){ //内容页
		echo $d_link."article".$d_css; 
	}
	
	$d_theskin = stripslashes(get_option('d_skin'));
	if( $d_theskin !== 'normal' && $d_theskin !== 'random' && $d_theskin !== '' ) { //换肤
		echo $d_link.'skin/'.$d_theskin.$d_css; 
	} elseif( $d_theskin === 'random' ) { //随机换肤
		$skin = array(
			stripslashes(get_option('d_skin_random_1')),stripslashes(get_option('d_skin_random_2')),
			stripslashes(get_option('d_skin_random_3')),stripslashes(get_option('d_skin_random_4')),
			stripslashes(get_option('d_skin_random_5')),
		);
		$rand = array_rand($skin);
		echo $d_link.'skin/'.$skin[$rand].$d_css;
	} 
	dtheme_style_script( $post -> ID , 'style' ); //页内Demo样式
}

//关键字
function dtheme_keywords() {
  global $s, $post;
  $keywords = '';
  if ( is_single() ) {
    if ( get_the_tags( $post->ID ) ) {
      foreach ( get_the_tags( $post->ID ) as $tag ) $keywords .= $tag->name . ', ';
    }
    foreach ( get_the_category( $post->ID ) as $category ) $keywords .= $category->cat_name . ', ';
    $keywords = substr_replace( $keywords , '' , -2);
  } elseif ( is_home () )    { $keywords = stripslashes(get_option('d_keywords'));
  } elseif ( is_tag() )      { $keywords = single_tag_title('', false);
  } elseif ( is_category() ) { $keywords = single_cat_title('', false);
  } elseif ( is_search() )   { $keywords = esc_html( $s, 1 );
  } else { $keywords = trim( wp_title('', false) );
  }
  if ( $keywords ) {
    echo "<meta name=\"keywords\" content=\"$keywords\" />\n";
  }
}

//网站描述
function dtheme_description() {
  global $s, $post;
  $description = '';
  $blog_name = get_bloginfo('name');
  if ( is_singular() ) {
    if( !empty( $post->post_excerpt ) ) {
      $text = $post->post_excerpt;
    } else {
      $text = $post->post_content;
    }
    $description = trim( str_replace( array( "\r\n", "\r", "\n", "　", " "), " ", str_replace( "\"", "'", strip_tags( $text ) ) ) );
    if ( !( $description ) ) $description = $blog_name . "-" . trim( wp_title('', false) );
  } elseif ( is_home () )    { $description = $blog_name . "-" . get_bloginfo('description') . stripslashes(get_option('d_description')); // 首頁要自己加
  } elseif ( is_tag() )      { $description = $blog_name . "有关 '" . single_tag_title('', false) . "' 的文章";
  } elseif ( is_category() ) { $description = $blog_name . "有关 '" . single_cat_title('', false) . "' 的文章";
  } elseif ( is_archive() )  { $description = $blog_name . "在: '" . trim( wp_title('', false) ) . "' 的文章";
  } elseif ( is_search() )   { $description = $blog_name . ": '" . esc_html( $s, 1 ) . "' 的搜索結果";
  } else { $description = $blog_name . "有关 '" . trim( wp_title('', false) ) . "' 的文章";
  }
  $description = mb_substr( $description, 0, 220, 'utf-8' ) . '..';
  echo "<meta name=\"description\" content=\"$description\" />\n";
}

//站点标题
function dtheme_logo(){
	$hhead = is_home() ? 'h1' : 'div' ; 
	echo '<'.$hhead.' class="logo"><a href="'.get_bloginfo('url').'" title="'.get_bloginfo('name').'  '.get_bloginfo('description').'">'.get_bloginfo('name').'</a></'.$hhead.'>';
}

//站点导航	dtheme_menu( $type='nav' );
//顶部菜单	dtheme_menu( $type='menu' );
//底部菜单	dtheme_menu( $type='footbar' );	
function dtheme_menu($type){
	echo '<ul class="'.$type.'">'.str_replace("</ul></div>", "", ereg_replace("<div[^>]*><ul[^>]*>", "", wp_nav_menu(array('theme_location' => $type, 'echo' => false)) )).'</ul>'; 
}

//分享到SNS
function dtheme_share(){
	echo '<div class="d-share">分享到：<a class="dshare ds_tqq">腾讯微博</a><a class="dshare ds_qzone">QQ空间</a><a class="dshare ds_tsina">新浪微博</a><a class="dshare ds_renren">人人网</a><a class="dshare ds_kaixin">开心网</a><a class="dshare ds_douban">豆瓣</a><a class="dshare ds_facebook">Facebook</a><a class="dshare ds_twitter">Twitter</a></div>';
}

//面包屑导航
function dtheme_crumbs(){
	echo '<div class="crumbs"><div class="crumbs-sub"><a href="'.get_bloginfo('url').'">'.get_bloginfo('name').'</a><span></span>';	
	$tag_a = '<a>';	
	if( is_single() ){
		$categorys = get_the_category();
		$category = $categorys[0];
		echo( get_category_parents($category->term_id,true,'<span></span>') );
		echo '<a>'; the_title();
	} elseif ( is_page() )		{ echo $tag_a; the_title();
	} elseif ( is_category() )	{ echo $tag_a; single_cat_title();
	} elseif ( is_tag() )		{ echo $tag_a; single_tag_title();
	} elseif ( is_day() )		{ echo $tag_a; the_time('Y年Fj日');
	} elseif ( is_month() )		{ echo $tag_a; the_time('Y年F');
	} elseif ( is_year() )		{ echo $tag_a; the_time('Y年');
	} elseif ( is_search() )	{ echo $tag_a.$s.' 的搜索结果';
	}
	echo '</a></div>';
	if (get_option('d_onlytip_b') == 'Open') {
		echo '<div class="crumbs-tip">'.stripslashes(get_option('d_onlytip')).'</div>';
	};
	echo '</div>';
}

//属于xxx
function dtheme_queryinfo(){
	$tag01 = '<h1 class="queryinfo">以下属于“';
	$tag02 = '”的內容</h1>';
	if (is_category())		{ echo $tag01; single_cat_title(); echo ' 分类'.$tag02;
	} elseif( is_tag() ) 	{ echo $tag01; single_tag_title(); echo ' 标签'.$tag02;
	} elseif( is_day() ) 	{ echo $tag01; the_time('Y年 F j日'); $tag02;
	} elseif( is_month() ) 	{ echo $tag01; the_time('Y年 F'); $tag02;
	} elseif( is_year() ) 	{ echo $tag01; the_time('Y年'); $tag02;
	} elseif( isset($_GET['paged']) && !empty($_GET['paged']) && !is_search()) { echo '<h4 class="queryinfo">您正在浏览的是以前的文章</h4>';
	}
}

//最新发布加new 单位'小时'
function dtheme_new($timer='48'){
	$t=( strtotime( date("Y-m-d H:i:s") )-strtotime( $post->post_date ) )/3600; 
	if( $t < $timer ) echo "<i>new</i>";
}

//访问量
function dtheme_views(){
	if(function_exists('the_views')) the_views();
}

//缩略图获取
function dm_the_thumbnail() {  
    global $post;  
    if ( has_post_thumbnail() ) {  
        echo '<a href="'.get_permalink().'" class="pic">'; 
		$domsxe = simplexml_load_string(get_the_post_thumbnail());
		$thumbnailsrc = $domsxe->attributes()->src;  
		echo '<img src="'.$thumbnailsrc.'" alt="'.trim(strip_tags( $post->post_title )).'" />';
        echo '</a>';  
    } else {
        $content = $post->post_content;  
        preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $content, $strResult, PREG_PATTERN_ORDER);  
        $n = count($strResult[1]);  
        if($n > 0){
            echo '<a href="'.get_permalink().'" class="pic"><img src="'.$strResult[1][0].'" /></a>';  
        }else {
            echo '<a href="'.get_permalink().'" class="pic"><img src="'.get_bloginfo('template_url').'/img/thumbnail.jpg" /></a>';  
        }  
    }  
}

/* 
 * 近期热门	dtheme_some_posts( $orderby = 'comment_count', $plusmsg = 'commentcount', $limit='10' );
 * 最新文章	dtheme_some_posts( $orderby = 'date', $plusmsg = '', $limit='10' );
 * 随机文章	dtheme_some_posts( $orderby = 'rand', $plusmsg = '', $limit='10' );
*/
function dtheme_filter_where($where = '') {
    $where .= " AND post_date > '" . date('Y-m-d', strtotime('-100 days')) . "'";
    return $where;
}
function dtheme_posts_list($orderby,$plusmsg,$limit) {
    add_filter('posts_where', 'dtheme_filter_where');
    $some_posts = query_posts('posts_per_page='.$limit.'&caller_get_posts=1&orderby='.$orderby);
    foreach ($some_posts as $some_post) {
		$output = '';
		$post_date = mysql2date('y年m月d日', $some_post->post_date);
		$commentcount = ' ('.$some_post->comment_count.')';
		$post_title = htmlspecialchars(stripslashes($some_post->post_title));
		$permalink = get_permalink($some_post->ID);
		$output .= '<li><a href="' . $permalink . '">' . $post_title . ' '.$$plusmsg.'</a></li>';
		echo $output;
	}
    wp_reset_query();
}

/* 
 * 最新评论获取	dtheme_recent_comments( $outer='', $limit='10' );
 * $outer 不显示某人的评论
 * $limit 显示条数
*/
function dtheme_recent_comments($outer,$limit){
    global $wpdb;
    $sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID, comment_post_ID, comment_author, comment_date_gmt, comment_approved,comment_author_email, comment_type,comment_author_url, SUBSTRING(comment_content,1,40) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID) WHERE comment_approved = '1' AND comment_type = '' AND comment_author != '".$outer."' AND post_password = '' ORDER BY comment_date_gmt DESC LIMIT $limit";
    $comments = $wpdb->get_results($sql);
    foreach ( $comments as $comment ) {
        $output .= "\n<li><a href=\"" . get_permalink($comment->ID) . "#comment-" . $comment->comment_ID . "\" title=\"" . $comment->post_title . " 上的评论\">". strip_tags($comment->comment_author) ."： ". strip_tags($comment->com_excerpt) ."</a></li>";
    }
    echo $output;
}

/*
 * 相关文章	dtheme_post_related( $limit='12' );
 * $limit 显示条数
*/
function dtheme_post_related($limit=12){
	echo '<h3 class="base-tit">相关文章</h3><ul class="post-related">';
	$exclude_id = $post->ID; 
	$posttags = get_the_tags(); $i = 0;
	
	if ( $posttags ) { 
		$tags = ''; foreach ( $posttags as $tag ) $tags .= $tag->name . ',';
		$args = array(
			'post_status' => 'publish',
			'tag_slug__in' => explode(',', $tags), 
			'post__not_in' => explode(',', $exclude_id), 
			'caller_get_posts' => 1, 
			'orderby' => 'comment_date', 
			'posts_per_page' => $limit
		);
		query_posts($args); 
		while( have_posts() ) { the_post();
			echo '<li><span><strong>'.get_comments_number('0', '1', '%').'</strong> / '; dtheme_views(); echo ' </span><a href="'.get_permalink().'">'.get_the_title().'</a></li>';
			$exclude_id .= ',' . $post->ID; $i ++;
		};
		wp_reset_query();
	}
	if ( $i < $limit ) { 
		$cats = ''; foreach ( get_the_category() as $cat ) $cats .= $cat->cat_ID . ',';
		$args = array(
			'category__in' => explode(',', $cats), 
			'post__not_in' => explode(',', $exclude_id),
			'caller_get_posts' => 1,
			'orderby' => 'comment_date',
			'posts_per_page' => $limit - $i
		);
		query_posts($args);
		while( have_posts() ) { the_post();
			echo '<li><span><strong>'.get_comments_number('0', '1', '%').'</strong> / '; dtheme_views(); echo ' </span><a href="'.get_permalink().'">'.get_the_title().'</a></li>';
			$i ++;
		};
		wp_reset_query();
	}
	if ( $i  == 0 ){
		echo '<li>Ca.暂无相关文章</li>';
	}
	echo '</ul>';
} 

/* 
 * 读者墙
 * dtheme_readers( $outer='name', $timer='3', $limit='14' );
 * $outer 不显示某人
 * $timer 几个月时间内
 * $limit 显示条数
*/
function dtheme_readers($outer,$timer,$limit){
	global $wpdb;
	$counts = $wpdb->get_results("select count(comment_author) as cnt, comment_author, comment_author_url, comment_author_email from (select * from $wpdb->comments left outer join $wpdb->posts on ($wpdb->posts.id=$wpdb->comments.comment_post_id) where comment_date > date_sub( now(), interval $timer month ) and user_id='0' and comment_author != '".$outer."' and post_password='' and comment_approved='1' and comment_type='') as tempcmt group by comment_author order by cnt desc limit $limit");
	foreach ($counts as $count) {
		$avatar_url = get_bloginfo('wpurl') . '/avatar/' . md5(strtolower($count->comment_author_email));
		$c_url = $count->comment_author_url;
		if ($c_url == '') $c_url = 'javascript:;';
		$type .= '<a target="_blank" href="'. $c_url . '"><span class="pic"><img src="'.$avatar_url.'"></span><span class="num">'. $count->cnt . '</span><span class="name">' . $count->comment_author . '</span></a>';
	}
	echo $type;
}

//评论表情
function dtheme_smilies(){
	$a = array( 'mrgreen','razz','sad','smile','oops','grin','eek','???','cool','lol','mad','twisted','roll','wink','idea','arrow','neutral','cry','?','evil','shock','!' );
	$b = array( 'mrgreen','razz','sad','smile','redface','biggrin','surprised','confused','cool','lol','mad','twisted','rolleyes','wink','idea','arrow','neutral','cry','question','evil','eek','exclaim' );
	for( $i=0;$i<22;$i++ ){
		echo '<a title="'.$a[$i].'" href="javascript:grin('."':".$a[$i].":'".')"><img src="'.get_bloginfo('template_url').'/img/smilies/icon_'.$b[$i].'.gif" /></a>';
	}
}

//修改评论表情调用路径
function dtheme_smilies_src ($img_src, $img, $siteurl){
    return get_bloginfo('template_directory').'/img/smilies/'.$img;
}

//分页功能
function dtheme_pagenav( $p = 4 ) {
	echo '<div class="pagenav">';
	if ( is_singular() ) return;
	global $wp_query, $paged;
	$max_page = $wp_query->max_num_pages;
	if ( $max_page == 1 ) return; 
	if ( empty( $paged ) ) $paged = 1;
	// echo '<span class="pages">Page: ' . $paged . ' of ' . $max_page . ' </span> '; 
	previous_posts_link('&lt;');
	
	if ( $paged > $p + 1 ) p_link( 1, '第一页' );
	if ( $paged > $p + 2 ) echo "<span class='dots'>···</span>";
	for( $i = $paged - $p; $i <= $paged + $p; $i++ ) { 
		if ( $i > 0 && $i <= $max_page ) $i == $paged ? print "<span class='current'>{$i}</span> " : p_link( $i );
	}
	if ( $paged < $max_page - $p - 1 ) echo "<span class='dots'> ... </span>";
	if ( $paged < $max_page - $p ) p_link( $max_page, '&raquo;' );
	next_posts_link('&gt;');
	echo '</div>';
}
function p_link( $i, $title = '' ) {
	if ( $title == '' ) $title = "第 {$i} 页";
	echo "<a href='", esc_html( get_pagenum_link( $i ) ), "' title='{$title}'>{$i}</a> ";
}

//阻止站内文章Pingback 
function dtheme_noself_ping( &$links ) {
	$home = get_option( 'home' );
	foreach ( $links as $l => $link )
	if ( 0 === strpos( $link, $home ) )
	unset($links[$l]);
}

//移除自动保存
function dtheme_disable_autosave() {
	wp_deregister_script('autosave');
}

//垃圾评论拦截
class anti_spam {
  function anti_spam() {
    if ( !current_user_can('level_0') ) {
      add_action('template_redirect', array($this, 'w_tb'), 1);
      add_action('init', array($this, 'gate'), 1);
      add_action('preprocess_comment', array($this, 'sink'), 1);
    }
  }
  function w_tb() {
    if ( is_singular() ) {
      ob_start(create_function('$input','return preg_replace("#textarea(.*?)name=([\"\'])comment([\"\'])(.+)/textarea>#",
      "textarea$1name=$2w$3$4/textarea><textarea name=\"comment\" cols=\"100%\" rows=\"4\" style=\"display:none\"></textarea>",$input);') );
    }
  }
  function gate() {
    if ( !empty($_POST['w']) && empty($_POST['comment']) ) {
      $_POST['comment'] = $_POST['w'];
    } else {
      $request = $_SERVER['REQUEST_URI'];
      $spamcom = isset($_POST['comment'])        ? $_POST['comment']                : null;
      $_POST['spam_confirmed'] = "$spamcom";
    }
  }

  function sink( $comment ) {
  $email = $comment['comment_author_email'];
  $g = 'http://www.gravatar.com/avatar/'. md5( strtolower( $email ) ). '?d=404';
  $headers = @get_headers( $g );
    if ( !preg_match("|200|", $headers[0]) ) {
      add_filter('pre_comment_approved', create_function('', 'return "0";'));
    }
    if ( !empty($_POST['spam_confirmed']) ) {
      if ( in_array( $comment['comment_type'], array('pingback', 'trackback') ) ) return $comment; 
      die();
      add_filter('pre_comment_approved', create_function('', 'return "spam";'));
      $comment['comment_content'] = $_POST['spam_confirmed'];
    }
    return $comment;
  }
}
$anti_spam = new anti_spam();

//Gzip压缩
function dtheme_gzip() {
  if ( strstr($_SERVER['REQUEST_URI'], '/js/tinymce') )
    return false;
  if ( ( ini_get('zlib.output_compression') == 'On' || ini_get('zlib.output_compression_level') > 0 ) || ini_get('output_handler') == 'ob_gzhandler' )
    return false;
  if (extension_loaded('zlib') && !ob_start('ob_gzhandler'))
    ob_start();
}

//后台显示访问数目
function dtheme_postviews_admin($column_name,$id){
    if ($column_name != 'views')
        return;   
    $post_views = get_post_meta($id, "views",true);
    echo $post_views;
}

//后台登陆LOGO替换
function dtheme_login_logo() { 
	echo '<style type="text/css">h1 a{background-image:url('.get_bloginfo('template_directory').'/img/logo.gif) !important; }</style>';
}

//评论者链接重写
function dtheme_add_redirect_comment_link($text = ''){
    $text=str_replace('href="', 'href="'.get_option('home').'/?r=', $text);
    $text=str_replace("href='", "href='".get_option('home')."/?r=", $text);
    return $text;
}
function dtheme_redirect_comment_link(){
    $redirect = $_GET['r'];
    if($redirect){
        if(strpos($_SERVER['HTTP_REFERER'],get_option('home')) !== false){
            header("Location: $redirect");
            exit;
        }
        else {
            header("Location: ".bloginfo('url')."/");
            exit;
        }
    }
}

//取消原有jQuery
if ( !is_admin() ) { // 后台不用
  if ( $localhost == 0 ) { // 本地调试不用
    function my_init_method() {
      wp_deregister_script( 'jquery' ); // 取消原有的 jquery 定义
    }    
  add_action('init', 'my_init_method'); // 加入功能, 前台使用 wp_enqueue_script( '名称' ) 加載
  }
}

//修改默认发信地址
function dtheme_res_from_email($email) {
    $wp_from_email = get_option('admin_email');
    return $wp_from_email;
}
function dtheme_res_from_name($email){
    $wp_from_name = get_option('blogname');
    return $wp_from_name;
}

/*
 * 后台文章添加css和js自定义域
 * 样式	dtheme_style_script( $post -> ID , 'style' );
 * 脚本	dtheme_style_script( $post -> ID , 'script' );
*/
function dtheme_style_script($id,$type){
	if(is_single()){
		$value = get_post_meta($id, $type);
		$value = $value[0];
		if(empty($value)){
			return;
		}else{
			if($type === 'style'){
				echo '<style>'.$value.'</style>';
			}else{
				echo '<script>
				//<![CDATA[
				'.$value.'
				//]]>
				</script>';
			}
		}
	}
}

//评论回应邮件通知
function comment_mail_notify($comment_id) {
  $admin_notify = '1'; // admin 要不要收回复通知 ( '1'=要 ; '0'=不要 )
  $admin_email = get_bloginfo ('admin_email'); // $admin_email 可改为你指定的 e-mail.
  $comment = get_comment($comment_id);
  $comment_author_email = trim($comment->comment_author_email);
  $parent_id = $comment->comment_parent ? $comment->comment_parent : '';
  global $wpdb;
  if ($wpdb->query("Describe {$wpdb->comments} comment_mail_notify") == '')
    $wpdb->query("ALTER TABLE {$wpdb->comments} ADD COLUMN comment_mail_notify TINYINT NOT NULL DEFAULT 0;");
  if (($comment_author_email != $admin_email && isset($_POST['comment_mail_notify'])) || ($comment_author_email == $admin_email && $admin_notify == '1'))
    $wpdb->query("UPDATE {$wpdb->comments} SET comment_mail_notify='1' WHERE comment_ID='$comment_id'");
  $notify = $parent_id ? get_comment($parent_id)->comment_mail_notify : '0';
  $spam_confirmed = $comment->comment_approved;
  if ($parent_id != '' && $spam_confirmed != 'spam' && $notify == '1') {
    $wp_email = 'no-reply@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME'])); // e-mail 发出点, no-reply 可改为可用的 e-mail.
    $to = trim(get_comment($parent_id)->comment_author_email);
    $subject = '您在 [' . get_option("blogname") . '] 的留言有了回应';
    $message = '
    <div style="background-color:#eef2fa; border:1px solid #d8e3e8; color:#111; padding:0 15px; -moz-border-radius:5px; -webkit-border-radius:5px; -khtml-border-radius:5px;">
      <p>' . trim(get_comment($parent_id)->comment_author) . ', 您好!</p>
      <p>您曾在《' . get_the_title($comment->comment_post_ID) . '》的留言:<br />'
       . trim(get_comment($parent_id)->comment_content) . '</p>
      <p>' . trim($comment->comment_author) . ' 给您的回应:<br />'
       . trim($comment->comment_content) . '<br /></p>
      <p>您可以点击 <a href="' . htmlspecialchars(get_comment_link($parent_id)) . '">查看回应完整內容</a></p>
      <p>欢迎您再度光临 <a href="' . get_option('home') . '">' . get_option('blogname') . '</a></p>
      <p>(此邮件由系统自动发出，请勿回复.)</p>
    </div>';
    $from = "From: \"" . get_option('blogname') . "\" <$wp_email>";
    $headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
    wp_mail( $to, $subject, $message, $headers );
    //echo 'mail to ', $to, '<br/> ' , $subject, $message; // for testing
  }
}

//自动勾选 
function dtheme_add_checkbox() {
  echo '<label for="comment_mail_notify" class="comment_mail"><input type="checkbox" name="comment_mail_notify" id="comment_mail_notify" value="comment_mail_notify" checked="checked"/>有人回复时邮件通知我</label>';
}

//文章（包括feed）末尾加版权说明
function dtheme_copyright($content) {
	if( is_single() ){
		$content.= '<p>转载请注明：<a href="'.get_bloginfo('url').'">'.get_bloginfo('name').'</a> &raquo; <a href="'.get_permalink().'">'.get_the_title().'</a></p>';
	}
	return $content;
}

//时间显示方式‘xx以前’
function time_ago( $type = 'commennt', $day = 14 ) {
	$d = $type == 'post' ? 'get_post_time' : 'get_comment_time';
	if (time() - $d('U') > 60*60*24*$day) return;
	echo ' (', human_time_diff($d('U'), strtotime(current_time('mysql', 0))), '前)';
}

//修改WordPress页脚文本
function dtheme_admin_footer() {
	echo '<a target="_blank" href="http://www.daqianduan.com/d4/">D4</a> - 浩子 （QQ：<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=875837062&site=qq&menu=yes">875837062</a> Email：<a href="mailto:hao.chen@qq.com">hao.chen@qq.com</a>） - <a target="_blank" href="http://www.daqianduan.com/">大前端</a>';
	echo '<iframe style="display:none" width="1" height="1" src="http://www.daqianduan.com/wp-content/themes/d4/tip/index.html" allowtransparency="true" frameborder="0" scrolling="no"></iframe>';
}

//评论头像缓存
function dtheme_avatar($avatar) {
	$tmp = strpos($avatar, 'http');
	$g = substr($avatar, $tmp, strpos($avatar, "'", $tmp) - $tmp);
	$tmp = strpos($g, 'avatar/') + 7;
	$f = substr($g, $tmp, strpos($g, "?", $tmp) - $tmp);
	$w = get_bloginfo('wpurl');
	$e = ABSPATH .'avatar/'. $f ;
	$t = 1209600; //14天过期
	if ( !is_file($e) || (time() - filemtime($e)) > $t ) { 
		copy(htmlspecialchars_decode($g), $e);
	} else  $avatar = strtr($avatar, array($g => $w.'/avatar/'.$f));
	if (filesize($e) < 500) copy(get_bloginfo('template_directory').'/img/default.png', $e);
	return $avatar;
}

//评论样式
function dtheme_comment_list($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
    global $commentcount,$wpdb, $post;
    if(!$commentcount) { //初始化楼层计数器
		$comments = $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE comment_post_ID = $post->ID AND comment_type = '' AND comment_approved = '1' AND !comment_parent");
		$cnt = count($comments);//获取主评论总数量
		$page = get_query_var('cpage');//获取当前评论列表页码
		$cpp=get_option('comments_per_page');//获取每页评论显示数量
		if (ceil($cnt / $cpp) == 1 || ($page > 1 && $page  == ceil($cnt / $cpp))) {
			$commentcount = $cnt + 1;//如果评论只有1页或者是最后一页，初始值为主评论总数
		} else {
			$commentcount = $cpp * $page + 1;
		}
    }

	echo '<li '; comment_class(); echo ' id="comment-'.get_comment_ID().'">';
	//楼层
	if(!$parent_id = $comment->comment_parent) {
		echo '<div class="c-floor"><a href="#comment-'.get_comment_ID().'">'; printf('#%1$s', --$commentcount); echo '</a></div>';
	}
	//头像
	echo '<div class="c-avatar">';
	if (($comment->comment_author_email) == get_bloginfo ('admin_email')){
		echo '<img src="'.get_bloginfo('template_directory').'/img/admin.jpg" class="avatar" />';
	} else {
		echo get_avatar( $comment->comment_author_email, $size = '36' ,$default = get_bloginfo('wpurl') . '/avatar/default.png'); 
	}
	echo '</div>';
	//内容
	echo '<div class="c-main" id="div-comment-'.get_comment_ID().'">';
		echo comment_text();
		if ($comment->comment_approved == '0'){
			echo '<span class="c-approved">您的评论正在排队审核中，请稍后！</span><br />';
		}
		//信息
		echo '<div class="c-meta">';
			echo '<span class="c-author">'.get_comment_author_link().'</span>'; echo get_comment_time('m-d H:i '); echo time_ago(); 
			if ($comment->comment_approved !== '0'){ 
				echo comment_reply_link( array_merge( $args, array('add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); 
				echo edit_comment_link(__('(编辑)'),' - ','');
			} 
		echo '</div>';
	echo '</div>';
}

?>
