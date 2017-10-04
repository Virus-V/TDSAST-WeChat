<!DOCTYPE html>
<html lang="zh-CN">
<head>
<{include header.php}>
<style>
body,button, input, select, textarea,h1 ,h2, h3, h4, h5, h6 { font-family: Microsoft YaHei,'宋体' , Tahoma, Helvetica, Arial, "\5b8b\4f53", sans-serif;
}
#captcha {
	border-radius: 2px;
	cursor: pointer;
	position: absolute;
	z-index: 3;
	left: 0;
	top: 0;
}

#validateCode {
	padding-left: 120px;
}
</style>
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
</head>
<body style="padding-top: 50px">
<{include navigation.php}>

<div class="jumbotron">
  <div class="container animatedParent" data-sequence="500">
    <h1 class="animated init" data-id="1" data-effect-in="fadeInDown">{Hello, World!}</h1>
    <p class="animated init" data-id="2" data-effect-in="fadeInRight">我们是通达云开发团队，我们还都很年轻。</p>
    <p><span id="join_us" class="btn btn-success btn-lg" role="button">要加入我们么？</span></p>
  </div>
</div>
<!-- 页面内容开始 -->
<div class="container">
</div>
<!-- 页面内容结束 -->
<{include footer.php}>

<script>
$(function() {
	$("#join_us").on("click", function( e ) {
		console.log("Open Dialog");
		  new $.flavr({
			title : "加入我们",
			content     : '确定要加入我们么？如果你想好了的话，那就填一张表格吧！',
			animateEntrance : "fadeIn",
			animateClosing : "bounce",
			buttons     : {
				primary : { text: '好的', style: 'primary', 
							action: function(){
								alert('Primary button');
								return false;
							}
				},
				close   : { text: '不了，我再想想', style: 'default' }
			}
          });
	});
});
</script>
</body>
</html>