<?php
/**
*分类管理
*/
class CategoryAction extends CommonAction{

	//分类列表
    public function index(){
		//echo APP_PATH;
		$cate = M('cate')->order('sort ASC')->select();
		import('Class.Category',APP_PATH);
		$cate = Category::unlimitedForLevel($cate);
		$this->cate = $cate;
		$this->display();
    }

	//添加分类
    public function add(){
		$this->pid = I('pid',0,'intval');
		$this->display();
    }

    public function addPost() {
		if (!IS_POST) _404('页面不存在',U(GROUP_NAME . '/Category/index'));
		if (M('cate')->add($_POST)) {
			$this->success('添加成功',U(GROUP_NAME . '/Category/index'));
		} else {
			$this->error('添加失败');
		}
    }

	//修改分类
    public function edit(){
		$id = I('id',0,'intval');
		$cate = M('cate')->where(array('id' => $id))->select();
		if (!$cate) _404('分类不存在',U(GROUP_NAME . '/Category/index'));
		$cate = $cate[0];
		$this->cate = $cate;
		$this->display();
    }

    public function editPost() {
		if (!IS_POST) _404('页面不存在',U(GROUP_NAME . '/Category/index'));
		if (M('cate')->save($_POST)) {
			$this->success('添加成功',U(GROUP_NAME . '/Category/index'));
		} else {
			$this->error('添加失败');
		}
    }

	//删除分类
    public function delete(){
		$id = I('id',0,'intval');
		if (M('cate')->where(array('id' => $id))->delete()) {
			$this->success('删除成功',U(GROUP_NAME . '/Category/index'));
		} else {
			$this->error('删除失败');
		}
    }
	
	//重新排序
	public function reSort() {
		$db = M('cate');
		foreach ($_POST as $key => $value){
			$ids = explode('_',$key);
			$id = $ids[0];
			switch ($ids[1]) {
				case 0:
					$db->where(array('id' => $id))->setField('pid',$value);
					break;
				case 1:
					$db->where(array('id' => $id))->setField('sort',$value);
					break;
			}
		}
		$this->redirect(GROUP_NAME . '/Category/index');
    }
}
?>