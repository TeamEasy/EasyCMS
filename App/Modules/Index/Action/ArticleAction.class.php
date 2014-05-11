<?php
/**
* 前台文章发布
* @author  <[c@easycms.cc]>
*/
class ArticleAction extends CommonAction
{
	
	Public function index(){
		$article_id=I('articleid','','intval');
		$this->assign('aid',$article_id);
		$article=D('Article')->relation(true)->where("article_id=$article_id")->find();
		//前一篇文章
		$preArticle=M('Article')->where("article_id<$article_id")->order('article_id desc')->limit(1)->find();
		$this->assign('preArticle',$preArticle);
		//后一篇文章
		$nextArticle=M('Article')->where("article_id>$article_id")->limit(1)->find();
		$this->assign('nextArticle',$nextArticle);
		$this->assign('article',$article);
		//侧栏的数据分配
		$sidebar1=M('Article')->where('ispush=1 and islock=0')->order('approval desc')->limit('5')->select();
		$sidebar2=M('Article')->where('ispush=1 and islock=0')->order('opposition desc')->limit('5')->select();
		$sidebar3=M('Article')->where('ispush=1 and islock=0')->order('rand()')->limit('5')->select();
		//赞多到少
		$this->assign('sidebar1',$sidebar1);
		//赞少到多
		$this->assign('sidebar2',$sidebar2);
		//随机5篇
		$this->assign('sidebar3',$sidebar3);
		//设置前台文章标题右侧的钩子，插件机制
		$p=M('Plugin')->where("position=1 and isinstalled=1")->select();
		$this->assign('plugin1',$p);
		//获取文章的二维码图片从谷歌api
		$qrcode='http://'.$_SERVER['HTTP_HOST'].__URL__."/index/articleid/$article_id";
		$this->assign('qrcode',$qrcode);
		if($article['modelid']==1){
			preg_match_all("/<img(.*)src=\"([^\"]+)\"[^>]+>/isU",$article['content'],$matches);
            $img = $matches[2];
    		$this->assign('imgs',$img);
    		//dump($img);
			$this->display('image_article');
		}else{
			$this->display('article_article');
		}
	}

	public function addComment(){
		if($_SESSION[C('USER_AUTH_KEY_ID')]){
			//对回复速度进行判断
			$aid=I('aid','','intval');
			$uid=$_SESSION[C('USER_AUTH_KEY_ID')];
			$lastPubtime=M('Comment')->where("uid=$uid and aid=$aid")->order('commend_id desc')->
			limit('1')->getField('pubtime');
			if(time()-$lastPubtime<30){
				echo '发帖太快，请30秒后再发布';
				die;
			}
			$comment= I('comment');
			if($comment==''){
				echo '评论不能为空';
				die;
			}
			//更新推荐和反对的数量
			$proposal=I('proposal','','intval');
			if($proposal){
				M('Article')->execute("update __TABLE__  set approval=approval+1 where article_id=$aid");
			}else{
				M('Article')->execute("update __TABLE__  set opposition=opposition+1 where article_id=$aid");
			}
			$data['uid']=$uid;
			$data['aid']=$aid;
			$data['pubtime']=time();
			$data['islock']=0;
			$data['content']=htmlspecialchars($comment);
			$m=M('Comment')->add($data);
			if($m){
				echo '评论成功';
				die;
			}else{
				echo '评论失败';
				die;
			}
		}else{
			echo '请登陆后评论';
			die;
		}
	}



	public function checkuser(){
		if (isset($_SESSION['username'])) {
			echo '	 <li><a>'.$_SESSION['username'].'</a></li>
         			 <li><a href="'.U('Member/person/index').'" style="color:red">个人中心</a></li>
         			 <li><a href="'.U('Index/login/doLogout').'">退出</a></li>';
		}else{
			echo '	 <li><a href="'.U('Index/Login/checkreg').'">注册</a></li>
        			 <li><a href="'.U('Index/Login/index').'">登陆</a></li>';
		}
	}
}
