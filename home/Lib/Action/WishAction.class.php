<?php
    class WishAction extends Action
    {
        function index()
        {
            $wish_list = M('wish')->select();
            #p($wish_list);
            #$this->assign('a', $wish_list);
            #$this->wist_list = $wish_list);
            $this->assign('wish_list', $wish_list)->display();
        }

        public function handle()
        {
            if (!IS_POST)
            {
                _404('页面不存在', U('Wish/index'));
            }
            p(I('post.'));

            $data = array(
                'user' => I('username', 'admin'),
                'content' => I('content', ''),
                'ctime' => time(),
            );
            p($data);
            if ( M('wish')->data($data)->add())
            {
                $this->success('发布成功', 'index');
            }
            else
            {
                $this->error('发布失败， 请重试');
            }
        }
    }
?>
