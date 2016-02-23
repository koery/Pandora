<?php
/**
*节点管理
*/
class NodeAction extends CommonAction{

	//节点列表
    public function index(){
		$node = M('node')->select();
		import('Class.Category',APP_PATH);
		$node = Category::unlimitedForLayer($node);
		$this->node = $node;
		$this->display();
    }

	//添加节点
    public function add(){
		$this->pid = I('pid',0,'intval');
		$this->level = I('level',1,'intval');
		switch ($this->level) {
			case 1:
				$this->type = "应用";
				break;
			case 2:
				$this->type = "控制器";
				break;
			case 3:
				$this->type = "动作方法";
				break;
		}
		$this->display();
    }

    public function addPost() {
		if (!IS_POST) _404('页面不存在',U(GROUP_NAME . '/Node/index'));
		if (M('node')->add($_POST)) {
			$this->success('添加成功',U(GROUP_NAME . '/Node/index'));
		} else {
			$this->error('添加失败');
		}
    }

	//修改节点
    public function edit(){
		$id = I('id',0,'intval');
		$node = M('node')->where(array('id' => $id))->select();
		if (!$node) _404('节点不存在',U(GROUP_NAME . '/Node/index'));
		$node = $node[0];
		$this->node = $node;
		$this->display();
    }

    public function editPost() {
		if (!IS_POST) _404('页面不存在',U(GROUP_NAME . '/Node/index'));
		if (M('node')->save($_POST)) {
			$this->success('添加成功',U(GROUP_NAME . '/Node/index'));
		} else {
			$this->error('添加失败');
		}
    }

	//删除节点
    public function delete(){
		$id = I('id',0,'intval');
		if (M('node')->where(array('id' => $id))->delete()) {
			$this->success('删除成功',U(GROUP_NAME . '/Node/index'));
		} else {
			$this->error('删除失败');
		}
    }
	
	//排序
	public function reSort() {
		$db = M('node');
		foreach ($_POST as $id => $sort){
			$db->where(array('id' => $id))->setField('sort',$sort);
		}
		$this->redirect(GROUP_NAME . '/Node/index');
    }
}
?>