<?php include 'top.php'; ?>
<?php 
	$list_idx = $_GET['idx'];
    $conn = mysqli_connect('localhost', 'mysql', 'petclub1!!', 'petclubs');

	$sql = "
		select 
			a.content
			, a.board_name
			, a.list_idx
			, a.title
			, a.summary
			, concat(concat(concat(concat(concat(substr(a.ins_date, 1, 4), \"년 \"), substr(a.ins_date, 5, 2)), '월 '), substr(a.ins_date, 7, 2) ), '일') as ins_date 
			, a.company
			, a.url
			, a.people
		from board_list_view a
		where a.list_idx= '$list_idx'
	";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_array($result);
	if($row != null) {
		$content = $row['content'];
		$title = $row['title'];
		$list_idx = $row['list_idx'];
		$summary = $row['summary'];
		$ins_date = $row['ins_date'];
		$board_name = $row['board_name'];
		$url = $row['url'];
		$people = $row['people'];
		$company = $row['company'];
	}
?>
	<div class="wrapper">
		<section class="board-banner sub-banner">
			<div class="container">
				<h2 class="font_S">펫클럽 소식</h2>
				<p class="font_G">펫클럽의 뉴스와 이벤트 소식을 
					알려드립니다.</p>
			</div>
		</section>
		<section class="sec-board-detail sec-board sec-main">
			<div class="container">
				<div class="single-post-layout1">
					<div class="row">
						<div class="col-lg-9">
							<div class="blog-posts-layout2">
								<div class="bg-post">
									<div class="bg-post-info">
										<ul class="meta">
											<li><a class="category" href="#" title=""><?= $board_name ?></a></li>
											<li><?= $ins_date ?></li>
										</ul>
										<h2><?= $title ?></h2>
										<p><?= $content ?></p>
									</div>
								</div><!--bg-post end-->
								<div class="bg-posted-author">
									<div class="author-info">
										<h3><a href="#" title=""><?= $people ?></a></h3>
										<span><?= $company ?></span>
										<a href="<?= $url ?>">
											<?= $url ?>
                                        </a>
									</div>
								</div><!--bg-posted-author end-->
							</div>
						</div>
						<div class="col-lg-3">
							<div class="sidebar blog-sidebar">
								<div class="widget widget-search">
									<form id="frm" name="frm" action="board.php" method="post">
										<input type="hidden" name="keywordType" value="<?= $keywordType ?>" />
                                        <input type="hidden" id="page" name="page" value="<?= $page ?>" />
										<input type="text" name="keyword" placeholder="검색어를 입력하세요..." value="<?=$keyword ?>">
										<button type="submit" onClick="goPage(1);"><i class="lni lni-search"></i></button>
                                    </form>
								</div><!--widget-search end-->
								<div class="widget widget-categories">
									<h3 class="widget-title">카테고리</h3>
									<ul>
                                        <?php
                                        $sql = "
                                            select count(*) as cnt
                                            from (
                                                select * 
                                                from board_list_view
                                                where en_board_name like '%$keywordType%' 
                                                and title like '%$keyword%'
                                                and display = 'Y'
                                                order by list_idx desc
                                            ) a
                                        ";
                                        $result = mysqli_query($conn, $sql);
                                        $row = mysqli_fetch_array($result);
                                        $tot_cnt = $row['cnt'];
                                        ?>
										<li <?php if ($keywordType == null) { ?> class="active" <?php } ?> >
											<a href="#" onClick="javascript:setKeywordType('');">전체보기</a>
											<span><?= $tot_cnt ?></span>
										</li>
                                        <?php
                                        $sql = "
                                            select en_board_name
                                                , board_name
                                                , count(list_idx) as cnt
                                            from (
                                                select a.en_name as en_board_name
                                                    , a.name  as board_name
                                                    , b.list_idx
                                                from board_master  a
                                                left outer join board_list_view b
                                                on a.idx = b.master_idx
                                                and b.en_board_name like '%$keywordType%' 
                                                and b.title like '%$keyword%'
                                                and b.display = 'Y'
                                                order by b.list_idx desc
                                            ) a
                                            group by en_board_name, board_name
                                            order by en_board_name desc
                                        ";
                                        $result = mysqli_query($conn, $sql);
                                        while($row = mysqli_fetch_array($result)) {
                                        ?>
                                        <li <?php if($keywordType == $row['en_board_name']) { ?> class="active" <?php } ?>>
											<a href="#" onClick="javascript:setKeywordType('<?= $row['en_board_name'] ?>');">
                                                <?= $row['board_name'] ?>
                                            </a>
											<span><?= $row['cnt'] ?></span>
										</li>
                                        <?php
                                        }
                                        ?>
									</ul>
								</div><!--widget-categories end-->
								<div class="widget widget-popular-posts d-none d-lg-block">
									<h3 class="widget-title">인기게시물 </h3>
									<ul class="wd-posts">
                                        <?php
                                        $sql = "
                                            select a.title 
                                                , a.list_idx
                                                , concat(concat(concat(concat(concat(substr(a.ins_date, 1, 4), '년 '), substr(a.ins_date, 5, 2)), '월 '), substr(a.ins_date, 7, 2) ), '일') as ins_date 
                                            from board_list_view a
                                            where popular = 'Y'
                                        ";
                                        $result = mysqli_query($conn, $sql);
                                        while($row = mysqli_fetch_array($result)) {
                                        ?>
										<li>
											<div class="pp-post">
												<h3>
                                                    <a href="post.php?idx=<?= $row['list_idx'] ?>" title="">
                                                        <?= $row['title'] ?>
                                                    </a>
                                                </h3>
												<span><?= $row['ins_date'] ?></span>
											</div><!--pp-post end-->
										</li>
                                        <?php
                                        }
                                        ?>
									</ul>
								</div><!--widget-popular-posts end-->
								<!-- 사이드 배너 광고
								<div class="widget widget-adver d-none d-lg-block">
									<img src="assets/image/board-banner.png" alt="" class="w-100">
								</div>
								-->
								<!--widget-adver end-->
							</div><!--sidebar end-->
						</div>
					</div>
				</div><!--blog-main-content end-->
			</div>
		</section>
	</div><!--wrapper end-->
	<footer>
		<div class="bottom-bar">
			<div class="row">
				<div class="col col-4 col-lg-3 p-0">
					<a href="tel:1644-1328" class="first">
						<div class="info-item">
							<div class="info-icon">
								<img src="assets/image/info_icon_01.png">
							</div>
							<div class="info-content">
								<p><b>24시 유선상담 <span class="d-none d-lg-inline">가능</span></b>
								<p>1644-1328</p>
							</div>
						</div>
					</a>
				</div>
				<div class="col col-4 col-lg-3 p-0">
					<a href="https://pf.kakao.com/_lxbSxnK" target='_blank'>
						<div class="info-item">
							<div class="info-icon">
								<img src="assets/image/info_icon_02.png">
							</div>
							<div class="info-content">
								<p><b><span class="d-block d-lg-none">지금바로</span>실시간 상담톡<span class="d-none d-lg-inline">하기</span></b></p>
								<p class="d-none d-lg-block">Click</p>
							</div>
						</div>
					</a>
				</div>
				<div class="col col-4 col-lg-3 p-0">
					<a href="tel:010-9998-9282">
						<div class="info-item">
							<div class="info-icon">
								<img src="assets/image/info_icon_03.png">
							</div>
							<div class="info-content">
								<p><b><span class="d-none d-lg-inline">즉시</span> 신규 가맹문의</b>
								<p>010-9998-9282</p>
							</div>
						</div>
					</a>
				</div>
				<div class="col col-4 d-none col-lg-3 d-lg-block p-0">
					<a href="http://naver.me/GOCfFNMb" target="_blank">
						<div class="info-item">
							<div class="info-icon">
								<img src="assets/image/info_icon_04.png">
							</div>
							<div class="info-content">
								<p><b>펫클럽 가맹사업본부</b></p>
								<p>서울특별시 강남구 선릉로 619</p>
							</div>
						</div>
					</a>		
				</div>
			</div>
		</div>
		<div class="bottom-footer">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-lg-6 col-md-6">
						<div class="cp-mile">
							<img src="assets/image/petclub_logo.png" alt="">
							<p>© 2022. All Rights Reserved</p>
						</div><!--cp-mile end-->
					</div>
					<div class="col-lg-6 col-md-6">
						<ul class="social-links">
							<li><a href="https://www.facebook.com/petclub.official/"  target='_blank' title="펫클럽 페이스북"><i class="fab fa-facebook-square"></i></a></li>
							<li><a href="https://www.instagram.com/petclub_official/"  target='_blank' title="펫클럽 인스타"><i class="fab fa-instagram"></i></a></li>
						</ul><!--social-links end-->
					</div>
				</div>
			</div>
		</div>
	</footer>

<script src="assets/js/jquery.js"></script>
<script src="assets/js/gsap.min.js"></script>
<script src="assets/js/ScrollMagic.js"></script>
<script src="assets/js/animation.gsap.js"></script>
<script src="assets/js/html5lightbox.js"></script>
<script src="assets/js/animsition.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/classie.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>
<script src="assets/js/jquery.counterup.min.js"></script>
<script src="assets/js/counter.js"></script>
<script src="assets/js/datecounter.js"></script>
<script src="assets/js/isotope.js"></script>
<script src="assets/js/jquery.pagepiling.min.js"></script>
<script src="assets/js/slick.min.js"></script>
<script src="assets/js/tweenMax.js"></script>
<script src="assets/js/wow.min.js"></script>
<script src="assets/js/scripts.js"></script>
<script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
<script>
	function setKeywordType(gubun) {
		$("form[name=frm]").find("input[name=keywordType]").val(gubun);
		goPage(1);
    }
	function goPage(no) {
		$("#page").val(no);
        $("#frm").submit();
	}
	$(document).on("ready", function() {
        goEdge();
        // init controller
        var controller = new ScrollMagic.Controller();

        // build scenes
        new ScrollMagic.Scene({triggerElement: '.promo-primary-container', triggerHook: 0, duration: '25%'})
              // .setClassToggle('.brand', 'white')
              // .addIndicators()
              .addTo(controller);

        new ScrollMagic.Scene({triggerElement: '.promo-primary-container', triggerHook: 0, duration: '48%'})
              .setTween('.promo-primary-bg', {left: '-68%', backgroundPosition: '620px 0', ease: Linear.easeNone})
              // .addIndicators()
              .addTo(controller);

        new ScrollMagic.Scene({triggerElement: '.promo-primary-container', triggerHook: 0, duration: '50%'})
              .setTween('.promo-primary-content', {left: 0, ease: Linear.easeNone})
              // .addIndicators()
              .addTo(controller);

        new ScrollMagic.Scene({triggerElement: '.promo-primary-container', triggerHook: 0, duration: '50%'})
              .setTween('.promo-primary .square', {left: '75%', ease: Linear.easeNone})
              // .addIndicators()
              .addTo(controller);

        new ScrollMagic.Scene({triggerElement: '.step-position', triggerHook: 0, duration: '130%'})
              .setTween('.promo-primary .square', {top: '85%', ease: Linear.easeNone})
              // .addIndicators()
              .addTo(controller);

        new ScrollMagic.Scene({triggerElement: '.step-position', triggerHook: 0, duration: '100%'})
              .setTween('.promo-primary', {position: 'absolute', ease: Linear.easeNone})
              // .addIndicators()
              .addTo(controller);
      });
      function goEdge() {
        if(navigator.userAgent.indexOf("Trident/")  > -1 
        ||navigator.userAgent.indexOf("MSIE") !== -1 ) {
            window.location = 'microsoft-edge:' + window.location;
            setTimeout(function() {
                window.location.href = "noIe.php";
            }, 1);
        }
      };
</script>

</body>

</html>