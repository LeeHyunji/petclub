
<?php include 'top.php'; ?>
<?php 
    $conn = mysqli_connect('localhost', 'mysql', 'petclub1!!', 'petclubs');
?>
<div class="wrapper">
	<section class="main-banner">
		<!-- Swiper -->
		<div class="swiper main-banner-swiper">
			<div class="append-buttons">
			</div>
			<div class="swiper-wrapper">
				<!-- Slides -->
				<?php
					$sql = "select * from user_content where gubun = 'A' and idx = 9";
					$result = mysqli_query($conn, $sql);
					$row = mysqli_fetch_array($result);

					if ($row != null) {
						$content = $row['CONTENT'];
						$content_1 = $row['CONTENT_1'];
						$content_2 = $row['CONTENT_2'];
						$content_3 = $row['CONTENT_3'];
                        $content_4 = $row['CONTENT_4'];
                        $content_5 = $row['CONTENT_5'];
					}
				?>
				<div class="swiper-slide swiper-slide1">
					<h2>부담없는 소자본 창업!<br>
						트랜디한 상품군,<br>
                        직영점 운영 업계 1위 노하우로<br>
                        어떤 위기에도 흔들리지 않는 매출!!
<!--                        <span>1위</span>-->
					</h2>
					<h3>
						<?= $content_4 ?><br>
						<span><b class="font_GB clr1 count" data-count="<?= number_format($content) ?>"><?= number_format($content) ?></b>원</span>
					</h3>
				</div>
				<div class="swiper-slide swiper-slide2" style="background-image:url(/assets/image/slide_02.jpg);">
					<h2>믿을 수 있는 프랜차이즈!<br>
						COVID 이슈로도 타격없는<br>
						꾸준하고 안정적인 수익률
					</h2>
					<h3>
                        <?= $content_5 ?><br>
						<span><b class="font_GB clr1 count" data-count="<?= $content_1 ?>"><?= $content_1 ?></b>%</span>
					</h3>
				</div>
				<div class="swiper-slide swiper-slide3" style="background-image:url(/assets/image/slide_03.jpg);">
					<h2>어디서든 잘나가는 CEO!<br>
						지방과 수도권의 매출 차이가<br>
						거의 없는 펫클럽
					</h2>
					<h3>
						전국 방방곡곡 매장수<br>
						<span><b class="font_GB clr1 count" data-count="<?= number_format($content_2) ?>"><?= number_format($content_2) ?></b>개 매장</span>
					</h3>
				</div>
				<div class="swiper-slide swiper-slide4" style="background-image:url(/assets/image/slide_04.jpg);">
					<h2>반려동물들이 좋아하는 브랜드!<br>
						제품이 너무 좋으니까.<br>
						다시올수밖에 없는 펫클럽 
					</h2>
					<h3>
						재방문율 높은 오프라인 회원<br>
						<span><b class="font_GB clr1 count" data-count="<?= number_format($content_3) ?>"><?= number_format($content_3) ?></b>명</span>
					</h3>
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
	</section>
	<div class="sec-main-info sec-main d-lg-none">
		<div class="container">
			<div class="row">
				<div class="col col-3">
					<a href="tel:1644-1328">
						<div class="info-item">
							<div class="info-icon">
								<img src="assets/image/info_icon_01.png">
							</div>
							<p><b>24시 유선상담</b>
							1644-1328</p>
						</div>
					</a>
				</div>
				<div class="col col-3">
					<a href="https://pf.kakao.com/_lxbSxnK" target='_blank'>	
						<div class="info-item">
							<div class="info-icon">
								<img src="assets/image/info_icon_02.png">
							</div>
							<p><b>실시간상담톡</b>
							Click</p>
						</div>
					</a>
				</div>
				<div class="col col-3">
					<a href="tel:010-9998-9282">
						<div class="info-item">
							<div class="info-icon">
								<img src="assets/image/info_icon_03.png">
							</div>
							<p><b>즉시 신규 가맹문의</b>
							010-9998-9282</p>
						</div>
					</a>
				</div>
				<div class="col col-3">
					<a href="#">
						<div class="info-item">
							<div class="info-icon">
								<img src="assets/image/info_icon_04.png">
							</div>
							<p><b>가맹사업본부</b>
							강남구 선릉로 619</p>
						</div>
					</a>
				</div>
			</div>
		</div>
	</div>
	<section class="sec-main-feature sec-main">
		<div class="container">
			<div class="sec-header">
				<h2>펫클럽을 선택하면
					<b><strong>성공</strong>하는 이유</b>
				</h2>
			</div>
			<div class="sec-content">
				<div class="row">
					<div class="col-12 col-md-6">
						<div class="card-feature">
							<img src="assets/image/icon-01.png" class="card-img-top" alt="초보자도 쉬운 판매 노하우">
							<div class="card-body">
								<h5 class="card-title">초보자도 쉬운 판매 노하우</h5>
								<p><strong>25년</strong> 직영매장 <strong>성공 노하우</strong>를 바탕으로
								반려동물 전문가의 필승 전략</p>
							</div>
						</div>
					</div>
					<div class="col-12 col-md-6">
						<div class="card-feature">
							<img src="assets/image/icon-02.png" class="card-img-top" alt="간편한 포스 시스템">
							<div class="card-body">
								<h5 class="card-title">간편한 포스 시스템</h5>
								<p>간편하고 실시간 매출 확인 및 매출 분석과 회원관리, 
									<strong>통합서버를 통한 전국망 관리</strong></p>
							</div>
						</div>
					</div>
					<div class="col-12 col-md-6">
						<div class="card-feature">
							<img src="assets/image/icon-03.png" class="card-img-top" alt="편리한 발주 시스템">
							<div class="card-body">
								<h5 class="card-title">편리한 발주 시스템</h5>
								<p>발주의 번거로움 없이 <strong>원클릭</strong>으로 <strong>자동입고</strong>되는 
									자동발주 시스템 및 안정적인 상품입고</p>
							</div>
						</div>
					</div>
					<div class="col-12 col-md-6">
						<div class="card-feature">
							<img src="assets/image/icon-04.png" class="card-img-top" alt="3천여가지 인기상품">
							<div class="card-body">
								<h5 class="card-title">3천여가지 인기상품</h5>
								<p>다양한 카테고리별 국내외 최신 트렌드 
									<strong>인기 상품의 신속한 입고</strong></p>
							</div>
						</div>
					</div>
					<div class="col-12 col-md-6">
						<div class="card-feature">
							<img src="assets/image/icon-05.png" class="card-img-top" alt="넘볼수 없는 각격 경쟁력">
							<div class="card-body">
								<h5 class="card-title">넘볼수 없는 각격 경쟁력</h5>
								<p>다양한 인기상품의 공장 직거래를 통한 타사대비 
									탁월한 가격 경쟁력</p>
							</div>
						</div>
					</div>
					<div class="col-12 col-md-6">
						<div class="card-feature">
							<img src="assets/image/icon-06.png" class="card-img-top" alt="누구나 손쉬운 소자본 창업">
							<div class="card-body">
								<h5 class="card-title">누구나 손쉬운 소자본 창업</h5>
								<p>퇴직자, 청년창업, 직장인 투잡으로 가능한 
									10평형 기준 <strong>투자비 3천만원대</strong></p>
							</div>
						</div>
					</div>
					<div class="col-12 col-md-6">
						<div class="card-feature">
							<img src="assets/image/icon-07.png" class="card-img-top" alt="인건비 걱정 NO!">
							<div class="card-body">
								<h5 class="card-title">인건비 걱정 NO!</h5>
								<p>365일 24시간 운영가능한 <strong>유/무인 결합</strong> 
									하이브리드 스토어</p>
							</div>
						</div>
					</div>
					<div class="col-12 col-md-6">
						<div class="card-feature">
							<img src="assets/image/icon-08.png" class="card-img-top" alt="업계 최고 오프라인 30만 고객 공유">
							<div class="card-body">
								<h5 class="card-title">업계 최고 30만 고객 공유</h5>
								<p>업계 최대 규모의 <strong>오프라인 30만 회원 공유</strong>로
									포인트 통합 활용</p>
							</div>
						</div>
					</div>
					<div class="col-12 col-md-6">
						<div class="card-feature">
							<img src="assets/image/icon-09.png" class="card-img-top" alt="마켓팅 지원">
							<div class="card-body">
								<h5 class="card-title">마켓팅 및 홍보물 지원</h5>
								<p><strong>성공 마켓팅</strong> 교육 및 <strong>창업 컨설팅</strong> 제공, 
									매장 POP 및 전단지 등 다양한 홍보물 지원</p>
							</div>
						</div>
					</div>
					<div class="col-12 col-md-6">
						<div class="card-feature">
							<img src="assets/image/icon-10.png" class="card-img-top" alt="컨설팅 지원">
							<div class="card-body">
								<h5 class="card-title">컨설팅 지원</h5>
								<p>업종 전황 리모델링 <strong>컨설팅 무상 지원</strong> 및 
									배달 서비스 제휴 컨설팅</p>
							</div>
						</div>
					</div>
					<div class="col-12 col-md-6">
						<div class="card-feature">
							<img src="assets/image/icon-11.png" class="card-img-top" alt="본사의 긴급 지원체계">
							<div class="card-body">
								<h5 class="card-title">본사의 긴급 지원체계</h5>
								<p>점주 부재 시 <strong>본사 영업지원</strong> 
									(연 2회 지원)</p>
							</div>
						</div>
					</div>
					<div class="col-12 col-md-6">
						<div class="card-feature">
							<img src="assets/image/icon-12.png" class="card-img-top" alt="체게적인 관리 시스템">
							<div class="card-body">
								<h5 class="card-title">체적계인 관리 시스템</h5>
								<p>월 1회이상 본사 슈퍼바이저 순회를 통한 <strong>지속적인 
									영업관리</strong></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="sec-main-store sec-main">
		<div class="sec-header">
			<div class="sec-header">
				<h2>펫클럽 가맹점
					<b><strong>월매출 확인</strong></b>
				</h2>
			</div>
		</div>
		<div class="sec-content">
			<div class="container-fluid">
				<div class="swiper main-store-swiper">
					<div class="swiper-wrapper">
						<!-- Slides -->
						<?php
							$sql = "select * from user_content where gubun = 'S' ";
							$result = mysqli_query($conn, $sql);
							while($row = mysqli_fetch_array($result)) {
						?>
						<div class="swiper-slide">
							<img src="assets/image/crown.png" alt="매출 TOP">
							<h5><?= $row["CONTENT"] ?><b><br/><?= $row["CONTENT_2"] ?></b></h5>
							<h6 class="store-name"><?= $row["CONTENT_1"] ?></h6>
							<p>직전 월 평균 매출</p>
							<p class="store-price"><?= $row["CONTENT_3"] ?>원</p>
						</div>
						<?php
							}
						?> 
					</div>
					<!-- Add Pagination -->
					<div class="swiper-pagination">					
					</div>
				</div>
				<div class="more-button">
					<a href="franchise-04.php" class="btn-store-more">지방과 수도권의 매출 차이가
						거의 없는 펫클럽 <strong>매출 더보기</strong>
					</a>
				</div>
				</div>
		</div>
	</section>
	<section class="sec-main-review sec-main">
		<div class="sec-header">
			<h2>펫클럽 실제점주
				<b><strong>성공 창업 후기</strong></b>
			</h2>
		</div>
		<div class="sec-content">
			<div class="swiper main-review-swiper">
				<div class="swiper-wrapper">
					<!-- Slides -->
					<div class="swiper-slide card-review">
						<div class="card-head">
							<div class="card-head-title">
								<span class="store-name">[펫클럽 양재점]</span>
								<h5>반려동물을 키워본적 없던 주부도 성공적 창업</h5>
								<div class="review-star">
									<p>만족도</p>
									<div class="star-wrap">
										<span class="star"></span><span class="star"></span><span class="star"></span><span class="star"></span><span class="star"></span>
									</div>
								</div>
							</div>
							<div class="card-head-img">
								<img src="assets/image/user_01.png" alt="리뷰">
							</div>	
						</div>
						<div class="card-body">
							<h6>#주부창업 #초보창업 양재점 점주 사례</h6>
                            <p>"방과후 교사를 하던 중 반려동물용품 창업에 도전해보고 싶었어요. 인터넷 검색을 통해 브랜드를 알아보던 중에 다른 프랜차이즈보다 체계화 되어있다고 느낀 브랜드가 ‘펫클럽’이었습니다."<br>
                            “3년째 매장을 안정적으로 운영해 나가고 있는데, 특별한 고민은 없었어요. 물론 그 과정에서 노력도 많이 했죠. 다행히 안정화된 시스템 덕에 혼자서도 매장을 잘 운영하고 있어요. 매장 오시는 고객분들이 항상 저를 기억해 주시더라구요. 고마운 고객들께 친절함은 당연하고, ‘여기 제품이 좋다. 친절하다.’ 소리를 듣도록 열심히 만들고 있습니다. 또 본사에서 주관하는 행사나, 프로모션도 적극적으로 참여하면서 고객들에게 더 많은 것들을 제공하려고 노력 중입니다. 더 많은 고객이 오면 좋겠습니다.” 안정적인 매장 운영을 이어가면서, 매출 상승에 대한 김현아 가맹점주의 창업자로서 욕심은 부단한 노력으로 이어졌고, 결국 본사의 든든한 뒷받침 덕분에 이런 노력들이 더욱 빛을 발하게 됐다.<br>
                            “매장이 잘 알려질 수 있게 홍보 및 마케팅 측면에서 많은 도움이 되고 있어요. 신제품이나 최신 트렌드에 맞는 행사 진행도 도와주고 계시고요. 아마 저 혼자서 노력하는 것만으로는 한계가 있었을텐데 이렇게 본사에서 적극적으로 홍보를 위해 발로 뛰어주시니 너무 감사해요”</p>
                            <div class="more-button">
								<a href="franchise-04.php?reviewid=1" class="btn-review-more">더보기</a>
							</div>
						</div>
					</div>
					<div class="swiper-slide card-review">
						<div class="card-head">
							<div class="card-head-title">
								<span class="store-name">[펫클럽 땡땡점]</span>
								<h5>24시간 무인매장운영, 선택과 집중으로 성공</h5>
								<div class="review-star">
									<p>만족도</p>
									<div class="star-wrap">
										<span class="star"></span><span class="star"></span><span class="star"></span><span class="star"></span><span class="star"></span>
									</div>
								</div>
							</div>
							<div class="card-head-img">
								<img src="assets/image/user_02.png" alt="리뷰">
							</div>	
						</div>
						<div class="card-body">
							<h6>#업종변경 #무인매장운영 땡땡점 점주 사례</h6>
                            <p>“5년 가까이 외식업을 하면서 건강에 적신호가 오기 시작했습니다. 비교적 몸이 편안한 창업 아이템을 찾던중에 우연히 집 근처 ‘펫클럽’이라는 브랜드를 접하게 됐어요. 인터넷 서칭도 해보고, 발품팔아 사전 조사를 통해 타 브랜드보다 이미지가 고급스럽고 규모도 크다는 느낌을 받아 관심을 갖게 되었습니다. 특히나 제가 꽂혔던 부분은 무인으로도 운영이 가능하다는 점이었어요."<br>
                            “매장이 잘 알려질 수 있게 홍보 및 마케팅 측면에서 많은 도움이 되고 있어요. 신제품이나 최신 트렌드에 맞는 행사 진행도 도와주고 계시고요. 아마 저 혼자서 노력하는 것만으로는 한계가 있었을텐데 이렇게 본사에서 적극적으로 홍보를 위해 발로 뛰어주시니 너무 감사해요”<br>
                            “매장이 잘 알려질 수 있게 홍보 및 마케팅 측면에서 많은 도움이 되고 있어요. 신제품이나 최신 트렌드에 맞는 행사 진행도 도와주고 계시고요. 아마 저 혼자서 노력하는 것만으로는 한계가 있었을텐데 이렇게 본사에서 적극적으로 홍보를 위해 발로 뛰어주시니 너무 감사해요”</p>
                            <div class="more-button">
								<a href="franchise-04.php?reviewid=2" class="btn-review-more">더보기</a>
							</div>
						</div>
					</div>
					<div class="swiper-slide card-review">
						<div class="card-head">
							<div class="card-head-title">
								<span class="store-name">[펫클럽 양재점]</span>
								<h5>강아지를 사랑하는 부부의 은퇴창업</h5>
								<div class="review-star">
									<p>만족도</p>
									<div class="star-wrap">
										<span class="star"></span><span class="star"></span><span class="star"></span><span class="star"></span><span class="star"></span>
									</div>
								</div>
							</div>
							<div class="card-head-img">
								<img src="assets/image/user_03.png" alt="리뷰">
							</div>	
						</div>
						<div class="card-body">
							<h6>#부부창업 #은퇴창업 냥냥점 점주 사례</h6>
                            <p>“매장이 잘 알려질 수 있게 홍보 및 마케팅 측면에서 많은 도움이 되고 있어요. 신제품이나 최신 트렌드에 맞는 행사 진행도 도와주고 계시고요. 아마 저 혼자서 노력하는 것만으로는 한계가 있었을텐데 이렇게 본사에서 적극적으로 홍보를 위해 발로 뛰어주시니 너무 감사해요”<br>
                            “매장이 잘 알려질 수 있게 홍보 및 마케팅 측면에서 많은 도움이 되고 있어요. 신제품이나 최신 트렌드에 맞는 행사 진행도 도와주고 계시고요. 아마 저 혼자서 노력하는 것만으로는 한계가 있었을텐데 이렇게 본사에서 적극적으로 홍보를 위해 발로 뛰어주시니 너무 감사해요”<br>
                            “매장이 잘 알려질 수 있게 홍보 및 마케팅 측면에서 많은 도움이 되고 있어요. 신제품이나 최신 트렌드에 맞는 행사 진행도 도와주고 계시고요. 아마 저 혼자서 노력하는 것만으로는 한계가 있었을텐데 이렇게 본사에서 적극적으로 홍보를 위해 발로 뛰어주시니 너무 감사해요”</p>
                            <div class="more-button">
								<a href="franchise-04.php?reviewid=3" class="btn-review-more">더보기</a>
							</div>
						</div>
					</div>
                    <div class="swiper-slide card-review">
                        <div class="card-head">
                            <div class="card-head-title">
                                <span class="store-name">[펫클럽 양재점]</span>
                                <h5>강아지를 사랑하는 부부의 은퇴창업</h5>
                                <div class="review-star">
                                    <p>만족도</p>
                                    <div class="star-wrap">
                                        <span class="star"></span><span class="star"></span><span class="star"></span><span class="star"></span><span class="star"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-head-img">
                                <img src="assets/image/user_03.png" alt="리뷰">
                            </div>
                        </div>
                        <div class="card-body">
                            <h6>#부부창업 #은퇴창업 냥냥점 점주 사례</h6>
                            <p>“매장이 잘 알려질 수 있게 홍보 및 마케팅 측면에서 많은 도움이 되고 있어요. 신제품이나 최신 트렌드에 맞는 행사 진행도 도와주고 계시고요. 아마 저 혼자서 노력하는 것만으로는 한계가 있었을텐데 이렇게 본사에서 적극적으로 홍보를 위해 발로 뛰어주시니 너무 감사해요”<br>
                                “매장이 잘 알려질 수 있게 홍보 및 마케팅 측면에서 많은 도움이 되고 있어요. 신제품이나 최신 트렌드에 맞는 행사 진행도 도와주고 계시고요. 아마 저 혼자서 노력하는 것만으로는 한계가 있었을텐데 이렇게 본사에서 적극적으로 홍보를 위해 발로 뛰어주시니 너무 감사해요”<br>
                                “매장이 잘 알려질 수 있게 홍보 및 마케팅 측면에서 많은 도움이 되고 있어요. 신제품이나 최신 트렌드에 맞는 행사 진행도 도와주고 계시고요. 아마 저 혼자서 노력하는 것만으로는 한계가 있었을텐데 이렇게 본사에서 적극적으로 홍보를 위해 발로 뛰어주시니 너무 감사해요”</p>
                            <div class="more-button">
                                <a href="franchise-04.php?reviewid=4" class="btn-review-more">더보기</a>
                            </div>
                        </div>
                    </div>
				</div>
				<!-- Add Pagination -->
				<div class="swiper-pagination">					
				</div>
			</div>
		</div>
	</section>
	<section class="sec-main-hotkeywords sec-main">
		<div class="container">
			<div class="sec-header">
				<h2>예비 점주가 궁금한
					<b><strong>핫 키워드 <span class="d-none d-lg-inline">바로가기</span></strong></b>
				</h2>
			</div>
			<div class="sec-content">
				<ul class="keywords-list">
					<li class="keywords-item"><a href="franchise-03.php">#창업 프로세스</a></li>
					<li class="keywords-item"><a class="active" href="franchise-04.php">#지역별 월매출</a></li>
					<li class="keywords-item"><a href="franchise-02.php">#창업 비용</a></li>
					<li class="keywords-item"><a href="franchise-04.php">#성공 사례</a></li>
				</ul>
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


	/* index.html :  main-banner swiper.js pagination - bullets타입 */
    let swiper = new Swiper('.main-banner-swiper', {
		slidesPerView: "auto",
        spaceBetween: 14,
		loop: true,
        pagination: {
          el: '.swiper-pagination',
		  clickable: true,
        },
		breakpoints: { //반응형 조건 속성
			991: {
				centeredSlides: true,
				spaceBetween: 100,
			},
		},on: {
            slideChange: function () {
                $(".main-banner .swiper-slide").each(function(index, item){
                    $(this).find(".count").text($(this).find(".count").attr("data-count"));
                });
                $('.count').counterUp({
                    delay: 10,
                    time:2000
                });


                if($(".main-banner .swiper-pagination-bullet:nth-child(3)").hasClass("swiper-pagination-bullet-active")){
                    $('.main-banner .append-buttons').scrollLeft(100);
                };
                if($(".main-banner .swiper-pagination-bullet:nth-child(2)").hasClass("swiper-pagination-bullet-active")){
                    $('.main-banner .append-buttons').scrollLeft(0);
                };
                if($(".main-banner .swiper-pagination-bullet:nth-child(1)").hasClass("swiper-pagination-bullet-active")){
                    $('.main-banner .append-buttons').scrollLeft(0);
                };
                if($(".main-banner .swiper-pagination-bullet:nth-child(4)").hasClass("swiper-pagination-bullet-active")){
                    $('.main-banner .append-buttons').scrollLeft(150);
                };
            }
        }
	});

	/* index.html : main-banner swiper.js pagination - custom타입 */
	const main_banner_buttons = ["직영점 운영 업계 1위","안정적인 수익율","전국 방방곡곡 매장","재방문율 높은 오프라인 회원"];
	let swiper_pagination = new Swiper('.main-banner-swiper', {
		slidesPerView: "auto",
        spaceBetween: 14,
		loop: true,
		autoplay: {
          delay: 10000,
          disableOnInteraction: false,
        },
        pagination: {
          el: '.append-buttons',
		  clickable: true,
		  renderBullet: function (index, className) {
          return '<span class="' + className + '">' + main_banner_buttons[index] + '</span>';
		  }
        },
		breakpoints: { //반응형 조건 속성
			991: {
				centeredSlides: true,
				spaceBetween: 100,
				navigation: {
					nextEl: '.swiper-button-next',
					prevEl: '.swiper-button-prev',
				},
			},
		}	
	});
	swiper.controller.control = swiper_pagination;
	swiper_pagination.controller.control = swiper;
     
	/* index.html : main-store swiper.js pagination - custom타입 */
	let store_swiper = new Swiper('.main-store-swiper', {
		slidesPerView: 2,
		centeredSlides: true,
        spaceBetween: 14,
		loop: true,
		autoplay: {
          delay: 5000,
          disableOnInteraction: false,
        },
        pagination: {
          el: '.swiper-pagination',
		  type: 'progressbar',
		  clickable: true,
        },
		breakpoints: { //반응형 조건 속성
			991: {
				slidesPerView: 3,
				spaceBetween: 0,
			},
		}	
	});
	/* index.html : main-regview swiper.js pagination - custom타입 */
	let review_swiper = new Swiper('.main-review-swiper', {
		slidesPerView: "auto",
        spaceBetween: 14,
		loop: true,
		autoplay: {
          delay: 5000,
          disableOnInteraction: false,
        },
        pagination: {
          el: '.swiper-pagination',
		  clickable: true,
        },
		breakpoints: { //반응형 조건 속성
			768:{
				slidesPerView: 2,
				centeredSlides: true,
				spaceBetween: 24,
			},
			991: {
				slidesPerView: 2,
				centeredSlides: true,
				spaceBetween: 28,
			},
			1200: {
				slidesPerView: 3,
				centeredSlides: true,
				spaceBetween: 32,
			},
		}	
	});
    $("document").ready(function(){
        function move_hotkeyword(){
            let curr_target = $(".keywords-item a.active");
            curr_target.removeClass("active");
            curr_target = curr_target.parent().next().find("a")
            if(curr_target.length > 0){
                curr_target.addClass("active");
            }else{
                $(".keywords-item:first-child a").addClass("active");
            }
        }
        setInterval(move_hotkeyword, 2500);

    });
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