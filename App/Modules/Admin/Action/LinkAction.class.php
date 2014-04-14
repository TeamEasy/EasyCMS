<?php
/**
 * 友情链接管理
 * @author  <[l@easycms.cc]>
 */
class LinkAction extends CommonAction{
	public function index() {
		$map = $this->_search('link');
			if(method_exists($this, '_filter')) {
				$this->_filter($map);
			}
		$model = M('link');
			if (!empty($model)) {
				$this->_list($model, $map);
			}
		$this->display();
		return;
	}
	//判断是否可以进行搜索  搜索功能
	public function _filter(&$map){
		if(!empty($_REQUEST['keyword'])){
			$map['name']=array("like","%{$_REQUEST['keyword']}%");
		}
		
	}	
	
	//添加功能
	public function add() {
		$this->display('add');
	}
	public function insert(){
		$model = D('Link');
		$model->create();
			unset ( $_POST [$model->getPk()] );
				if (false === $model->create()) {
	 				$this->error($model->getError());
	 			}
		
	 			if ($result = $model->add()) { 
	 				if (method_exists($this, '_tigger_insert')) {
	 					$model->id = $result;
	 					$this->_tigger_insert($model);
	 			}
						$this->success(L('添加成功'));
				} else {
						$this->error(L('添加失败').$model->getLastSql());
	 			}
	}
	
	//修改功能
	public function edit() {
		$model = M('link');
		$id = $_REQUEST[$model->getPk()];
		$vo = $model->find($id);
		$this->assign('vo', $vo);
		$this->display('edit');
	}
	public function update() {
		$model = D('Link');
			if(false === $model->create()) {
				$this->error($model->getError());
		}
	
			if(false !== $model->save()) {
				if (method_exists($this, '_tigger_update')) {
					$this->_tigger_update($model);
			}
					$this->success(L('更新成功'));
			} else {
			
					$this->error(L('更新失败'));
			}
	}
	






	public function changeState() {
		$model = M("link"); // 实例化对象
		$pk = $model->getPk();
		$condition[$pk]=$_REQUEST[$pk];
		$data['isverify'] = ($_REQUEST['isverify']==0)?1:0;
		$model->where($condition)->save($data); // 根据条件保存修改的数据
		if(false !== $model->where($condition)->save($data)) {
	 	//成功提示
			$this->success(L('更新成功'));
		 } else {
		// 	//错误提示
		 	$this->error(L('更新失败'));
		 }
	}
	
	//批量删除
   public function delAll(){
    	$name='link';
		$model = M($name);
    	$pk=$model->getPk ();  
		$data[$pk]=array('in', $_POST['ids']);
		$model->where($data)->delete();
		$this->success('批量删除成功');
	}
	
	//删除状态
	public function delete_tag(){
		$model = M('link');
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
		//$list = $model->where($map)->order($order . ' ' . $sort)->select();
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
	
	
	
		
		$this->assign("search",			$search);			//搜索类型
		$this->assign("values",			$_POST['values']);	//搜索输入框内容
		$this->assign("totalCount",		$count);			//总条数
		$this->assign("numPerPage",		$p->listRows);		//每页显多少条
		$this->assign("currentPage",	$nowPage);			//当前页码
	}
}
