<?php
/**
*属性管理
*/
class AttributeAction extends CommonAction{

	//属性列表
    public function index(){
		$attr = M('attr')->select();
		$this->attr = $attr;
		$this->display();
    }

	//添加属性
    public function add(){
		$this->pid = I('pid',0,'intval');
		$this->display();
    }

    public function addPost() {
		if (!IS_POST) _404('页面不存在',U(GROUP_NAME . '/Attribute/index'));
		if (M('attr')->add($_POST)) {
			$this->success('添加成功',U(GROUP_NAME . '/Attribute/index'));
		} else {
			$this->error('添加失败');
		}
    }

	//修改属性
    public function edit(){
		$id = I('id',0,'intval');
		$attr = M('attr')->where(array('id' => $id))->select();
		if (!$attr) _404('属性不存在',U(GROUP_NAME . '/Attribute/index'));
		$attr = $attr[0];
		$this->attr = $attr;
		$this->display();
    }

    public function editPost() {
		if (!IS_POST) _404('页面不存在',U(GROUP_NAME . '/Attribute/index'));
		if (M('attr')->save($_POST)) {
			$this->success('添加成功',U(GROUP_NAME . '/Attribute/index'));
		} else {
			$this->error('添加失败');
		}
    }

	//删除属性
    public function delete(){
		$id = I('id',0,'intval');
		if (M('attr')->where(array('id' => $id))->delete()) {
			$this->success('删除成功',U(GROUP_NAME . '/Attribute/index'));
		} else {
			$this->error('删除失败');
		}
    }

}
?>