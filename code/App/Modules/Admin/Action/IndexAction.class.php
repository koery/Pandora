<?php
/**
*后台首页控制器
*/
class IndexAction extends CommonAction{
	//首页视图
    public function index(){
		//echo __ROOT__;
		$this->display();
    }
    public function logout(){
		session_unset();
		session_destory();
		$this->redirect(GROUP_NAME . '/Login/index');
    }
}
?>