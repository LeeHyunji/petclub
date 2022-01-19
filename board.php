<?php include 'top.php'; ?>
<?php 
    $conn = mysqli_connect('localhost', 'mysql', 'petclub1!!', 'petclubs');
    $keywordType = $_POST['keywordType'];
    if ($keywordType == null) {
        $keywordType = $_GET['keywordType'];
    }
    $keyword = $_POST['keyword'];
    
    $sql = "select count(*) as cnt from board_list_view 
        where en_board_name like '%$keywordType%' 
        and title like '%$keyword%'
        and display ='Y'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
 
    $page = $_POST['page'];
    
    if ($page == null) {
        $page = 1;
    }
    $pageSize = 4 ;
    $totalPage = ceil($row['cnt']/$pageSize) ;

    $start = $pageSize * ($page -1);

?>
<style type="text/css">
    .mile_pagination .pagination li a{ 
     border-radius: 50% !important;
    }
</style>
	<div class="wrapper">
		<section class="board-banner sub-banner">
			<div class="container">
				<h2 class="font_S">펫클럽 소식</h2>
				<p class="font_G">펫클럽의 뉴스와 이벤트 소식을 
					알려드립니다.</p>
			</div>
		</section>
		<section class="sec-board-list sec-board sec-main">
			<div class="container">
				<div class="blog-main-content">
					<div class="row">
						<div class="col-lg-9">
							<div class="blog-posts-layout2">
                            <?php  
                                $sql = "
                                    select a.en_board_name
                                        , a.list_idx
                                        , a.title
                                        , substr(a.summary, 1, 50) as summary
                                        , concat(concat(concat(concat(concat(substr(a.ins_date, 1, 4), \"년 \"), substr(a.ins_date, 5, 2)), '월 '), substr(a.ins_date, 7, 2) ), '일') as ins_date 
                                    from(
                                    select * 
                                    from board_list_view
                                    where en_board_name like '%$keywordType%' 
                                    and title like '%$keyword%'
                                    and display = 'Y'
                                    order by b.list_idx desc) a
                                    limit $start, $pageSize
                                ";
                                $result = mysqli_query($conn, $sql);
                                $no = 0;
                                while($row = mysqli_fetch_array($result)) {
                                    $list_idx = $row['list_idx'];

                            ?>
                            <div class="bg-post">
                                <div class="bg-post-thumb">
                                    <?php
                                     $query = "
                                        select file_name 
                                        from board_file
                                        where list_idx = '$list_idx'
                                        order by idx desc
                                        
                                    ";
                                    $file_result = mysqli_query($conn, $query);
                                    $file_row = mysqli_fetch_array($file_result);
                                    $file_name = $file_row['file_name'];
                                    ?>
                                    <img src="/upfile/board/<?= $file_name ?>" alt="">
                                </div>
                                <div class="bg-post-info">
                                    <ul class="meta">
                                        <li><a class="category" href="#">
                                            <?php 
                                            if ($row['en_board_name'] == "NEW") {
                                                echo "뉴스";
                                            } else {
                                                echo "이벤트";
                                            }
                                            ?>
                                        </a>
                                        </li>
                                        <li><?= $row['ins_date'] ?></li>
                                    </ul>
                                    <h2><a href="post.php?idx=<?= $row['list_idx'] ?>"><?= $row['title'] ?></a></h2>
                                    <p>
                                        <?php
                                        if($row['summary'].strlen > 50) {
                                            echo ($row['summary'] . "...");
                                        } else {
                                            echo ($row['summary']);
                                        }
                                        ?>
                                    </p>
                                </div>
                            </div><!--bg-post end-->
                            <?php
                                $no = $no + 1;
                                }
                            ?>
							</div><!-- blog-posts-layout2 end-->
							<div id="mile_pagination" class="mile_pagination"></div><!--mile_pagination end-->
						</div>
						<div class="col-lg-3">
							<div class="sidebar blog-sidebar">
								<div class="widget widget-search">
                                    <form id="frm" name="frm" action="board.php" method="post">
                                        <input type="hidden" name="keywordType" value="<?= $keywordType ?>" />
                                        <input type="hidden" id="page" name="page" value="<?= $page ?>" />
										<input type="text" name="keyword" placeholder="검색어를 입력하세요." value="<?=$keyword ?>">
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
										<li <?php if ($keywordType == null) { ?> class="active" <?php } ?>>
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
								
								<!-- 사이드 광고 배너
								<div class="widget widget-adver d-none d-lg-block">
									<img src="assets/image/board-banner.png" alt="" class="w-100">
								</div>
								-->
								
								
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
<script src="assets/js/counter.js"></script>
<script src="assets/js/datecounter.js"></script>
<script src="assets/js/isotope.js"></script>
<script src="assets/js/jquery.pagepiling.min.js"></script>
<script src="assets/js/slick.min.js"></script>
<script src="assets/js/tweenMax.js"></script>
<script src="assets/js/wow.min.js"></script>
<script src="assets/js/scripts.js"></script>
<script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
<script type="text/javascript">
    jQuery(function($) {
        var json = {
            currentPage : "<?= $page ?>"
            , totalPage : "<?= $totalPage ?>"
        }; 
        fcSetPage("mile_pagination", json);
    });

    function goPage(page) {
        $("#page").val(page);
        $("#frm").submit();
    };

	function setKeywordType(gubun) {
		$("input[name=keywordType]").val(gubun);
		goPage(1);
    }
    //==============================================================
    //* 페이지 처리
    //@param trPage - page처리 할 tr ID
    //@param currPage - 현재 page
    //@param totPage - 총 페이지 수
    //==============================================================
    function fcSetPage(pageNavi, pageVo) {
        var pageArea =document.getElementById(pageNavi);
        $(pageArea).empty();

        if(pageVo == null) return;
        var currPage = pageVo.currentPage;
        var totPage = pageVo.totalPage;
        
        if(totPage > 0) { 
            var strHtml;
            var startPage, endPage, size=10;
            startPage = currPage - (currPage % size) + 1;
            if(currPage % size == 0)
                startPage -= size;
            endPage = startPage + size - 1;
            if(endPage > totPage)
                endPage = totPage;
            strHtml = "<nav><ul class=\"pagination text-left\">";
            if(startPage > 1) {
                strHtml += "<li class=\"page-item prev disabled\">";
                strHtml += "    <a href=\"javascript:goPage("+(startPage-1)+");\" class=\"page-link\" tabindex=\"-1\">Prev</a>";
                strHtml += "</li>";
            }
            for(var i = startPage; i <= endPage; i++){
                if(i == currPage) {
                    strHtml += "	<li class=\"page-item active\"><a href=\"#\" class=\"page-link\">"+i+"<span class=\"sr-only\">(current)</span></a></li>";
                } else {
                    strHtml += "	<li class=\"page-item\"><a class=\"page-link\" href=\"javascript:goPage("+i+");\">"+i+"</a></li>";
                }
            }
            if(endPage < totPage){
                strHtml += "<li class=\"page-item next\">";
                strHtml += "    <a href=\"javascript:goPage("+(endPage+1)+");\" class=\"page-link\">Next</a>";
                strHtml += "</li>";
            }
            strHtml += "</ul></nav>";

            $(pageArea).append(strHtml);
        }
    };

</script>
<script>
	$(document).on("ready", function() {
        // init controller
        goEdge();
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