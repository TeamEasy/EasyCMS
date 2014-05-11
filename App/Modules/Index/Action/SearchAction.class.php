<?php
/**
* 前台搜索
* @author  <[s@easycms.cc]>
*/
class SearchAction extends CommonAction
{
	Public function index(){
		$put=I('s');
		if(trim($put)==''){
			$this->error('搜索内容不能为空！');
			die;
		}
		$where['title']=$put;
		$where['content']=$put;

		$count=M('Article')->where($where)->count();
		import('ORG.Util.Page');
		$page=new page($count,10);
		$page->setConfig('theme', '<ul class="pagination"><li>%upPage%</li><li>%downPage%</li><li>%prePage%</li><li>%linkPage%</li><li>%nextPage%</li><li>%end%</li></ul>');
		$show=$page->show();//返回分页信息
		$article=M('article')->where($where)->limit($page->firstRow.','.$page->listRows)->select();
		$this->assign('put',$put);
		$this->assign('show',$show);//分页信息
		$this->assign('count',$count);//数据总数
		$this->assign('list',$article);//数据集
		

		//侧栏的数据分配
		$sidebar1=M('Article')->where("ispush=1 and islock=0")->order('approval desc')->limit('5')->select();
		$sidebar2=M('Article')->where("ispush=1 and islock=0")->order('opposition desc')->limit('5')->select();
		$sidebar3=M('Article')->where("ispush=1 and islock=0")->order('rand()')->limit('5')->select();
		//赞多到少
		$this->assign('sidebar1',$sidebar1);
		//赞少到多
		$this->assign('sidebar2',$sidebar2);
		//随机5篇
		$this->assign('sidebar3',$sidebar3);
		$this->display('search');
	}
	
}