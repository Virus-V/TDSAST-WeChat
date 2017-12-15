<!DOCTYPE html>
<html lang="zh-CN">
<head>
<{include pc_page/header.php}>
<style>
body,button, input, select, textarea,h1 ,h2, h3, h4, h5, h6 { font-family: Microsoft YaHei,'宋体' , Tahoma, Helvetica, Arial, "\5b8b\4f53", sans-serif;
}
html, body {
	height:100%;
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
svg {
  width: 100%;
  height: 100%;
}
svg g {
  mix-blend-mode: lighten;
}
svg polygon {
  stroke: none;
  fill: white;
}
#main-info{
	position:relative;
}
#main-info-bg{
	position:absolute;
	top:0px;
	left:0px;
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
<{include pc_page/navigation.php}>

<div id="main-info" class="jumbotron">
	<svg id="main-info-bg" viewBox="0 0 800 400" preserveAspectRatio="xMidYMid slice">
		<defs>
			<linearGradient id="grad1" x1="0" y1="0" x2="1" y2="0" color-interpolation="sRGB">
				<stop id="stop1a" offset="0%" stop-color="#12a3b4"></stop>
				<stop id="stop1b" offset="100%" stop-color="#ff509e"></stop>
			</linearGradient>
			<linearGradient id="grad2" x1="0" y1="0" x2="1" y2="0" color-interpolation="sRGB">
				<stop id="stop2a" offset="0%" stop-color="#e3bc13"></stop>
				<stop id="stop2b" offset="100%" stop-color="#00a78f"></stop>
			</linearGradient>
		</defs>
		<rect id="rect1" x="0" y="0" width="800" height="400" stroke="none" fill="url(#grad1)"></rect>
		<rect id="rect2" x="0" y="0" width="800" height="400" stroke="none" fill="url(#grad2)"></rect>
	</svg>
  <div class="container animatedParent" data-sequence="500">
    <h1 class="animated init" data-id="1" data-effect-in="fadeInDown">{Hello, World!}</h1>
    <p class="animated init" data-id="2" data-effect-in="fadeInRight">我们是通达云开发团队，我们还都很年轻。</p>
    <!-- <p><span id="join_us" class="btn btn-success btn-lg" role="button">要加入我们么？</span></p> -->
  </div>
</div>

<!-- 页面内容开始 -->

<div class="clearfix"></div>
<div id="main-content" class="container">


</div>
<!-- 页面内容结束 -->
<{include pc_page/footer.php}>

<{import type="js" file="TweenMax#min,Stats#min,main-info-bg" basepath="(THEME_PATH)/pc_page/js" baseurl="(__THEME__)/pc_page/js"}> 
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