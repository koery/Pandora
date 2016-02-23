<?php

class ListAction extends Action{

    public function index(){
		import('Class.Category',APP_PATH);
		import('Class.Page',APP_PATH);
		
		$id = I('id');
		$cate = M('cate')->order('sort')->select();
		$cids = Category::getChildrenID($cate, $id);
		$cids[] = $id;
		
		$where = array('del' => 0, 'cid' => array('IN',$cids));
		$count = M('blog')->where($where)->count();
		$page = new Page($count,10);
		$limit = $page->firstRow . ',' .$page->listRows;

		$blog = D('BlogView')->getData($where,$limit);
	
		$this->blog = $blog;
		$this->page = $page->show();
		$this->display();
    }
}
?>