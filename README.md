程序默认要求开启rewrite重写，

如果没有开启需要在安装前和安装后两次修改App\Conf下的config.php中的URL_MODEL为1。

此时安装需要使用 "网址/index.php/install" 的安装路径,此时后台地址"网址/index.php/admin"

如果程序已经开启了rewrite重写功能那么直接下载程序访问 "网址/install" 的安装路径,此时后台地址"网址/admin"

测试数据在安装后进入后台系统管理下数据库恢复里可以恢复查看，测试数据的表前缀
是默认的easy_，如果在安装时不是直接使用默认的表前缀则不能后台直接恢复测试数据，测试数据默认后台账号密码都是admin


							陈捷编写
						  联系邮箱c@easycms.cc
