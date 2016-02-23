<?php

Class HotWidget extends Widget{

	Public function render ($data){
		if (!$HotList=S('Hot_List')){
			$limit = $data['limit'];
			$field = array('id','title','hits');
			$where = array('del' => 0);
			$HotList=M('blog')->field($field)->where($where)->order('hits DESC')->limit($limit)->select();
			S('Hot_List', $HotList, 60, 'File');
			}
		$data['hot'] = $HotList;
		return $this->renderFile('',$data);
	}

}
?>