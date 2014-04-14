<?php
/**
 * RBAC用户管理
 * @author  <[s@easycms.cc]>
 */

class RbacuserAction extends CommonAction{
	public function index() {
		$user=D('UserRelation')->field('password',true)->relation(true)->select();
		$this->assign('list',$user);
		$this->display();

	}

	//添加搜索方法
	public function _filter(&$map){
		//判断是否有搜索条件
		if(!empty($_REQUEST['keyword'])){
			$map['username']=array("like","%{$_REQUEST['keyword']}%");
		}
		
	}	
	
	public function add() {
		$role=M('role')->select();
		$this->assign('role',$role);
		$this->display('add');
	}
	
	public function insert(){
		//用户信息
		$user=array(
			'username'=>I('username'),
			'password'=>I('password','','md5'),
			'logintime'=>time(),
			'loginip'=>get_client_ip()
			);
		
		//所属角色
		$role=array();
		if ($uid=M('User')->add($user)) {
			foreach ($_POST['role_id'] as $v) {
				$role[]=array(
					'role_id'=>$v,
					'user_id'=>$uid
					);	
			}
			//添加用户角色
			M('role_user')->addAll($role);
			$this->success('添加成功',U('Admin/Rbac/index'));
		}else{
			$this->error('添加失败');
		}	
	}
	
	public function edit() {
		$model = D('UserRelation');
		$id = $_REQUEST[$model->getPk()];
		$vo = $model->field('password',true)->relation(true)->find($id);
		$name=$vo['role'][0]['remark'];
		$this->assign('name', $name);
		$this->assign('vo', $vo);

		//调取角色信息
		$role=M('role')->select();
		$this->assign('role',$role);

		$this->display('edit');
	}
	public function editpwd(){
		$model = D('UserRelation');
		$id = $_REQUEST[$model->getPk()];
		$vo = $model->find($id);
		$this->assign('vo', $vo);
		$this->display('editpwd');
	}

	public function update() {	
		$model = M('User');

		if (I('password')) {
			$data['password']=md5(I('password'));
			$data['id']=I('id');
		}

		if(false === $model->create($data)) {
			$this->error($model->getError());
		}

		//p($model->create());die;

		if ($_REQUEST['role_id'] != '') {
			$where['user_id']=I('id');
			$data['role_id']=I('role_id');
			M('role_user')->where($where)->save($data);
		}

		// 更新数据
		if(false !== $model->save()) {
			// 回调接口
			if (method_exists($this, '_tigger_update')) {
				$this->_tigger_update($model);
			}
			//成功提示
			$this->success(L('更新成功'));
		} else {
			//错误提示
			$this->error(L('更新失败'));
		}
	}

   public function delAll(){
    	$name='UserRelation';
		$model = M($name);
    	$pk=$model->getPk ();  
		$data[$pk]=array('in', $_POST['ids']);
		$model->where($data)->delete();
		$this->success('批量删除成功');
	}

	public function delete() {
		//删除指定记录
		$model = D('UserRelation');
		if (!empty($model)) {
			$pk = $model->getPk();
			$id = $_REQUEST[$pk];
			if (isset($id)) {
				//判断是否是超级管理员
				$username=M('User')->where(array('id'=>$id))->getField('username');
				if($username == C('RBAC_SUPERADMIN')) $this->error(L('超级管理员无法删除'));

				$condition = array($pk => array('in', explode(',', $id)));
				if (false !== $model->where($condition)->delete()) {
					$this->success(L('删除成功'));
				} else {
					$this->error(L('删除失败'));
				}
			} else {
				$this->error('非法操作');
			}
		}
	}
	
	//删除状态
	public function delete_tag(){
		//删除指定记录
		$model = D('UserRelation');
		if (!empty($model)) {
			$pk = $model->getPk();
			$id = $_REQUEST[$pk];
			if (isset($id)) {
				$condition = array($pk => array('in', explode(',', $id)));
				if (false !== $model->where($condition)->setField('is_delete',1)) {
					$this->success(L('删除成功'));
				} else {
					$this->error(L('删除失败'));
				}
			} else {
				$this->error('非法操作');
			}
		}
	}
	
	/**
	 * 根据表单生成查询条件
	 * 进行列表过滤
	 * @param string $name 数据对象名称
	 * @return HashMap
	 */
	protected function _search($name='') {
		//生成查询条件
		if (empty($name)) {
			$name = $this->getActionName();
		}
		$model = M($name);
		$map = array();
		foreach ($model->getDbFields() as $key => $val) {
			if (substr($key, 0, 1) == '_')
				continue;
			if (isset($_REQUEST[$val]) && $_REQUEST[$val] != '') {
				$map[$val] = $_REQUEST[$val];
			}
		}
		return $map;
	}
	
	/**
	 * 根据表单生成查询条件
	 * 进行列表过滤
	 * @param Model $model 数据对象
	 * @param HashMap $map 过滤条件
	 * @param string $sortBy 排序
	 * @param boolean $asc 是否正序
	 */
	protected function _list($model, $map = array(), $sortBy = '', $asc = false) {
		
		//排序字段 默认为主键名
		if (!empty($_REQUEST['_order'])) {
			$order = $_REQUEST['_order'];
		} else {
			$order = !empty($sortBy)?$sortBy:$model->getPk();
		}
		
		//排序方式默认按照倒序排列
		//接受 sort参数 0 表示倒序 非0都 表示正序
		if (!empty($_REQUEST['_sort'])) {
			$sort = $_REQUEST['_sort'] == 'asc'?'asc':'desc';
		} else {
			$sort = $asc ? 'asc' : 'desc';
		}
		
		//取得满足条件的记录数
		$count = $model->where($map)->count();
		
		//每页显示的记录数
		if (!empty($_REQUEST['numPerPage'])) {
			$listRows = $_REQUEST['numPerPage'];
		} else {
			$listRows = '10';
		}
		
		
		//设置当前页码
		if(!empty($_REQUEST['pageNum'])) {
			$nowPage=$_REQUEST['pageNum'];
		}else{
			$nowPage=1;
		}
		$_GET['p']=$nowPage;
		
		//创建分页对象
		import("ORG.Util.Page");
		$p = new Page($count, $listRows);
		
		
		//分页查询数据
		$list = $model->where($map)->order($order.' '.$sort)
						->limit($p->firstRow.','.$p->listRows)
						->select();
						
		//回调函数，用于数据加工，如将用户id，替换成用户名称
		if (method_exists($this, '_tigger_list')) {
			$this->_tigger_list($list);
		}
		//分页跳转的时候保证查询条件
		foreach ($map as $key => $val) {
			if (!is_array($val)) {
				$p->parameter .= "$key=" . urlencode($val) . "&";
			}
		}
	
		//分页显示
		$page = $p->show();
		
		//列表排序显示
		$sortImg = $sort;                                 //排序图标
		$sortAlt = $sort == 'desc' ? '升序排列' : '倒序排列';   //排序提示
		$sort = $sort == 'desc' ? 1 : 0;                  //排序方式
		

		
		//模板赋值显示
		$this->assign('list', $list);
		$this->assign('sort', $sort);
		$this->assign('order', $order);
		$this->assign('sortImg', $sortImg);
		$this->assign('sortType', $sortAlt);
		$this->assign("page", $page);
		
		$this->assign("search",			$search);			//搜索类型
		$this->assign("values",			$_POST['values']);	//搜索输入框内容
		$this->assign("totalCount",		$count);			//总条数
		$this->assign("numPerPage",		$p->listRows);		//每页显多少条
		$this->assign("currentPage",	$nowPage);			//当前页码
	}
}
