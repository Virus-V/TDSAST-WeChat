<?php
return array(
	'Thn:index'=>array('Thn/{thn_id}'),
	'Hot:index'=>array('Hot/{ctgry_id}'),
	'Img:index'=>array('Img/{thn_id}'),
	'Nws:index'=>array('Nws/{thn_id}'),
);
/*
静态规则的定义方式:
第一种是定义全局的操作静态规则，例如定义所有的read操作的静态规则为
	'read'=>array('{id}','60')
	其中，{id} 表示取$_GET['id'] 为静态缓存文件名，第二个参数表示缓存60秒
第二种是定义全局的控制器静态规则，例如定义所有的User控制器的静态规则为
	'User:'=>array('User/{:action}_{id}','600')
	其中，{:action} 表示当前的操作名称
第三种是定义某个控制器的操作的静态规则，例如，我们需要定义Blog控制器的read操作进行静态缓存
	'Blog:read'=>array('{id}',-1)
第四种方式是定义全局的静态缓存规则，这个属于特殊情况下的使用，任何控制器的操作都适用，例如
	'*'=>array('{$_SERVER.REQUEST_URI|md5}'), 根据当前的URL进行缓存

静态规则的写法可以包括以下情况:
1、使用系统变量 包括 _GET _REQUEST _SERVER _SESSION _COOKIE
	格式：{$_×××|function}
	例如：{$_GET.name} {$_SERVER. REQUEST_URI}
2、使用框架特定的变量
	例如：{:app}、{:ctrl}  和{:actn} 分别表示当前应用名、控制器名和操作名
3、使用_GET变量
	{var|function}
	也就是说 {id} 其实等效于 {$_GET.id}
4、直接使用函数
	{|function}
	例如：{|time}
5、支持混合定义，例如我们可以定义一个静态规则为：
	'{id},{name|md5}'
在{}之外的字符作为字符串对待，如果包含有”/”，会自动创建目录。
	例如，定义下面的静态规则：
	{:ctrl}/{:actn}_{id}
	则会在静态目录下面创建控制器名称的子目录，然后写入操作名_id.html 文件。
*/
?>