<?php
return array(
	array('ctgry', 'Blog/ctgry', 'id'),
	/* 简单路由定义: array('路由定义','控制器/操作名', '路由对应变量','额外参数') */
	array('/^blog\/(\d+)$/is', 'Blog/show', 'id'),
	/* 正则路由定义: array('正则定义','控制器/操作名', '路由对应变量','额外参数') */
	array('/^blog\/(\d+)\/(\d+)/is', 'Blog/archive', 'year,month'),
);
?>