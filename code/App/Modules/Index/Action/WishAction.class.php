<?php
class WishAction extends Action{
    public function index(){
		$wish = M('wish')->limit(30)->order('time DESC')->select();
		$this->wish = $wish;
		$this->display();
    }
    public function add(){
		//if (!IS_POST) _404('页面不存在',U(GROUP_NAME . '/Wish/index'));
		if (!IS_AJAX) _404('页面不存在',U(GROUP_NAME . '/Wish/index'));
		$data = array(
			'username' => I('username','','htmlspecialchars'),
			'content' => I('content','','htmlspecialchars'),
			'time' => time(),
			);
		//p($data);
		//die;
		
		if ($id = M('wish')->data($data)->add()) {
			$data['id'] = $id;
			$data['content'] = replace_phiz($data['content']);
			$data['time'] = date('y-m-d H:i',$data['time']);
			$data['status'] = 1;
			$this->ajaxReturn($data,'json');
		} else {
			$this->ajaxReturn(array('status' => 0),'json');
		}
    }
}
?>