<?php     
    session_start(); // 세션    
    $conn = mysqli_connect('localhost', 'mysql', 'petclub1!!', 'petclubs');

    if($_SESSION['id'] == null){
        echo "<script>location.href='login.php';</script>";
    }

    $basename = basename($_SERVER["PHP_SELF"]);
	$t = microtime();
?>
<!doctype html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=1300">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>펫클럽 관리자</title>
<link rel="shortcut icon" href="images/layout/favicon.ico" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="common/css/base.css?t=<?= $t ?>" media="all">
<script type="text/javascript" src="common/js/jquery.js?t=<?= $t ?>"></script>
<script type="text/javascript" src="common/js/jquery.form.js?t=<?= $t ?>"></script>
<script type="text/javascript" src="common/js/jquery-ui.min.js?t=<?= $t ?>"></script>
<script type="text/javascript" src="common/js/common.js?t=<?= $t ?>"></script>
<script type="text/javascript" src="common/js/validation.js?t=<?= $t ?>"></script>
<script type="text/javascript" src="common/js/function.js?t=<?= $t ?>"></script>
<script type="text/javascript" src="common/js/init.js?t=<?= $t ?>"></script>
<script type="text/javascript" src="smarteditor/js/HuskyEZCreator.js?t=<?= $t ?>"></script>
<script type="text/javascript">
    wFn.goPop = function() {
        location.href= "member.php";
    };
</script>
</head>
<body>
	<!-- wrap -->
	<section id="wrap1">
		<!-- header -->
		<header id="header">
			<div class="inner">
				<h1>
                    <a href="main.php" title="펫클럽 메인">    
                        <img src="/assets/image/petclub_logo.png" alt="" style="margin-top: 10px;"/>
                    </a>    
                </h1>
				<ul class="header_info">
					<li class="user_data"><em><?= $_SESSION['id']?></em> 님 환영합니다.</li>
					<li class="logout"><a href="javascript:wFn.goPop();" class="btn type_02">패스워드 변경</a></li>
					<li class="logout"><a href="loginOut.php">로그아웃</a></li>
				</ul>
			</div>
		</header>
		<section id="container">
			<aside id="lnb">
				<ul>
					<li class="two_depth <?php if($basename == "main.php" || $basename == "popup.php") {?>actived<?php } ?>">
						<a href="javascript:;"><span>메인화면</span></a>
						<ul class="snb">
							<li class="<?php if($basename == "main.php") {?>actived<?php } ?>" ><a href="main.php"><span>메인화면 데이터 수정</span></a></li>
							<li class="<?php if($basename == "popup.php") {?>actived<?php } ?>" ><a href="popup.php"><span>메인 팝업 관리</span></a></li>
						</ul>
					</li>
					<li class="two_depth <?php if($basename == "petclub_about.php") {?>actived<?php } ?>">
						<a href="javascript:;"><span>펫클럽 소개</span></a>
						<ul class="snb">
							<li class="<?php if($basename == "petclub_about.php") {?>actived<?php } ?>" ><a href="petclub_about.php"><span>숫자데이터 수정</span></a></li>
						</ul>
					</li>
					
					<li class="two_depth <?php if($basename == "new_store.php"||$basename == "store_list.php") {?>actived<?php } ?>">
						<a href="javascript:;"><span>매장소개</span></a>
						<ul class="snb">
							<li class="<?php if($basename == "new_store.php") {?>actived<?php } ?>" ><a href="new_store.php"><span>매장 신규등록</span></a></li>
							<li class="<?php if($basename == "store_list.php") {?>actived<?php } ?>" ><a href="store_list.php"><span>매장 관리</span></a></li>
						</ul>
					</li>
					
					<li class="two_depth <?php if($basename == "franchise_list.php" or $basename == "franchise_regist.php" ) {?>actived<?php } ?>">
						<a href="javascript:;"><span>가맹정보</span></a>
						<ul class="snb">
							<li class="<?php if($basename == "franchise_list.php" or $basename == "franchise_regist.php") {?>actived<?php } ?>" ><a href="franchise_list.php"><span>월매출 데이터 수정</span></a></li>
						</ul>
					</li>
					
					<li class="two_depth <?php if($basename == "write.php" || $basename == "list.php") {?>actived<?php } ?>">
						<a href="javascript:;"><span>뉴스&이벤트</span></a>
						<ul class="snb">
							<li class="<?php if($basename == "write.php") {?>actived<?php } ?>" ><a href="write.php"><span>게시글 등록</span></a></li>
							<li class="<?php if($basename == "list.php") {?>actived<?php } ?>" ><a href="list.php"><span>게시글 관리</span></a></li>
						</ul>
					</li>

				</ul>
			</aside>