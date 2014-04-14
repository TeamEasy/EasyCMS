<?php 
/**
 * 头像上传类
 * @author  <[l@easycms.cc]>
 */
class UpperAction extends CommonAction{

	Public function index(){
		import('ORG.Net.UploadFile');
		$upload = new UploadFile();// 实例化上传类
		$upload->maxSize  = 512000000 ;// 设置附件上传大小
		$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$upload->savePath =  './Uploads/Picture/Avatar/';// 设置附件上传目录
		$upload->thumb = true;
		$upload->thumbPrefix = 'avatar_';
		$upload->thumbMaxWidth = '148';
		$upload->thumbMaxHeight = '148';
		$upload->thumbRemoveOrigin = true;
		$upload->saveRule = time () . '_' . mt_rand ( 1000000, 9999999 );
		if(!$upload->upload()) {// 上传错误提示错误信息
			$this->error($upload->getErrorMsg());
		}else{// 上传成功 获取上传文件信息
			$info =  $upload->getUploadFileInfo();
		}
		 
		// 保存表单数据 包括附件数据
		$User = M("Member_user"); // 实例化User对象
		//$User->create(); // 创建数据对象
		$upload= $info[0]['savename']; // 保存上传的照片根据需要自行组装
		$data['photo']=$upload;
		$id=$_SESSION[C('USER_AUTH_KEY_ID')];
		$m=$User->where("user_id=$id")->save($data); 
		// 写入用户数据到数据库
		if($m){
			$this->success('头像保存成功！');
		}else{
			$this->success('头像保存失败！');
		}
		
	}



}