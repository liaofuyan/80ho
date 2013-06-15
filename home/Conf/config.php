<?php
    $config = array(
	    //'配置项'=>'配置值'
        'USERNAME' => 'home',
        'URL_MODEL' => 1,
        'TMPL_PARSE_STRING' => array(
            '__PUBLIC__' => __ROOT__ . '/public' ,
        ),
    );
    return array_merge( include './conf/config.php', $config);
?>
