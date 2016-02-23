<?php

Class NewWidget extends Widget{

	Public function render ($data){
		if (!$NewList=S('Newest_List')){
			$limit = $data['limit'];
			$field = array('id','title','time');
			$where = array('del' => 0);
			$NewList= M('blog')->field($field)->where($where)->order('time DESC')->limit($limit)->select();
			S('Newest_List', $NewList, 60, 'File');
		}
		$data['new'] = $NewList;
		return $this->renderFile('',$data);
	}

}
?>