<?php
/**
 * 自定义评论类
 * @author  <[c@easycms.cc]>
 */
class CommentModel extends RelationModel{
	
	protected $_link = array(
	            'Member_user'=>array(
	            	'mapping_type'=>BELONGS_TO,
	                'foreign_key'=>'uid',
	             	'as_fields'=>'username',
               ),
	           	'Article'=>array(
	            	'mapping_type'=>BELONGS_TO,
	                'foreign_key'=>'aid',
	             	'as_fields'=>'title',
               ),
	);
}
