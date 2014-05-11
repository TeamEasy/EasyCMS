<?php 
/**
* 前台2级列表页
* @author  <[c@easycms.cc]>
*/
class ListAction extends CommonAction
{
	
	Public function index(){
		$catsid=I('catsid','','intval');
		$cats=M('Category')->find($catsid);
		$this->assign('catName',$cats['name']);
		//数据分页
		import('ORG.Util.Page');// 导入分页类
   		$count=M('article')->where("tid=$catsid and islock=0")->count();//获取数据的总数
   		$page=new Page($count,5);
   		$page->setConfig('theme', '<ul class="pagination"><li>%upPage%</li><li>%downPage%</li><li>%prePage%</li><li>%linkPage%</li><li>%nextPage%</li><li>%end%</li></ul>');
   		$show=$page->show();//返回分页信息
		$articles=M('article')->where("tid=$catsid and islock=0")->order('article_id desc')->limit($page->firstRow.','.$page->listRows)->select();
		$this->assign('show',$show);
		$this->assign('count',$count);
		$this->assign('list',$articles);
		//侧栏的数据分配
		$sidebar1=M('Article')->where("tid=$catsid and ispush=1 and islock=0")->order('approval desc')->limit('5')->select();
		$sidebar2=M('Article')->where("tid=$catsid and ispush=1 and islock=0")->order('opposition desc')->limit('5')->select();
		$sidebar3=M('Article')->where("tid=$catsid and ispush=1 and islock=0")->order('rand()')->limit('5')->select();
		//赞多到少
		$this->assign('sidebar1',$sidebar1);
		//赞少到多
		$this->assign('sidebar2',$sidebar2);
		//随机5篇
		$this->assign('sidebar3',$sidebar3);
		$this->display('list_article');
	}
}