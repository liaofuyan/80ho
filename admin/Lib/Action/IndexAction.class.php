<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action {
    public function index(){
        echo '后台管理';
        echo C('USERNAME');
        $db = M('user');
        dump($db->select());
    }
}
