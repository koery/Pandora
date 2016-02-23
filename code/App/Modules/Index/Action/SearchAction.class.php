<?php
/*
查询表达式不仅可用于查询条件，也可以用于数据更新，例如：
1.$User = M("User"); // 实例化User对象
2. // 要修改的数据对象属性赋值
3. $data['name'] = 'ThinkPHP';
4. $data['score'] = array('exp','score+1');// 用户的积分加1
5. $User->where('id=5')->save($data); // 根据条件保存修改的数据
*/

class SearchAction extends Action{

    public function index(){
		import('Class.Page',APP_PATH);
		
		$id = I('id',0,'intval');
		if ($id!=0) {
			import('Class.Category',APP_PATH);
			$cate = M('cate')->order('sort')->select();
			$cids = Category::getChildrenID($cate, $id);
			$cids[] = $id;
			}
		
		$key = I('key','');
		//echo $id.'<br/>'.$key;
		//die;
		
		$where['content']  = array('like', '%' . $key .'%');
		$where['notes']  = array('like', '%' . $key .'%');
		$where['_logic'] = 'or';
		$map['_complex'] = $where;
		$map['del'] = array('eq',0);
		if ($id!=0) { $map['cid'] = array('IN',$cids); }

		$count = M('blog')->where($map)->count();
		$page = new Page($count,10);
		$limit = $page->firstRow . ',' .$page->listRows;

		$blog = D('BlogView')->getData($map,$limit);
	
		$this->blog = $blog;
		$this->page = $page->show();
		$this->display();
    }
}
?>