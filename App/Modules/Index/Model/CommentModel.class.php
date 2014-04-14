<?php
/**
 * 自定义文章评论模型类
 * @author  <[c@easycms.cc]>
 */
class CommentModel extends RelationModel{
	
	protected $_link = array(
	            'Member_user'=>array(
	            	'mapping_type'=>BELONGS_TO,
					
	                'foreign_key'=>'uid',
			
	             	'as_fields'=>'username',
               ),
	);

	
	//自动填充
	protected $_auto = array( 
		array("pubtime","time","1","function"),//
	);
	
	protected function mypass(){
		return md5($_POST['password']);
	}
	

}
