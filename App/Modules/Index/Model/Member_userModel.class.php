<?php 
/**
 * 自定义会员模型类
 * @author  <[c@easycms.cc]>
 */
class Member_userModel extends Model{
	protected $_validate=array(
		 array('username','/(^[A-Za-z0-9]{2,12}$)|(^[\x{4e00}-\x{9fa5}]{2,10}$)/u','请输入2到12个字符或者汉字'),
		 array('username','require',"账号必须填写"), 
		 array('username','','帐号名称已经存在！',0,'unique',1),// 在新增的时候验证name字段是否唯一
		 array('password','/^[a-z0-9]{6,16}$/i','密码不能少于6或大于16位之间'),
		 array('password','require','密码必须填写！'),  
		 array('password','require','确认密码必须填写！'),
		 array('verify','require','验证码必须填写！'), 
		 array('repassword','password','确认密码不正确',0,'confirm'),
		 array('email','email',"邮箱格式不正确"),  
		 array('pwd','require','密码必须填写！'),
		 array('rpwd','pwd','确认密码不正确',0,'confirm'),


		);

		
	//自动填充
	protected $_auto = array( 
		//array('sex','w'),  //指定某个字段设置某个值
		array("regtime","time","1","function"), //当执行添加时为addtime字段指定time时间
		array('regip',"get_client_ip","1","function"),
		array('password',"mypass","3","callback"), //通过回调本类中的自定义方法对密码做处理
		array('username',"myname","1","callback"),
		
	);


	protected function myname(){
		return strtolower($_POST['username']);
	}
	
	protected function mypass(){
		return md5($_POST['password']);
	}
	

		
			


}
