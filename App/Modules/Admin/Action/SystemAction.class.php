<?php
/**
* 更新系统缓存
* 更新模版缓存
* @author  <[s@easycms.cc]>
*/
class SystemAction extends CommonAction
{
	
	public function index() {
		$this->display();
	}

	Public function update(){
		SaveSetting($_POST);
	}
	
	Public function updateSystemCache(){
		if(is_dir('./App/Runtime/')){
			my_del('./App/Runtime/');
			echo "更新系统缓存成功";
		}else{
			echo "更新系统缓存成功";
		}
	}


	Public function updateTplCache(){
		if(is_dir('./Html/')){
			my_del('./Html/');
			echo "更新模版缓存成功";
		}else{
			echo "更新模版缓存成功";
		}
	}

}