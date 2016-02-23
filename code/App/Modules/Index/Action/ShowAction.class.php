<?php

class ShowAction extends Action {
    public function index() {
		$id = I('id');
		$where = array('id' => $id);
		$field = array('id','title','content','cid','time');
		$this->blog = M('blog')->field($field)->find($id);
		
		$cid = $this->blog['cid'];
		import('Class.Category',APP_PATH);
		$cate = M('cate')->order('sort')->select();
		$this->parents = Category::getParents($cate,$cid);
		
		$this->display();
    }

    public function hits() {
		$id = I('id');
		$where = array('id' => $id);
		$hits = M('blog')->where($where)->getField('hits');
		M('blog')->where($where)->setInc('hits');
		echo 'document.write(' .$hits . ')';
	}

}
?>