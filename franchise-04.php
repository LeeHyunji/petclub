<?php include 'top.php'; ?>
<?php 
    $conn = mysqli_connect('localhost', 'mysql', 'petclub1!!', 'petclubs');
?>
<div class="wrapper">
    <section class="franchise-banner sub-banner">
        <div class="container">
            <h2 class="font_S">가맹정보</h2>
            <p class="font_G">펫클럽 가맹정보의 A부터 Z까지</p>
        </div>
    </section>
    <section class="sec-franchise-sales sec-main" id="sec-franchise">
        <div class="svs-03-styles fzt-tab">
            <div class="container">
                <div class="row fzt-row">
                    <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                        <a href="franchise-01.php#sec-franchise" title="가맹정보 가맹소개">
                            <div class="our-fzt">
                                <h3>가맹소개</h3>
                                <p>펫클럽을 선택해야 성공하는 이유들을 꼼꼼하게 살펴보세요.</p>
                            </div><!--our-fzt end-->
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                        <a href="franchise-02.php#sec-franchise" title="가맹정보 수익구조">
                            <div class="our-fzt">
                                <h3>수익률 규모</h3>
                                <p>펫클럽의 평형별 예상매출 및 수익률 규모를 확인하세요.</p>
                            </div><!--our-fzt end-->
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                        <a href="franchise-03.php#sec-franchise" title="가맹정보 비용 및 절차">
                            <div class="our-fzt">
                                <h3>가맹절차 및 비용</h3>
                                <p>가맹계약후 약 30일 이내의 창업기간이 소요됩니다.</p>
                            </div><!--our-fzt end-->
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                        <a class="active" href="franchise-04.php#sec-franchise" title="가맹정보 매출 및 인터뷰">
                            <div class="our-fzt">
                                <h3>매출 및 점주인터뷰</h3>
                                <p>현재 운영중인 가맹점들의 월매출 및 점주님들의 후기 인터뷰를 확인하세요</p>
                            </div><!--our-fzt end-->
                        </a>
                    </div>
                </div>
            </div>
        </div><!--svs-03-styles end-->
        <div class="fzt-tab-content">
            <div class="service_v1_content">
                <div class="sec-header-2 sv-title wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0ms">
                    <div class="container">
                        <span class="sub-title text-left">MONTHLY SALES</span>
                        <h2 class="text-left font_S">펫클럽 가맹점
                        실제 월매출 데이터</h2>
                    </div>
                </div><!--sv-title end-->
                <div class="sec-content">
                    <div class="franchise-cost">
                        <div class="sec-header-2 sv-title wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0ms">
                            <div class="container">
                                <h2>어려울 때 일수록, 브랜드가 빛납니다.
                                    25년 반려동물 사업을 진행 경험의 펫클럽
                                    <strong>코로나 이후 매출 향상 실제 데이터 공개!</strong></h2>
                            </div>
                        </div>
                        <div class="tab-data active">
                            <div class="container">
                                <div class="prices-v10">
                                    <div class="price-v10">
                                        <div class="table-wrap">
                                            <table class="main-table">
                                                <tbody>
                                                    <tr>
                                                    <th>지점</th>
                                                    <th>A(서울권)</th>
                                                    <th>B(강원권)</th>
                                                    <th>C(수도권)</th>
                                                    </tr>
                                                    <tr>
                                                    <td>월</td>
                                                    <td>매출액</td>
                                                    <td>매출액</td>
                                                    <td>매출액</td>
                                                    </tr>
                                                    <?php
                                                        $sql = "
                                                            select a.*
                                                            from(
                                                            select * 
                                                            from franchise_list
                                                            where delete_yn = 'N'
                                                            and display_yn = 'Y'
                                                            order by yymm desc) a
                                                            limit 0 , 20
                                                        ";
                                                        $result = mysqli_query($conn, $sql);
                                                        $no = 0;
                                                        while($row = mysqli_fetch_array($result)) {
                                                            $yymm = $row['yymm'];
                                                            $seoul_price = $row['seoul_price'];
                                                            $seoul_mark = $row['seoul_mark'];
                                                            $gangwon_price = $row['gangwon_price'];
                                                            $gangwon_mark = $row['gangwon_mark'];
                                                            $gyeonggi_price = $row['gyeonggi_price'];
                                                            $gyeonggi_mark = $row['gyeonggi_mark'];
                                                            $display_yn = $row['display_yn'];
                                                    ?>
                                                        <tr>
                                                        <td><?= $yymm ?></td>
                                                        <td <?php if ($seoul_mark == "Y") { ?>class="point"<?php } ?>><?= $seoul_price ?></td>
                                                        <td <?php if ($gangwon_mark == "Y") { ?>class="point"<?php } ?>><?= $gangwon_price ?></td>
                                                        <td <?php if ($gyeonggi_mark == "Y") { ?>class="point"<?php } ?>><?= $gyeonggi_price ?></td>
                                                        </tr>
                                                    <?php
                                                            $no = $no + 1;
                                                        }
                                                        if ($no == 0 ) {
                                                    ?>
                                                    <tr><td colspan="4">데이터가 존재하지 않습니다.</td></tr>
                                                    <?php
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="table-info">
                                            <p>※ 단위 : 원</p>
                                        </div>
                                        <a href="https://pf.kakao.com/_lxbSxnK" target='_blank' title="" class="btn-square w-100 no-bg btn-default v2">가맹문의 바로가기</a>
                                    </div><!--price-v10 end-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="franchise-review" id="review-detail">
                        <div class="sec-header-2 sv-title wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0ms">
                            <div class="container">

                            <span class="sub-title">INTERVIEW</span>
                            <h2 class="font_S">실제 점주 인터뷰</h2>
                            </div>
                        </div>
                        <div class="section">
                            <div class="container">
                                <div class="sec-content">
                                    <div class="swiper main-review-swiper">
                                        <div class="swiper-wrapper">
                                            <!-- Slides -->
                                            <div class="swiper-slide card-review">
                                                <div class="row">
                                                    <div class="col-12 col-md-4 card-head">
                                                        <div class="card-head-img">
                                                            <img src="assets/image/user_01.png" alt="리뷰">
                                                        </div>	
                                                        <div class="card-head-title">
                                                            <p class="store-name d-block">펫클럽 양재점</p>
                                                            <p class="person-name d-block">김땡땡 점주님</p>
                                                            <div class="review-star">
                                                                <p>만족도</p>
                                                                <span class="star"></span><span class="star"></span><span class="star"></span><span class="star"></span><span class="star"></span>
                                                            </div>
                                                        </div>	
                                                    </div>
                                                    <div class="col-12 col-md-8 card-body">
                                                        <h5>반려동물을 키워본적 없던 주부도 성공적 창업</h5>
                                                        <h6>#주부창업 #초보창업 양재점 점주 사례</h6>
                                                        <p><b>"방과후 교사를 하던 중 반려동물용품 창업에 도전해보고 싶었어요. 인터넷 검색을 통해 브랜드를 알아보던 중에 다른 프랜차이즈보다 체계화 되어있다고 느낀 브랜드가 ‘펫클럽’이었습니다."</b></p>
                                                        <p>“3년째 매장을 안정적으로 운영해 나가고 있는데, 특별한 고민은 없었어요. 물론 그 과정에서 노력도 많이 했죠. 다행히 안정화된 시스템 덕에 혼자서도 매장을 잘 운영하고 있어요. 매장 오시는 고객분들이 항상 저를 기억해 주시더라구요. 고마운 고객들께 친절함은 당연하고, ‘여기 제품이 좋다. 친절하다.’ 소리를 듣도록 열심히 만들고 있습니다. 또 본사에서 주관하는 행사나, 프로모션도 적극적으로 참여하면서 고객들에게 더 많은 것들을 제공하려고 노력 중입니다. 더 많은 고객이 오면 좋겠습니다.” 안정적인 매장 운영을 이어가면서, 매출 상승에 대한 김현아 가맹점주의 창업자로서 욕심은 부단한 노력으로 이어졌고, 결국 본사의 든든한 뒷받침 덕분에 이런 노력들이 더욱 빛을 발하게 됐다.</p>
                                                        <p>“매장이 잘 알려질 수 있게 홍보 및 마케팅 측면에서 많은 도움이 되고 있어요. 신제품이나 최신 트렌드에 맞는 행사 진행도 도와주고 계시고요. 아마 저 혼자서 노력하는 것만으로는 한계가 있었을텐데 이렇게 본사에서 적극적으로 홍보를 위해 발로 뛰어주시니 너무 감사해요”</p>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="swiper-slide card-review">
                                                <div class="row">
                                                    <div class="col-12 col-md-4 card-head">
                                                        <div class="card-head-img">
                                                            <img src="assets/image/user_01.png" alt="리뷰">
                                                        </div>	
                                                        <div class="card-head-title">
                                                            <span class="store-name d-block">펫클럽 땡떙점</span>
                                                            <span class="person-name d-block">한땡땡 점주님</span>
                                                            <div class="review-star">
                                                                <p>만족도</p>
                                                                <span class="star"></span><span class="star"></span><span class="star"></span><span class="star"></span><span class="star"></span>
                                                            </div>
                                                        </div>	
                                                    </div>
                                                    <div class="col-12 col-md-8 card-body">
                                                        <h5>24시간 무인매장운영, 선택과 집중으로 성공</h5>
                                                        <h6>#업종변경 #무인매장운영 땡땡점 점주 사례</h6>
                                                        <p><b>“5년 가까이 외식업을 하면서 건강에 적신호가 오기 시작했습니다. 비교적 몸이 편안한 창업 아이템을 찾던중에 우연히 집 근처 ‘펫클럽’이라는 브랜드를 접하게 됐어요. 인터넷 서칭도 해보고,
                                                                발품팔아 사전 조사를 통해 타 브랜드보다 이미지가 고급스럽고 규모도 크다는 느낌을 받아 관심을 갖게 되었습니다. 특히나 제가 꽂혔던 부분은 무인으로도 운영이 가능하다는 점이었어요."</b></p>
                                                        <p>“매장이 잘 알려질 수 있게 홍보 및 마케팅 측면에서 많은 도움이 되고 있어요. 신제품이나 최신 트렌드에 맞는 행사 진행도 도와주고 계시고요. 아마 저 혼자서 노력하는 것만으로는 한계가 있었을텐데 이렇게 본사에서 적극적으로 홍보를 위해 발로 뛰어주시니 너무 감사해요”</p>
                                                        <p>“매장이 잘 알려질 수 있게 홍보 및 마케팅 측면에서 많은 도움이 되고 있어요. 신제품이나 최신 트렌드에 맞는 행사 진행도 도와주고 계시고요. 아마 저 혼자서 노력하는 것만으로는 한계가 있었을텐데 이렇게 본사에서 적극적으로 홍보를 위해 발로 뛰어주시니 너무 감사해요”</p>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="swiper-slide card-review">
                                                <div class="row">
                                                    <div class="col-12 col-md-4 card-head">
                                                        <div class="card-head-img">
                                                            <img src="assets/image/user_01.png" alt="리뷰">
                                                        </div>	
                                                        <div class="card-head-title">
                                                            <span class="store-name d-block">펫클럽 냥냥점</span>
                                                            <span class="person-name d-block">이냥냥 점주님</span>
                                                            <div class="review-star">
                                                                <p>만족도</p>
                                                                <span class="star"></span><span class="star"></span><span class="star"></span><span class="star"></span><span class="star"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-8 card-body">
                                                        <h5>강아지를 사랑하는 부부의 은퇴창업</h5>
                                                        <h6>#부부창업 #은퇴창업 냥냥점 점주 사례</h6>
                                                        <p style="font-weight:600;">“매장이 잘 알려질 수 있게 홍보 및 마케팅 측면에서 많은 도움이 되고 있어요. 신제품이나 최신 트렌드에 맞는 행사 진행도 도와주고 계시고요. 아마 저 혼자서 노력하는 것만으로는 한계가 있었을텐데 이렇게 본사에서 적극적으로 홍보를 위해 발로 뛰어주시니 너무 감사해요”</p>															
                                                        <p>“매장이 잘 알려질 수 있게 홍보 및 마케팅 측면에서 많은 도움이 되고 있어요. 신제품이나 최신 트렌드에 맞는 행사 진행도 도와주고 계시고요. 아마 저 혼자서 노력하는 것만으로는 한계가 있었을텐데 이렇게 본사에서 적극적으로 홍보를 위해 발로 뛰어주시니 너무 감사해요”</p>
                                                        <p>“매장이 잘 알려질 수 있게 홍보 및 마케팅 측면에서 많은 도움이 되고 있어요. 신제품이나 최신 트렌드에 맞는 행사 진행도 도와주고 계시고요. 아마 저 혼자서 노력하는 것만으로는 한계가 있었을텐데 이렇게 본사에서 적극적으로 홍보를 위해 발로 뛰어주시니 너무 감사해요”</p>
                                                
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="swiper-slide card-review">
                                                <div class="row">
                                                    <div class="col-12 col-md-4 card-head">
                                                        <div class="card-head-img">
                                                            <img src="assets/image/user_01.png" alt="리뷰">
                                                        </div>	
                                                        <div class="card-head-title">
                                                            <span class="store-name d-block">펫클럽 냥냥점</span>
                                                            <span class="person-name d-block">이냥냥 점주님</span>
                                                            <div class="review-star">
                                                                <p>만족도</p>
                                                                <span class="star"></span><span class="star"></span><span class="star"></span><span class="star"></span><span class="star"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-8 card-body">
                                                        <h5>강아지를 사랑하는 부부의 은퇴창업</h5>
                                                        <h6>#부부창업 #은퇴창업 냥냥점 점주 사례</h6>
                                                        <p style="font-weight:600;">“매장이 잘 알려질 수 있게 홍보 및 마케팅 측면에서 많은 도움이 되고 있어요. 신제품이나 최신 트렌드에 맞는 행사 진행도 도와주고 계시고요. 아마 저 혼자서 노력하는 것만으로는 한계가 있었을텐데 이렇게 본사에서 적극적으로 홍보를 위해 발로 뛰어주시니 너무 감사해요”</p>															
                                                        <p>“매장이 잘 알려질 수 있게 홍보 및 마케팅 측면에서 많은 도움이 되고 있어요. 신제품이나 최신 트렌드에 맞는 행사 진행도 도와주고 계시고요. 아마 저 혼자서 노력하는 것만으로는 한계가 있었을텐데 이렇게 본사에서 적극적으로 홍보를 위해 발로 뛰어주시니 너무 감사해요”</p>
                                                        <p>“매장이 잘 알려질 수 있게 홍보 및 마케팅 측면에서 많은 도움이 되고 있어요. 신제품이나 최신 트렌드에 맞는 행사 진행도 도와주고 계시고요. 아마 저 혼자서 노력하는 것만으로는 한계가 있었을텐데 이렇게 본사에서 적극적으로 홍보를 위해 발로 뛰어주시니 너무 감사해요”</p>
                                                
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Add Pagination -->
                                        <div class="swiper-pagination">					
                                        </div>
                                        <!-- Add Arrows -->
                                        <div class="swiper-button-nav">
                                            <div class="swiper-button-next"></div>
                                            <div class="swiper-button-prev"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
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
                        <li><a href="#" title=""><i class="fab fa-facebook-square"></i></a></li>
                        <li><a href="#" title=""><i class="fab fa-instagram"></i></a></li>
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
	let review_swiper = new Swiper('.franchise-review .main-review-swiper', {
		slidesPerView: "auto",
        spaceBetween: 50,
		loop: true,
		autoplay: {
          delay: 10000,
          disableOnInteraction: false,
        },
		navigation: {
			nextEl: '.swiper-button-next',
			prevEl: '.swiper-button-prev',
		},
        pagination: {
          el: '.swiper-pagination',
		  clickable: true,
        },
		breakpoints: { //반응형 조건 속성
			768:{
				slidesPerView: 1,
				centeredSlides: true,
			},
			991: {
				slidesPerView: 1,
				centeredSlides: true,
				spaceBetween: 80,
			},
		}	
	});

    $(document).on("ready",function(){
        let target;
        if(target = getParameterByName('reviewid')){
            slide_move(target);

            var offset = $("#review-detail").offset();
            $('html, body').animate({
                scrollTop: offset.top
            }, 0);
        }

    });
    // ie 호환성을위해 변경
    function getParameterByName(name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
            results = regex.exec(window.location.href);

        return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    }
    function slide_move(target) {
        review_swiper.slideTo(target, 0, false)
    }
</script>

<script>
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