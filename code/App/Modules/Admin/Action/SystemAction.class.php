<?php
/**
*系统设置
*/
class SystemAction extends CommonAction{
    public function test(){
		echo '是否独立分组：'.C('APP_GROUP_MODE').'<br/>';
		echo 'MODULE目录：'.C('APP_GROUP_PATH').'<br/>';
		echo 'ROOT目录：'.__ROOT__ . '<br/>';
		echo 'APP_PATH目录：'.APP_PATH. '<br/>';
		echo 'GROUP目录：'.__GROUP__ . '<br/>';
		echo '当前模板主题路径 ：'. APP_TMPL_PATH . '<br/>';
		echo '默认模板主题名称  ：'. DEFAULT_THEME . '<br/>';
		p($GLOBALS);
    }
	//修改验证码
    public function verify(){
		$this->display();
    }
    public function updateVerify() {
		if (F('verify',$_POST,CONF_PATH)) {
			$this->success('修改成功',U(GROUP_NAME . '/System/verify'));
		} else {
			$this->error('修改失败,'.CONF_PATH.'/verify.php');
		}
    }
	
}
?>