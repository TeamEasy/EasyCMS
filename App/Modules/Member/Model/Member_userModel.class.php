<?php 
/**
 * 用户信息管理类
 * @author  <[c@easycms.cc]>
 */
class Member_userModel extends Model{
		protected $_validate=array(
		 array('username','/^[a-z0-9]{4,12}$/i','账号信息必须大于2位到10位字符之间'), //
		 array('username','require',"账号必须填写"), 
		 array('password','/^[a-z0-9]{6,16}$/i','密码不能少于6或大于16位之间'),
		 array('password','require','密码必须填写！'),  
		 array('password','require','确认密码必须填写！'),
		 array('verify','require','验证码必须填写！'), 
		 array('repassword','password','确认密码不正确',0,'confirm'),
		 array('email','email',"邮箱格式不正确"),  
		 array('pwd','require','密码必须填写！'),
		 array('rpwd','pwd','确认密码不正确',0,'confirm'),


		);

		
	//自动填充（参考手册中6.17自动完成）
	protected $_auto = array( 
		//array('sex','w'),  //指定某个字段设置某个值
		array("regtime","time","1","function"), //当执行添加时为addtime字段指定time时间
		array('regip',"get_client_ip","1","function"),
		array('password',"mypass","3","callback"), //通过回调本类中的自定义方法对密码做处理
		
	);
	
	protected function mypass(){
		return md5($_POST['password']);
	}
	

		
			


}