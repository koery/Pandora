<?php

Class BlogViewModel extends ViewModel {

	Protected $viewFields= array(
		'blog' => array(
			'id', 'title', 'time', 'hits', 'notes',
			'_type' => 'LEFT'
			),
		'cate' => array(
			'name','_on' =>'blog.cid=cate.id'
			)
	);

	Public function getData($where, $limit) {
		return $this->where($where)->limit($limit)->order('time DESC')->select();
	}

}

?>