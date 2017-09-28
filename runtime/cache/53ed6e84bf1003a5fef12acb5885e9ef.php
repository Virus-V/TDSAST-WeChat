<?php /* VPF 模板缓存文件 生成时间:2016-05-31 12:28:07 */ ?>
<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><meta http-equiv='Refresh' content='3; URL=<?php echo($jumpUrl); ?>'><title><?php echo(Vpf\L('_OPERATION_TIPS_')); ?></title><style>html, body, dl, dt, dd, span, ol, li {
	margin:0;
	padding:0;
	border:none;
}
html, body {
	height:100%;
	font:14px Tahoma, Verdana;
	line-height:150%;
	background-color: #FFF;
}
dl.box {
	position:absolute;
	top:50%;
	left:50%;
	margin:-150px 0 0 -300px;
	width:600px;
	background:#fff;
	border:#aaa 1px solid;
	box-shadow: 0 0 8px rgba(255, 255, 255, 0.5);

	border-bottom:2px solid #E2E2E9;
	border-radius:5px;
	
}
dl.box dt {
	padding:0 10px;
	height:30px;
	color:#CCC;
	font-size:14px;
	font-weight:bold;
	line-height:30px;
	border-bottom:1px solid #ccc;
	background-color: #333;
}
dd.message {
	padding: 20px;
	color: #999;
	background: #fff;
	border-bottom:1px solid #e5e5e5;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
span.icon {
	display:block;
	margin:10px;
	width:16px;
	height:16px;
	border-radius:10px;
}
span.success {
	border:1px solid #06C;
	background-color: #09F;
}
span.error {
	border:1px solid #C33;
	background-color: #F30;
}
ol.msgList li {
	list-style:decimal inside;
}
dd.direction {
	padding:10px 20px;
	text-align:right;
	;
}
a.btn {
	display: inline-block;
	padding: 0 10px;
	height: 24px;
	margin: 0 0 0 5px;
	text-align: center;
	vertical-align: middle;
	color: #666;
	font-size: 12px;
	line-height: 24px;
	text-decoration: none;
	background: #fff;
	border: #aaa 1px solid;
	border-radius: 3px;
}
a.btn:hover {
	color: #333;
	border: #666 1px solid;
}
</style></head><body><dl class="box"><dt><?php echo(Vpf\L('_OPERATION_TIPS_')); ?></dt><dd class="message"><table border="0" cellpadding="0" cellspacing="0"><tr><td valign="top" width="60"><span class="icon <?php echo($status); ?>"></span></td><td><ol class="msgList"><?php if(is_array($message)) :  ?><?php if(is_array($message)) : foreach($message as $m) : ?><li><?php echo($m); ?></li><?php endforeach; endif; ?><?php else : ?><?php echo($message); ?><?php endif; ?></ol></td></tr></table></dd><dd class="direction"><a href="javascript:history.go(-1)" class="btn"><?php echo(Vpf\L('_GO_BACK_')); ?></a><a href="<?php echo(__APP__); ?>" class="btn"><?php echo(Vpf\L('_GO_HOME_')); ?></a><a href="<?php echo($jumpUrl); ?>" class="btn"><?php echo(Vpf\L('_GO_NEXT_')); ?></a></dd></dl></body></html>