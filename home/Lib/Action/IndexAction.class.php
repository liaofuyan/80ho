<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action {
    public function index(){
        #echo U('Index/hello', array('uid'=>1), '', 0, true);
        #echo '----';
        header('Location: http://121.199.47.133/blog');
    }

    public function hello(){
        echo I('uid');
        p($_GET);
		echo "hello";
	}
}
