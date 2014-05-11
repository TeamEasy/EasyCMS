<?php 
/**
 * 个人信息类
 * @author  <[l@easycms.cc]>
 */
class PersonAction extends CommonAction{
	public function index(){
		if(!$_SESSION[C('USER_AUTH_KEY_F')]){
			$this->error("请先登陆");
		}
		$User=M('Member_user');
		$id=$_SESSION[C('USER_AUTH_KEY_ID')];
		$result =$User->find($id);
		$this->assign('persons',$result);
		$this->display('index');
	}
	public function person(){
		$User=M('Member_user');
		$id['user_id']=$_SESSION[C('USER_AUTH_KEY_ID')];
		$result =$User->where($id)->find();
		$this->assign('persons',$result);
		$this->display('person');
	}

	public function data(){
		$User=M('Member_user');
		$id['user_id']=$_SESSION[C('USER_AUTH_KEY_ID')];
		$result =$User->where($id)->find();
		$this->assign('persons',$result);
		$this->display('data');
	}
	public function avatar(){
		$User=M('Member_user');
		$id['user_id']=$_SESSION[C('USER_AUTH_KEY_ID')];
		$result =$User->where($id)->find();
		$this->assign('persons',$result);
		$this->display('avatar');
	}
	
	public function Profile(){
		$User=D('Member_user');
		$result=$User->create();
		if(!$result){
 			$this->error(($User->getError()));
		}else{
			$where['email']=$result['email'];
			$where['sex']=$result['sex'];
			$id=$_POST['id'];
			$m=$User->where($where)->find();
				if($m){
					$this->error('邮箱未更新');
				}else{
					$wheres['email']=$result['email'];
					$wheres['sex']=$result['sex'];
					$m=$User->where("user_id=$id")->save($where);
				if($m){
					$this->success('更新成功');

				}else{
					$this->error('更新失败');
				}
			}
			
		}
	}


	public function pwd(){
			$User=D('Member_user');
			$result=$User->create();
			if(!$result){
 				$this->error(($User->getError()));
			}else{
				$id=$_SESSION[C('USER_AUTH_KEY_ID')];
				$mm['password']=$result['password'];
				$m=$User->where("user_id=$id")->find();
				if($m['password']==$mm['password']){
					if($m['password']==md5($_POST['pwd'])){
						$this->error('修改的密码不能和原密码一样哦');
					}
				$pwd['password']=md5($_POST['pwd']);
				$pwd=$User->where("user_id=$id")->save($pwd);
				if($m){
					$this->success('更新成功');

				}else{
					$this->error('更新失败');
				}
			}else{
				
				$this->error('密码错误');
			}
		}
	}





}