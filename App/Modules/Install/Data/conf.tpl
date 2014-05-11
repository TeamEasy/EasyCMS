<?php
/**
 * 系统配文件
 * 所有系统级别的配置
 */
$a=include './App/Conf/setting.config.php';
$b=array(
    /* 模块相关配置 */
    'APP_GROUP_LIST'     => 'Index,Admin,Install,Member',//开启分组模式
    'DEFAULT_GROUP'      => 'Index',//默认分组
    'APP_GROUP_MODE'     => 1,//开启独立分组
    'APP_GROUP_PATH'     => 'Modules',//独立分组文件夹名称

    /* 调试配置 */
    'SHOW_PAGE_TRACE' => false,

    /* URL配置 */
    'URL_CASE_INSENSITIVE' => true, //默认false 表示URL区分大小写 true则表示不区分大小写
    'URL_MODEL'            => 3, //URL模式
    'VAR_URL_PARAMS'       => '', // PATHINFO URL参数变量
    'URL_PATHINFO_DEPR'    => '/', //PATHINFO URL分割符

    /* 全局过滤配置 */
    'DEFAULT_FILTER' => '', //全局过滤函数

    /* 数据库配置 */
    'DB_TYPE'   => '[DB_TYPE]', // 数据库类型
    'DB_HOST'   => '[DB_HOST]', // 服务器地址
    'DB_NAME'   => '[DB_NAME]', // 数据库名
    'DB_USER'   => '[DB_USER]', // 用户名
    'DB_PWD'    => '[DB_PWD]',  // 密码
    'DB_PORT'   => '[DB_PORT]', // 端口
    'DB_PREFIX' => '[DB_PREFIX]', // 数据库表前缀

     /* 模版相关配置 */
    'TMPL_DEFAULT_THEME' => 'default',  //默认模版主题
    'URL_HTML_SUFFIX'	=>	'html',
    'TMPL_L_DELIM'		=>	'<{', //修改左定界符
    'TMPL_R_DELIM'		=>	'}>', //修改右定界符
    'TMPL_PARSE_STRING'	=>	array(
	    '__CSS__'		=>	__ROOT__.'/Public/Css',
	    '__JS__'		=>	__ROOT__.'/Public/Js',
	    '__IMAGES__'	=>	__ROOT__.'/Public/Images',
   	),

    'USER_AUTH_KEY_F'   =>  'username',
    'USER_AUTH_KEY_ID'   => 'user_id',
    'ADMIN_AUTH_KEY_B'=> 'adminuser',
    /* RBAC配置 */
    'RBAC_SUPERADMIN' => '[RBAC_SUPERADMIN]',       //超级管理员名称
    'ADMIN_AUTH_KEY'  => 'superadmin',  //超级管理员识别
    'USER_AUTH_ON'    => true,          //是否开启验证
    'USER_AUTH_TYPE'  => 1,             //验证类型（1：登录验证，2：时时验证）
    'USER_AUTH_KEY'   => 'uid',         //用户认证识别号
    'NOT_AUTH_MODULE' => 'Index',       //无需认证的控制器
    'NOT_AUTH_ACTION' => 'insert,upload,addCat,update',            //无需认证的动作方法
    'RBAC_ROLE_TABLE' => '[DB_PREFIX]role',   //角色表名称 
    'RBAC_USER_TABLE' => '[DB_PREFIX]role_user',//角色表与用户表的中间表名称
    'RBAC_ACCESS_TABLE'=>'[DB_PREFIX]access', //权限表名称
    'RBAC_NODE_TABLE' => '[DB_PREFIX]node',   //节点表名称

     /* 模糊查询相关配置 */
    'DB_LIKE_FIELDS'    =>  'title|content',

     /* html缓存配置 */
    'HTML_CACHE_ON'     =>  '0',   //缓存是否开启
    'HTML_FILE_SUFFIX'  =>  '.html', //静态文件后缀
    'HTML_CACHE_RULES'  =>  array(  //缓存规则
        'list:'         =>  array('list/list_{catsid}','600'),
        'article:'      =>  array('article/art_{articleid}','600'),
    ),
    'HTML_CACHE_TIME'   =>  60, //静态缓存有效期

    'settingfile_path'  =>  './App/Conf/setting.config.php',

     /* 数据库备份相关 */
    'DATA_BACKUP_PATH' => './Data/',
    'DATA_BACKUP_PART_SIZE' => 20971520,
    'DATA_BACKUP_COMPRESS' => 1,
    'DATA_BACKUP_COMPRESS_LEVEL' => 9,

    //自定义跳转页面
    'TMPL_ACTION_SUCCESS' =>'./App/Modules/Index/Tpl/Public/jump.html',
    'TMPL_ACTION_ERROR' => './App/Modules/Index/Tpl/Public/jump.html',
);
return array_merge($b,$a);
