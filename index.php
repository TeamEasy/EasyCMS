<?php
	header('content-type:text/html;charset=utf-8');
	//1确认应用名称App
	define('APP_NAME','App');
	//2确定应用路径
	//App后必须加/,否则创建目录路径混乱
	define('APP_PATH','./App/');
	//定义缓存文件路径
	define('HTML_PATH','./Html/');
	//3.开启调试模式
	define('APP_DEBUG',true);
	//3应用核心文件(区分大小写，windows不需要区分，但是linux需要)
	require './ThinkPHP/ThinkPHP.php';

