<?php
//用户角色关联模型
Class UserRelationModel extends RelationModel {
	//主表名称
	Protected $tableName= 'admin';  //注意变量字母的大小写，严格要求一致

	//定义关联关系
	Protected $_link= array(
		'role' => array(
			'mapping_type' => MANY_TO_MANY,  //多对多关系
			'mapping_name' => 'role',
			'foreign_key' => 'user_id',//主表在中间表中的字段名称
			'relation_key' => 'role_id',  //foreign_//副表在中间表中的字段名称
			'relation_table' => 'hd_role_user',//中间表名称
			'mapping_fields' => 'id,name,remark'
		)
	);

}
?>