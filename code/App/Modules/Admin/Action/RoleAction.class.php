<?php
/**
*分类管理
*/
class RoleAction extends CommonAction{

	//分类列表
    public function index(){
		$role = M('role')->select();
		$this->role = $role;
		$this->display();
    }

	//添加分类
    public function add(){
		$this->pid = I('pid',0,'intval');
		$this->display();
    }

    public function addPost() {
		if (!IS_POST) _404('页面不存在',U(GROUP_NAME . '/Role/index'));
		if (M('role')->add($_POST)) {
			$this->success('添加成功',U(GROUP_NAME . '/Role/index'));
		} else {
			$this->error('添加失败');
		}
    }

	//修改分类
    public function edit(){
		$id = I('id',0,'intval');
		$role = M('role')->where(array('id' => $id))->select();
		if (!$role) _404('分类不存在',U(GROUP_NAME . '/Role/index'));
		$role = $role[0];
		$this->role = $role;
		$this->display();
    }

    public function editPost() {
		if (!IS_POST) _404('页面不存在',U(GROUP_NAME . '/Role/index'));
		if (M('role')->save($_POST)) {
			$this->success('添加成功',U(GROUP_NAME . '/Role/index'));
		} else {
			$this->error('添加失败');
		}
    }

	//删除分类
    public function delete(){
		$id = I('id',0,'intval');
		if (M('role')->where(array('id' => $id))->delete()) {
			$this->success('删除成功',U(GROUP_NAME . '/Role/index'));
		} else {
			$this->error('删除失败');
		}
    }
	
	//排序
	public function reSort() {
		$db = M('role');
		foreach ($_POST as $id => $sort){
			$db->where(array('id' => $id))->setField('sort',$sort);
		}
		$this->redirect(GROUP_NAME . '/Role/index');
    }
}
?>