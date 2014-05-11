<?php
/**
* 前台首页
* @author  <[c@easycms.cc]>
*/
class IndexAction extends CommonAction
{ 
	Public function index(){
		$cats=D('Category');
		$link=M('link');
		$portrait=M('Member_user');
		$article=M('article');
		//首页中部3篇文章推荐展示
		$mPushArticle=$article->where('isslides=1 and islock=0')->order('rand()')->select();
		//首页下部4个分类推荐展示
		$dPushCats = $cats->limit('4')->where('ispush=1 and isverify=1')->relation(true)->select();
		$approval1=$article->where('ispush=1 and islock=0')->order('article_id desc')->limit('5')->select();
		$approval3=$article->where('ispush=1 and islock=0')->order('rand()')->limit('5')->select();
		$approval2=$article->where('ispush=1 and islock=0')->order('article_id desc')->limit('5')->select();
		$links=$link->where("isverify=1")->select();
		$portraits=$portrait->where('islock=0')->limit('24')->order('user_id desc')->select();
		//首页中部3篇文章推荐展示
		$this->assign('modelid1',$mPushArticle);
		//这个是页面下面的4个板块
		$this->assign('modelid0',$dPushCats);
		//按赞的次数进行遍历
		$this->assign('approval',$approval1);
		//随机精选5篇文章
		$this->assign('approval3',$approval3);
		//评论最多5篇的文章
		$this->assign('links',$links);
		//显示首页友情链接
		$this->assign('portrait',$portraits);
		//显示首页右侧用户注册头像
		$this->assign('approval2',$approval2);
		//显示模板	
		$this->display('index');
	}
}
