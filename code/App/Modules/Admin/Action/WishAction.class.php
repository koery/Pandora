<?php
/**
*留言管理
*/
class WishAction extends CommonAction{

	//留言列表
    public function index(){
		$count = M('wish')->count();
		//import('ORG.Util.Page');
		import('Class.Page',APP_PATH);
		$page = new Page($count,10);
		$limit = $page->firstRow . ',' . $page->listRows;
		$wish = M('wish')->order('time DESC')->limit($limit)->select();
		$this->wish = $wish;
		$this->page = $page->show();
		$this->display();
    }

	//添加留言
    public function add(){
		$this->pid = I('pid',0,'intval');
		$this->display();
    }

    public function addPost() {
		if (!IS_POST) _404('页面不存在',U(GROUP_NAME . '/Wish/index'));
		if (M('wish')->add($_POST)) {
			$this->success('添加成功',U(GROUP_NAME . '/Wish/index'));
		} else {
			$this->error('添加失败');
		}
    }

	//修改留言
    public function edit(){
		$id = I('id',0,'intval');
		$wish = M('wish')->where(array('id' => $id))->select();
		if (!$wish) _404('留言不存在',U(GROUP_NAME . '/Wish/index'));
		$wish = $wish[0];
		$this->wish = $wish;
		$this->display();
    }

    public function editPost() {
		if (!IS_POST) _404('页面不存在',U(GROUP_NAME . '/Wish/index'));
		if (M('wish')->save($_POST)) {
			$this->success('添加成功',U(GROUP_NAME . '/Wish/index'));
		} else {
			$this->error('添加失败');
		}
    }

	//删除留言
    public function delete(){
		$id = I('id',0,'intval');
		if (M('wish')->where(array('id' => $id))->delete()) {
			$this->success('删除成功',U(GROUP_NAME . '/Wish/index'));
		} else {
			$this->error('删除失败');
		}
    }
	
	//排序
	public function reSort() {
		$db = M('wish');
		foreach ($_POST as $id => $sort){
			$db->where(array('id' => $id))->setField('sort',$sort);
		}
		$this->redirect(GROUP_NAME . '/Wish/index');
    }
}
?>