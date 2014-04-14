 <?php
/**
* 自定义后台用户模型类
* @author  <[s@easycms.cc]>
*/
class UserRelationModel extends RelationModel
{	
	//定义主表名称
	Protected $tableName='user';
	Protected $prefix=null;
	
	//定义关联关系
	Protected $_link=array(
		'role' => array(
			'mapping_type' => MANY_TO_MANY, 	//关联关系：多对多关系
			'foreign_key'  => 'user_id'	,		//主表在中间表中字段名称
			'relation_key' => 'role_id',		//副表在中间表中的字段名称
			'relation_table' => 'easy_role_user',//中间表名称
			'mapping_fields' => 'id,name,remark'//过滤字段
			)
		);

	
}