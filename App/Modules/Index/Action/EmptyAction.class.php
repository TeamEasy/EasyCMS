<?php
/**
 * 空类
 * @author  <[c@easycms.cc]>
 */
class EmptyAction extends Action {
	//空模块  /abc
	public function index(){		
		$this->dispath();
    }
	//空操作 /abc/xy
	public function _empty(){
		$this->dispath();
	}
	public function dispath(){	
		$url = (0===strpos($_SERVER['REQUEST_URI'],__ROOT__)) ? substr($_SERVER['REQUEST_URI'], strlen(__ROOT__)) : $_SERVER['REQUEST_URI'];  //以前用的PATH_INFO，有缺陷
		$rewrite = trim(urldecode($url),'/');	
		$rewrite = str_replace(__APP__.'/','',__ACTION__); 
		$rewrite = preg_replace('/[\/]+/','/',str_replace(array('?','&','='), '/', $rewrite));
		$exp = explode('/', $rewrite);		
		$exp[0] = strtolower($exp[0]);
		if($exp[0]=='index' && count($exp)>1 && strtolower($exp[1])!='index'){
			R(ucfirst($exp[0]) .'/'. strtolower($exp[1]));
			exit;
		}
		$rs = M("Router")->where(array('rewrite'=>$exp[0]))->field('url')->find();
		if($rs){			
			//把news/p/2 转成 article/index/id/224/p/2 附加参数
			for($i=1,$n=count($exp); $i<$n; $i++){
				if($exp[$i]!='') $rs['url'] .= '/'.$exp[$i];
			}
			//形如id/2/a/1/b/B/c/C的 参数转化为数组
			$exp = explode('/', $rs['url']);
			$vars = array();
			for($i=2,$n=count($exp)-1; $i<$n; $i++){
				$vars[$exp[$i]]=$exp[$i+1];
				$i++;
			}
			R(ucfirst($exp[0]).'/'.$exp[1], $vars);
		}else{
			$this->redirect("index/index");
		}	
	}
}