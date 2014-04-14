<?php 
/**
 * 站点信息插件【系统级】
 * @author  <[c@easycms.cc]>
 */
class SiteinfoWidget extends Action{
	public function info($name=''){
		$where['field']=$name;
		$m=M('Fields');
		$result=$m->where($where)->find();
		echo $result['content'];
	}
}