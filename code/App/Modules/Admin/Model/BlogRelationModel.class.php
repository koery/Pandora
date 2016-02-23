<?php
Class BlogRelationModel extends RelationModel {

	Protected $tableName= 'blog';  //注意变量字母的大小写，严格要求一致

	Protected $_link= array(
		'attr' => array(
			'mapping_type' => MANY_TO_MANY,
			'mapping_name' => 'attr',
			'foreign_key' => 'bid',
			'relation_foreign_key' => 'aid',  //
			'relation_table' => 'hd_blog_attr',
		),
		'cate' => array(
			'mapping_type' => BELONGS_TO,
			'foreign_key' => 'cid',
			'mapping_fields' => 'name',
			'as_fields' => 'name:cate'
		),
	);

	Public function getBlogs ($where,$limit){
		$field = array('del');
		return $this->field($field,true)->relation(true)->where($where)->order('time DESC')->limit($limit)->select();
	}

}
?>