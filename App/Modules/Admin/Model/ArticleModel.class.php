<?php
/**
 * 自定义文章模型类
 * @author  <[c@easycms.cc]>
 */
class ArticleModel extends RelationModel{
	
	protected $_link = array(
	            'Category'=>array(
	            	'mapping_type'=>BELONGS_TO,
	                'foreign_key'=>'tid',
	             	'as_fields'=>'name,modelid',
               ),
	);
	
	protected $_auto = array( 
		array("pubtime","time","1","function"),
	);
	
	protected function mypass(){
		return md5($_POST['password']);
	}
}
