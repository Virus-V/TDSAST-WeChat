<!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta charset="utf-8">
	<meta author="Virus.V">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" />
	<title>教务认证 - 通达·云校园</title>
	<link rel="stylesheet" type="text/css" href="<{*__THEME__}>/zf_login/style/register-login.css">
</head>
<body>
<div id="box"></div>
<div class="cent-box">
	<div class="cent-box-header">
		<h1 class="main-title hide">通达·云校园</h1>
		<h2 class="sub-title">正方教务认证登录</h2>
	</div>

	<div class="cont-main clearfix">
		<!-- <div class="index-tab">
			<div class="index-slide-nav">
				<a href="login.html" class="active">登录</a>
				<a href="register.html">注册</a>
				<div class="slide-bar"></div>				
			</div>
		</div> -->
		<form method="post" role="form" id="form_login" action="<{$_URLS['zflogin']}>">
			<{foreach $hiddenInput $hk $hv}>
			<input type="hidden" name="<{$hk}>" value="<{$hv}>"/>
			<{/foreach}>
			<div class="login form">
				<div class="group">
					<div class="group-ipt email">
						<input type="text" name="txtUserName" id="txtUserName" class="ipt" placeholder="学号" required>
					</div>
					<div class="group-ipt password">
						<input type="password" name="TextBox2" id="TextBox2" class="ipt" placeholder="登录密码" required>
					</div>
					<div class="group-ipt verify">
						<input type="text" name="txtSecretCode" id="txtSecretCode" class="ipt" placeholder="验证码" required>
						<img src="<{$_URLS['vcode']}>" class="imgcode">
					</div>
				</div>
			</div>

			<div class="button">
				<button type="submit" class="login-btn register-btn" id="button">登录</button>
			</div>

			<!-- <div class="remember clearfix">
				<label class="remember-me"><span class="icon"><span class="zt"></span></span><input type="checkbox" name="remember-me" id="remember-me" class="remember-mecheck" checked>记住我</label>
				<label class="forgot-password">
					<a href="#">忘记密码？</a>
				</label>
			</div> -->
		</form>
	</div>
	<div class="footer">
		<p>通达·云校园 TD-Cloud</p>
		<p>南京邮电大学通达学院大学生科学与技术协会网络部持有最终解释权</p>
	</div>
</div>

<script src='<{*__THEME__}>/zf_login/js/particles.js' type="text/javascript"></script>
<script src='<{*__THEME__}>/zf_login/js/background.js' type="text/javascript"></script>
<script src='<{*__THEME__}>/zf_login/js/jquery.js' type="text/javascript"></script>
<script src='<{*__THEME__}>/zf_login/js/layer/layer.js' type="text/javascript"></script>
<script src='<{*__THEME__}>/zf_login/js/form/dist/jquery.form.min.js' type="text/javascript"></script>

<script>
	$('.imgcode').hover(function(){
		layer.tips("看不清？点击更换", '.verify', {
        		time: 6000,
        		tips: [2, "#3c3c3c"]
    		})
	},function(){
		layer.closeAll('tips');
	}).click(function(){
		$(this).attr('src','<{$_URLS['vcode']}>&'+ Math.random());
	});
	/* $("#remember-me").click(function(){
		var n = document.getElementById("remember-me").checked;
		if(n){
			$(".zt").show();
		}else{
			$(".zt").hide();
		}
	}); */
	$(document).ready(function() {
		var loading;
		var options = {
			dataType: 'json',
			beforeSubmit: function(formData, jqForm, options){
				//显示loading层
				loading = layer.load(1, {
					shade: [0.2,'#fff'] //0.1透明度的白色背景
				});
				return true;
			},
			success: function(jsonObject, statusText, xhr, $form) {
				// 关闭loading层
				layer.close(loading);
				// if the ajaxForm method was passed an Options Object with the dataType
				// property set to 'json' then the first argument to the success callback
				// is the json data object returned by the server
				console.log(jsonObject);
				layer.alert(jsonObject.info, {
					icon: jsonObject.data.result ? 1 : 2,
					skin: 'layer-ext-moon',
					time: 3000,	//3秒后自动关闭
					end: function(){ // 回调函数
						if(jsonObject.data.result) window.location.href=jsonObject.data.callback;
					}
				});
			},  // post-submit callback
			timeout: 3000
		};
		$('#form_login').ajaxForm(options);
	});
</script>
</body>
</html>
