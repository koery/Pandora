<?php
/**
*后台登陆控制器
*/
class LoginAction extends Action{
	//登陆视图
    public function index(){
		$this->display();
    }
	
	//登录表单操作
	public function login(){
		if (!IS_POST) halt('页面不存在');
		//echo session('verify');
		//p($_POST);
		//echo I('code','','md5');
		//die;
		if (I('code','','md5') != session('verify')) $this->error('验证码错误');
		$db = M('admin');
		$admin = $db->where(array('username'=>I('username')))->find();
		if (!$admin || $admin['userpass'] != I('password','','md5')) {	$this->error('帐号或密码错误');	}
		//更新最后一次登录时间IP
		$data = array(
			'id' => $admin['id'],
			'logintime' => time(),
			'loginip' => get_client_ip()
		);
		$db->save($data);
		session('uid',$admin['id']);
		session('username',$admin['username']);
		session('logintime',date('Y-m-d H:i:s',$admin['logintime']));
		session('loginip',$admin['loginip']);
		redirect(__GROUP__);
	}
	
	//验证码
	public function verify(){
		//黄永成
		//import('Class.Image',APP_PATH);
		//Image::Verify();
		import('ORG.Util.Image');
		Image::buildImageVerify(1,1,'png',45,25);
	}
}
?>