<?php
return array(
	/* 是否开启调试模式 */
	'APP_DEBUG' => true,
	/* 1:普通模式 2:PATHINFO模式 3:REWRITE模式 4:兼容模式 */
	'URL_TYPE' => 1, 
	/* 是否开启静态缓存 */
	//'HTML_CACHE' => true, 
	/* 是否开启URL路由 */
	//'URL_ROUTER' => true, 
	/* 运行时间 */
	'SHOW_RUN_TIME' => false, 
	/* 详细的运行时间 */
	'SHOW_ADV_TIME' => false, 
	/* 数据库查询和写入次数 */
	'SHOW_DB_TIMES' => false, 
	/* 缓存操作次数 */
	'SHOW_CACHE_TIMES' => false, 
	/* 内存开销 */
	'SHOW_USE_MEM' => false, 
	/* 页面跟踪信息 */
	'SHOW_PAGE_TRACE' => false, 
	/* 用户名 */
	'DB_USER' => 'root', 
	/* 密码 */
	'DB_PWD' => '1124732794', 
	/* 服务器地址 */
	'DB_HOST' => 'localhost', 
	/* 数据库名 */
	'DB_NAME' => 'jhedu', 
	/* 数据库默认编码 */
	'DB_CHARSET' => 'utf8', 
	/* 数据库表前缀 */
	'DB_PREFIX' => 'jh_', 
	/* 数据库表后缀 */
	'DB_SUFFIX' => '',
	/* MQTT服务器配置信息 */
	'MQTT_CFG' => array(
		'mqtt_broker_ip' => '139.129.19.29',
		'mqtt_broker_port' => 1883,
		'username' => 'extdoor',
		'password' =>'extdoor12345',
		'client_id' => 'TDSAST-IOT-Wechat',
	),
);
?>