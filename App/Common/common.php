<?php
/**
 * 修改用户锁定状态
 * @param  [number] $status   [状态值]
 * @param  [number] $id       [id]
 * @param  string $callback [返回值]
 * @return [string]          [组合链接]
 */
function showStatus($status, $id, $callback="") {
	switch ($status) {
		case 0 :
			$info = '<a href="__URL__/changeState/user_id/'.$id.'/islock/0/navTabId/listusers" target="ajaxTodo" callback="'.$callback.'">锁定</a>';
			break;
		case 1 :
			$info = '<a href="__URL__/changeState/user_id/'.$id.'/islock/1/navTabId/listusers" target="ajaxTodo" callback="'.$callback.'">恢复</a>';
			break;
	}
	return $info;

}

function changeInstall($status, $id, $callback="") {
	switch ($status) {
		case 0 :
			$info = '<a href="__URL__/changeInstall/plugin_id/'.$id.'/isinstalled/0/navTabId/listplugin" target="ajaxTodo" callback="'.$callback.'">安装</a>';
			break;
		case 1 :
			$info = '<a href="__URL__/changeInstall/plugin_id/'.$id.'/isinstalled/1/navTabId/listplugin" target="ajaxTodo" callback="'.$callback.'">卸载</a>';
			break;
	}
	return $info;

}


function showReason($status, $id, $callback=""){
	switch ($status) {
		case 0 :
			$info = '<a href="__URL__/changeState/link_id/'.$id.'/isverify/0/navTabId/listlink" target="ajaxTodo" callback="'.$callback.'">恢复显示</a>';
			break;
		case 1 :
			$info = '<a href="__URL__/changeState/link_id/'.$id.'/isverify/1/navTabId/listlink" target="ajaxTodo" callback="'.$callback.'">禁止显示</a>';
			break;
	}
	return $info;
}

function rubbish($status, $id, $callback=""){
	switch ($status) {
		case 1 :
			$info = '<a href="__URL__/changeState/article_id/'.$id.'/islock/1/navTabId/listarticle1" target="ajaxTodo" callback="'.$callback.'">恢复显示</a>';
			break;
		case 0 :
			$info = '<a href="__URL__/changeState/article_id/'.$id.'/islock/0/navTabId/listarticle" target="ajaxTodo" callback="'.$callback.'">加入回收站</a>';
			break;
	}
	return $info;
}

function crubbish($status, $id, $callback=""){
	switch ($status) {
		case 1 :
			$info = '<a href="__URL__/changeState/commend_id/'.$id.'/islock/1/navTabId/listcomment1" target="ajaxTodo" callback="'.$callback.'">恢复显示</a>';
			break;
		case 0 :
			$info = '<a href="__URL__/changeState/commend_id/'.$id.'/islock/0/navTabId/listcomment" target="ajaxTodo" callback="'.$callback.'">加入回收站</a>';
			break;
	}
	return $info;
}


function imgs($status,$id){
	$info1="../Public/../default/Images/test.jpeg";
	preg_match("/<img(.*)src=\"([^\"]+)\"[^>]+>/isU",$status,$matches);
	if(!empty($matches)){
              return  $img = $matches[2];
    }else{
              return  $info1;
    }
}

function photos($status){
	if(!$status==null){
              return  './Uploads/Picture/Avatar'.'/'.'avatar_'.$status;
    }else{
                return  './Uploads/Picture/Avatar'.'/'.'nophoto.gif';
    }
}


function SaveSetting($arr){
	$setfile=C('settingfile_path');
	$a=include './App/Conf/setting.config.php';
	$c=array_merge($a,$arr);
	$settingstr="<?php\n\r return ".var_export($c,TRUE)."\n\r?>";
	file_put_contents($setfile,$settingstr);
}


/**
 *自定义的删除函数,可以删除文件和递归删除文件夹
 */
 function my_del($path)
{
	if(is_dir($path))
	{
			$file_list= scandir($path);
			foreach ($file_list as $file)
			{
				if( $file!='.' && $file!='..')
				{
					my_del($path.'/'.$file);
				}
			}
			@rmdir($path);  //这种方法不用判断文件夹是否为空,	因为不管开始时文件夹是否为空,到达这里的时候,都是空的		
	}
	else
	{
		@unlink($path);    //这两个地方最好还是要用@屏蔽一下warning错误,看着闹心
	}

}

/**
 * 格式化字节大小
 * @param  number $size      字节数
 * @param  string $delimiter 数字和单位分隔符
 * @return string            格式化后的带单位的大小
 */
function format_bytes($size, $delimiter = '') {
    $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
    for ($i = 0; $size >= 1024 && $i < 5; $i++) $size /= 1024;
    return round($size, 2) . $delimiter . $units[$i];
}

/**
 * [移动端访问自动切换主题模板]
 * @return boolen [是否为手机访问]
 */
function ismobile() {
    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
        return true;
    
    //此条摘自TPM智能切换模板引擎，判断是否为客户端
    if(isset ($_SERVER['HTTP_CLIENT']) &&'PhoneClient'==$_SERVER['HTTP_CLIENT'])
        return true;
    //如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset ($_SERVER['HTTP_VIA']))
        //找不到为flase,否则为true
        return stristr($_SERVER['HTTP_VIA'], 'wap') ? true : false;
    //判断手机发送的客户端标志,兼容性有待提高
    if (isset ($_SERVER['HTTP_USER_AGENT'])) {
        $clientkeywords = array(
            'nokia','sony','ericsson','mot','samsung','htc','sgh','lg','sharp','sie-','philips','panasonic','alcatel','lenovo','iphone','ipod','blackberry','meizu','android','netfront','symbian','ucweb','windowsce','palm','operamini','operamobi','openwave','nexusone','cldc','midp','wap','mobile'
        );
        //从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
            return true;
        }
    }
    //协议法，因为有可能不准确，放到最后判断
    if (isset ($_SERVER['HTTP_ACCEPT'])) {
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
            return true;
        }
    }
    return false;
 }

 function removeXSS($val)	{
	// remove all non-printable characters. CR(0a) and LF(0b) and TAB(9) are allowed
	// this prevents some character re-spacing such as <java\0script>
	// note that you have to handle splits with \n, \r, and \t later since they *are* allowed in some inputs
	$val = preg_replace('/([\x00-\x08][\x0b-\x0c][\x0e-\x20])/', '', $val);

	// straight replacements, the user should never need these since they're normal characters
	// this prevents like <IMG SRC=&#X40&#X61&#X76&#X61&#X73&#X63&#X72&#X69&#X70&#X74&#X3A&#X61&#X6C&#X65&#X72&#X74&#X28&#X27&#X58&#X53&#X53&#X27&#X29>
	$search = 'abcdefghijklmnopqrstuvwxyz';
	$search.= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$search.= '1234567890!@#$%^&*()';
	$search.= '~`";:?+/={}[]-_|\'\\';

	for ($i = 0; $i < strlen($search); $i++) {
		// ;? matches the ;, which is optional
		// 0{0,7} matches any padded zeros, which are optional and go up to 8 chars

		// &#x0040 @ search for the hex values
		$val = preg_replace('/(&#[x|X]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val); // with a ;
		// &#00064 @ 0{0,7} matches '0' zero to seven times
		$val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val); // with a ;
	}

	// now the only remaining whitespace attacks are \t, \n, and \r
	$ra1 = array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
	$ra2 = array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
	$ra = array_merge($ra1, $ra2);

	$found = true; // keep replacing as long as the previous round replaced something
	while ($found == true) {
		$val_before = $val;
		for ($i = 0; $i < sizeof($ra); $i++) {
			$pattern = '/';
			for ($j = 0; $j < strlen($ra[$i]); $j++) {
				if ($j > 0) {
					$pattern .= '(';
					$pattern .= '(&#[x|X]0{0,8}([9][a][b]);?)?';
					$pattern .= '|(&#0{0,8}([9][10][13]);?)?';
					$pattern .= ')?';
				}
				$pattern .= $ra[$i][$j];
			}
			$pattern .= '/i';
			$replacement = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2); // add in <> to nerf the tag
			$val = preg_replace($pattern, $replacement, $val); // filter out the hex tags
			if ($val_before == $val) {
				// no replacements were made, so exit the loop
				$found = false;
			}
		}
	}

	return $val;
}
