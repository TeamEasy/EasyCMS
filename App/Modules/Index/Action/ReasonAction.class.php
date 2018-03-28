<?php 
/**
 * 前台友情链接
 * @author  <[l@easycms.cc]>
 */
class  ReasonAction extends CommonAction{
	public function index (){
			$article=M('article');
			$approval1=$article->where('ispush=1 and islock=0')->order('article_id desc')->limit('5')->select();
			$approval3=$article->where('ispush=1 and islock=0')->order('rand()')->limit('5')->select();
			$approval2=$article->where('ispush=1 and islock=0')->order('article_id desc')->limit('5')->select();
			$this->assign('approval',$approval1);
			$this->assign('approval2',$approval2);
			$this->assign('approval3',$approval3);
			$this->display('reason');
		}
		
	public function add(){
		$link = D("Link"); 
		if (!$link->create()){
			$this->error(($link->getError()));
		}else{
			$urlname=$link->create();
			foreach($urlname as $key => $value){
				$urlname[$key] = removeXSS($value);
			}
			$link->add($urlname);
			if($link){
				$this->success('友情链接申请提交成功，管理员审核中',U('Index/index'));
			}else{
				$this->error('友情链接申请提交失败');
			}
		}
	}
}