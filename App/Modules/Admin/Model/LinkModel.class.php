<?php
/**
 * 自定义链接模型类
 * @author  <[l@easycms.cc]>
 */
class LinkModel extends Model{
	
	//自动验证（参考手册中6.15自动验证）
   protected $_validate=array(
			array('name','require','名字必须填写!'),
			array('url','/(http|https)\:\/\/(\w*\.?)*/i','url格式错误'),
			
		);
	
}
