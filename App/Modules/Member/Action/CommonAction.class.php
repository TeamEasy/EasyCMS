<?php
/**
 * 公共类
 * @author  <[c@easycms.cc]>
 */
class CommonAction extends Action {
	public function _initialize() {
		if (ismobile()) {
            C('DEFAULT_THEME','mobile');
        }
		if(empty($_SESSION[C('USER_AUTH_KEY_F')])){
			$this->error('请先登入',U('Index/Index/index'));
			return;
		}
    	$cats=M('Category')->where('isverify=1 and isshow=1')->limit('5')->select();
		$this->assign('cats',$cats);	
		//侧栏的数据分配
		$sidebar3=M('Article')->where('ispush=1 and islock=0')->order('rand()')->limit('5')->select();
		//随机5篇
		$this->assign('sidebar3',$sidebar3);
	}
	//空操作
	public function _empty(){
		$this->redirect("Person/index");
	}
}
