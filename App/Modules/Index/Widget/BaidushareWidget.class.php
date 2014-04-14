<?php 
/**
 * 百度分享插件
 * @author  <[c@easycms.cc]>
 */
class BaidushareWidget extends Action{
	public function info($name=''){
		$this->display(dirname(__FILE__).'/Baidushare/info.html');
	}
}