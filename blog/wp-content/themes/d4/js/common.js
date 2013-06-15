(function($) {
	
	//边栏鼠标覆盖样式
	$('.sider li').hover(function() {
		$(this).find('a').css('color', '#090');
	},function() {
		$(this).find('a').css('color', '#305999');
	});
	
	//点击文章标题时预加载提示
	$('.excerpt .tit a').click(function() {
		myloadoriginal = this.text;
		$(this).text('文章正在加载中...');
		var myload = this;
		setTimeout(function() {
			$(myload).text(myloadoriginal);
		},2011);
	});
	
	//侧栏文章列表选项卡
	$('.post-list:eq(0) .tit strong').each(function(i){
		$(this).click(function(){
			$(this).addClass('on').siblings('strong').removeClass('on');
			$($('.post-list:eq(0) ul')[i]).fadeIn().siblings('ul').hide();
		})
	})
	
	$('.site-nav a').each(function(i){
		$(this).click(function(){
			$(this).parent().addClass('on').siblings('li').removeClass('on');
			$($('.site-links')[i]).addClass('on').siblings('.site-links').removeClass('on');
		})
	})
	
	$('.tools-nav a').each(function(i){
		$(this).click(function(){
			$(this).addClass('on').siblings('a').removeClass('on');
			$(this).prev().addClass('on-prev').siblings('a').removeClass('on-prev');
			$(this).next().addClass('on-next').siblings('a').removeClass('on-next');
			$('.tools').load('/wp-content/themes/d4/tools/'+ $(this).attr('id') +'.php');
		})
	})
	
	//dshare 大前端专用分享模块
	dshare();
	function dshare() {
		var thelink = encodeURIComponent(document.location), 
			thetitle = encodeURIComponent(document.title.substring(0,60)), 
			windowName = '分享到',
			param = getParamsOfShareWindow(600, 560),
			
			ds_tqq = 'http://v.t.qq.com/share/share.php?title=' + thetitle + '&url=' + thelink + '&site=',
			ds_qzone = 'http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=' + thelink + '&title=',
			ds_tsina = 'http://v.t.sina.com.cn/share/share.php?url=' + thelink + '&title=' + thetitle,
			ds_douban = 'http://www.douban.com/recommend/?url=' + thelink + '&title=' + thetitle,
			ds_renren = 'http://share.renren.com/share/buttonshare?link=' + thelink + '&title=' + thetitle,
			ds_kaixin = 'http://www.kaixin001.com/repaste/share.php?rurl=' + thelink + '&rcontent=' + thelink + '&rtitle=' + thetitle,
			ds_facebook = 'http://facebook.com/share.php?u=' + thelink + '&t=' + thetitle,
			ds_twitter = 'http://twitter.com/share?url=' + thelink + '&text=' + thetitle;
			
	 	$('.dshare').each(function() {
			$(this).attr('title',windowName + $(this).text());
			$(this).click(function() {
				var httpUrl = eval($(this).attr('class').substring($(this).attr('class').lastIndexOf('ds_')));
				window.open(httpUrl, windowName, param);
			});
		});

		function getParamsOfShareWindow(width, height) {
			return ['toolbar=0,status=0,resizable=1,width=' + width + ',height=' + height + ',left=',(screen.width-width)/2,',top=',(screen.height-height)/2].join('');
		}
	}

})(jQuery);