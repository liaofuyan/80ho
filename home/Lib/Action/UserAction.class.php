<?php
Class UserAction extends Action
{
    public function index()
    {
        echo C('USERNAME');
        $db = M('user');
        $result = $db->select();
        dump($result);
    }
   public function add()
{
	echo 'user add';
}
}
?>
