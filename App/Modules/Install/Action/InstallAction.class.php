<?php
/**
 * 安装引导类
 * @author  <[s@easycms.cc]> 
 */
class InstallAction extends Action{

	protected function _initialize(){
		$this->theme('default');
		if(session('step') === null){
			$this->redirect('Index/index');
		}
		if(file_exists('/App/Modules/Install/data/install.lock')){
			$this->error('已经成功安装了EasyCMS，请不要重复安装!');
		}
	}

	//安装第一步，检测运行所需的环境设置
	public function step1(){
		session('error', false);
	
		$env = check_env();//环境检测	
		$dirfile = check_dirfile();//目录文件读写检测	
		$func = check_func();//函数检测

		session('step', 1);

		$this->assign('env', $env);
		$this->assign('func', $func);
		$this->assign('dirfile', $dirfile);
		$this->display();
	}

	//安装第二步，创建数据库
	public function step2($db = null, $admin = null){
		if(IS_POST){
			//检测管理员信息
			if(!is_array($admin) || empty($admin[0]) || empty($admin[1]) || empty($admin[2])){
				$this->error('请填写完整管理员信息');
			} else if($admin[1] != $admin[2]){
				$this->error('确认密码和密码不一致');
			} else {
				$info = array();
				list($info['username'], $info['password'], $info['repassword'])= $admin;//缓存管理员信息
				session('admin_info', $info);
			}

			//检测数据库配置
			if(!is_array($db) || empty($db[0]) ||  empty($db[1]) || empty($db[2]) || empty($db[3])){
				$this->error('请填写完整的数据库配置');
			} else {
				$DB = array();
				list($DB['DB_TYPE'], $DB['DB_HOST'], $DB['DB_NAME'], $DB['DB_USER'], $DB['DB_PWD'],
					 $DB['DB_PORT'], $DB['DB_PREFIX']) = $db;
				//缓存数据库配置
				session('db_config', $DB);

				//创建数据库
				$dbname = $DB['DB_NAME'];
				unset($DB['DB_NAME']);
				$db  = Db::getInstance($DB);
				$sql = "CREATE DATABASE IF NOT EXISTS `{$dbname}` DEFAULT CHARACTER SET utf8";		
				$db->execute($sql);//如果数据库不存在创建数据库
			}

			//跳转到数据库安装页面
			$this->redirect('step3');
		} else {

			session('error') && $this->error('环境检测没有通过，请调整环境后重试！');

			$step = session('step');
			if($step != 1 && $step != 2){
				$this->redirect('step1');
			}

			session('step', 2);
			$this->display();
		}
	}

	//安装第三步，安装数据表，创建配置文件
	public function step3(){
		if(session('step') != 2){
			$this->redirect('step2');
		}

		$this->display();

		//连接数据库
		$dbconfig = session('db_config');
		$db = Db::getInstance($dbconfig);

		//创建数据表
		create_tables($db, $dbconfig['DB_PREFIX']);

		//注册创始人帐号
		$admin = session('admin_info');
		//var_dump($admin);die;
		register_administrator($db, $dbconfig['DB_PREFIX'], $admin);

		$dbconfig['RBAC_SUPERADMIN']=$_SESSION['admin_info']['username'];
		//创建配置文件
		$conf 	=	write_config($dbconfig);
		session('config_file',$conf);
		if(session('error')){
		} else {
			session('step', 3);
			sleep(3);
			$this->redirect('Index/complete');
		}
	}
}
