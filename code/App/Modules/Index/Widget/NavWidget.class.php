<?php

Class NavWidget extends Widget{

	Public function render ($data){
		if (!$NavList=S('Nav_List')){
			$field = array('id','name','pid','sort');
			$cate = M('cate')->field($field)->order('sort ASC')->select();
			import('Class.Category',APP_PATH);
			$NavList = Category::unlimitedForLayer($cate);
			S('Nav_List', $NavList, 60, 'File');
			}
		$data['nav'] = $NavList;
		return $this->renderFile('',$data);
	}

}
?>