<?php
/**
*分类管理
*/
class UserAction extends CommonAction{

	//分类列表
    public function index(){
		//echo APP_PATH;
		//$import('Class.User',APP_PATH);
		//die;
		$user = M('user')->order('sort ASC')->select();
		//$user = Category::unlimitedForLevel($user);
		$this->user = $user;
		$this->display();
    }

	//添加分类
    public function add(){
		$this->pid = I('pid',0,'intval');
		$this->display();
    }

    public function addPost() {
		if (!IS_POST) _404('页面不存在',U(GROUP_NAME . '/User/index'));
		if (M('user')->add($_POST)) {
			$this->success('添加成功',U(GROUP_NAME . '/User/index'));
		} else {
			$this->error('添加失败');
		}
    }

	//修改分类
    public function edit(){
		$id = I('id',0,'intval');
		$user = M('user')->where(array('id' => $id))->select();
		if (!$user) _404('分类不存在',U(GROUP_NAME . '/User/index'));
		$user = $user[0];
		$this->user = $user;
		$this->display();
    }

    public function editPost() {
		if (!IS_POST) _404('页面不存在',U(GROUP_NAME . '/User/index'));
		if (M('user')->save($_POST)) {
			$this->success('添加成功',U(GROUP_NAME . '/User/index'));
		} else {
			$this->error('添加失败');
		}
    }

	//删除分类
    public function delete(){
		$id = I('id',0,'intval');
		if (M('user')->where(array('id' => $id))->delete()) {
			$this->success('删除成功',U(GROUP_NAME . '/User/index'));
		} else {
			$this->error('删除失败');
		}
    }
	
	//排序
	public function reSort() {
		$db = M('user');
		foreach ($_POST as $id => $sort){
			$db->where(array('id' => $id))->setField('sort',$sort);
		}
		$this->redirect(GROUP_NAME . '/User/index');
    }
}
?>