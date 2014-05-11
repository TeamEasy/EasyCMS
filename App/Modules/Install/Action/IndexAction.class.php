<?php
/**
 * 安装首页
 * @author  <[s@easycms.cc]>
 */
class IndexAction extends Action{
	//安装首页
	public function index(){
		$this->theme('default');
		if(file_exists('./App/Modules/Install/Data/install.lock')){
			$this->error('已经成功安装了EasyCMS，请不要重复安装!如果需要重装，请先删除./App/Modules/Install/Data/install.lock');
		}
		session_destroy();
		session_start();
		session('step', 0);
		session('error', false);
		$this->display();
	}
	
	//安装完成
	public function complete(){
		$this->theme('default');
		$step = session('step');

		if(!$step){
			$this->redirect('index');
		} elseif($step != 3) {
			$this->redirect("Install/step{$step}");
		}

		file_put_contents('./App/Modules/Install/Data/install.lock', 'lock');//创建锁定文件
		$this->assign('info',session('config_file'));

		session('step', null);
		session('error', null);
		$this->display();
	}
}
