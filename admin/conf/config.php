<?php
    $config = array(
	    //'配置项'=>'配置值'
        'USERNAME' => 'admin',
    );
    return array_merge( include './conf/config.php', $config);
?>
