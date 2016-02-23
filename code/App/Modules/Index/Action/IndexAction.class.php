<?php
class IndexAction extends Action{
    public function index(){
		if (!$MainList=S('main_list')){//S函数缓存数据 有效提高首页访问速度
			$MainList = M('cate')->where(array('pid' => 0 ))->order('sort')->select();
			import('Class.Category',APP_PATH);
			$cate = M('cate')->order('sort')->select();
			$db = M('blog');
			$field = array('id','title','time');
			foreach ($MainList as $k =>$v) {
				$cids =Category::getChildrenId($cate,$v['id']);
				$cids[] = $v['id'];
				$where = array('del' => 0, 'cid' => array('IN',$cids));
				$MainList[$k]['blog'] = $db->field($field)->where($where)->limit(20)->order('time DESC')->select();
			}
			//首页数据模型 一次将需要的数据全部读出
			S('main_list', $MainList, 60, 'File');
		}
		$this->cate = $MainList;
		$this->display('');
    }
}
?>