<!DOCTYPE html>
<html lang="ko">
<head>
    <title>펫클럽 관리자</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="common/images/content/favicon.ico" />
    <link rel="icon" href="common/images/content/favicon.png">
    <link rel="stylesheet" type="text/css" href="common/css/base.css" media="all">
    <script type="text/javascript" src="common/js/jquery.js"></script>
    <script type="text/javascript" src="common/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="common/js/common.js"></script>
    <script type="text/javascript" src="common/js/validation.js"></script>
    <script type="text/javascript" src="common/js/init.js?111"></script>
</head>
<body>
<!-- wrap -->
<section id="wrap">
<form id="login" name="login" action="loginProc.php" onsubmit="return false;">
	<div class="login_wrap">
		<div class="d_t">
			<div class="d_c">
				<fieldset>
					<legend>로그인 입력 폼</legend>
					<div class="login_input">
						<h1><img src="/assets/image/petclub_logo.png" alt=""/></h1>
						<p class="info">펫클럽 관리자 로그인</p>
						<div class="input_wrap">
							<input type="text" name="in_userid" id="in_userid" placeholder="ID" value="" />
							<input type="password" name="in_passwd" id="in_passwd" placeholder="PW" value="" onkeypress="if(event.keyCode==13) javascript:wFn.setLogin(this);"/>
						</div>
						<p class="btn"><a href="#" onClick="javascript:wFn.setLogin(this);">LOGIN</a></p>
					</div>
				</fieldset>
			</div>
		</div>
	</div>
</form>
</section>
</body>
</html>