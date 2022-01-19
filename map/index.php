<?php
	$t = microtime();
    $conn = mysqli_connect('localhost', 'mysql', 'petclub1!!', 'petclubs');
    $keyword = $_POST['keyword'];
    $small_keyword = $_POST['small_keyword'];
    $open_yn = $_POST['open_yn'];
    $sido = $_POST['sido'];

    $sql = "
        select * 
        from gps_info_view
        where sido like '%$sido%' 
        and customname like '%$small_keyword%' 
        and customname like '%$keyword%'
        and open_yn like '%$open_yn%'        
        and display_yn = '노출'
        order by customname asc
    ";
            
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($result)) {
        $data[] =  array("IDX" => $row["IDX"], "CUSTOMNAME" => $row["CUSTOMNAME"], "ADDRESS" => $row["ADDRESS"]
        , "LATI" => $row["LATI"], "LNG" => $row["LNG"], "PARK" => $row["PARK"], "PHONE"=> $row["PHONE"]
        , "TIME_START" => $row["TIME_START"], "TIME_END" => $row["TIME_END"], "FILE_NAME" => $row["FILE_NAME"]
        , "ADDRESS_DET" => $row["ADDRESS_DET"]);
    }
?> 
<!DOCTYPE>
<html>
<head>
<meta http-equiv="Content-Script-Type" content="text/javascript"/>
<meta http-equiv="content-style-type" content="text/css"/>
<meta http-equiv="expires" content="-1"/>
<meta http-equiv="pragma" content="no-cache"/>
<meta http-equiv="cache-control" content="no-cache"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<meta name="_csrf" content="cbee9a06-5a2a-42e1-a699-31a87ff608bf" data-url="/">
<meta name="_csrf_header" content="X-CSRF-TOKEN">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"/>
<title>펫클럽 지도 </title>
<link rel="stylesheet" type="text/css" href="plugins/bootstrap/3.3.7/css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="css/map.css?t=<?= $t ?>"/>
<link rel="stylesheet" type="text/css" href="css/correction.css?t=<?= $t ?>"/>
<link rel="stylesheet" type="text/css" href="css/course.css?t=<?= $t ?>"/>
<link rel="stylesheet" type="text/css" href="css/style.css?t=<?= $t ?>"/>
<link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
<link rel="stylesheet" type="text/css" href="/assets/fonts/static/pretendard.css">
<link rel="stylesheet" type="text/css" href="/assets/css/main.min.css?t=<?= $t ?>">
<link rel="stylesheet" type="text/css" href="/assets/css/custome.css?t=<?= $t ?>">
<script type="text/javascript" src="plugins/jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="plugins/jquery/jquery-ui.min.js"></script>
<script type="text/javascript" src="plugins/jquery/jquery.form-4.2.2.min.js"></script>
<script type="text/javascript" src="plugins/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/common.js?t=<?= $t ?>"></script>
<script type="text/javascript" src="js/init.js?t=<?= $t ?>"></script>
<script type="text/javascript" src="js/modal.js?t=<?= $t ?>"></script>
<script type="text/javascript" src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=apv7xiryg1&submodules=panorama,geocoder,drawing,visualization"></script>
<script type="text/javascript" src="plugins/naver/MarkerOverlappingRecognizer.js?t=<?= $t ?>"></script>
<script type="text/javascript" src="plugins/bootstrap/typeahead/4.0.2/bootstrap3-typeahead.min.js?t=<?= $t ?>"></script>
<script type="text/javascript" src="plugins/naver/mapUtils.js?t=<?= $t ?>"></script>
<script type="text/javascript" src="js/course/index.js?t=<?= $t ?>"></script>
<style type="text/css">
.swiper-slide {
    text-align: center;
    font-size: 18px;

    width: 15%;
    /* Center slide text vertically */
    display: -webkit-box;
    display: -ms-flexbox;
    display: -webkit-flex;
    display: flex;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    -webkit-justify-content: center;
    justify-content: center;
    -webkit-box-align: center;
    -ms-flex-align: center;
    -webkit-align-items: center;
    align-items: center;
}
    
.swiper-button-next:after, .swiper-button-prev:after {
    font-family: swiper-icons;
    font-size: 25px ;
    text-transform: none!important;
    letter-spacing: 0;
    text-transform: none;
    font-variant: initial;
    line-height: 1;
}      
      
    
input::placeholder {
  color: #ddd;
}

.header_map {
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    width: 100% !important;
    z-index: 9999999 !important;
    background: #fff !important;
    box-shadow: 0 0 10px rgba(0, 0, 0, .1) !important;
    padding: 10px 0 !important; 
}


</style>
<Script type="text/javascript">
    jQuery(function($) {
        //기본 설정
        goEdge();
        
        wObj.$frm = $("form[name=frm]");

        wFn.init();
        //맵 선언
        wFn.initMap();
        //맵 이벤트 설정
        wFn.initMapEvent();
        var result = jQuery.parseJSON('<?php echo json_encode($data) ?>');
            
        var frist_yn = false;
        for (var i = 0; i < result.length; i++) {
            
            var json = {
                "no" : i + 1
                , "customName" : result[i]["CUSTOMNAME"]
                , "lati" : result[i]["LATI"]
                , "lng" : result[i]["LNG"]
                , "src" : "images/store/" + result[i]["FILE_NAME"]
                , "park" : result[i]["PARK"]
                , "address" : result[i]["ADDRESS"] + " " + result[i]["ADDRESS_DET"]
                , "phone" : result[i]["PHONE"]
                , "time_start" : result[i]["TIME_START"]
                , "time_end" : result[i]["TIME_END"]
            };

            if (json.customName == "펫클럽 선정릉점") {
                frist_yn = true;
            }
            if (wComm.isEmpty( result[i]["ADDRESS_DET"])) {
                json.address =  result[i]["ADDRESS"];
            }

            json.tag = "<a class=\"btn btn-primary\" style=\"width:100%; background-color:#f18851; border-color:#f18851;\" onClick=\"javascript:wFn.contentPopOpen('data_pop_01','"+ json.customName +"','"+ json.time_start+"','"+ json.address +"','"+ json.phone +"','"+ json.park +"','"+ json.src +"','"+ json.time_end+"')\";>가맹점 보기</a>"
            wFn.setVisitMarker(json);
        };

        if (frist_yn) {
            wFn.setMapCenter(wObj.$map, wFn.setPos("37.51204427330895", "127.04289332663572"));
        }

        var json = {
            currentPage : "<?= $page ?>"
            , totalPage : "<?= $totalPage ?>"
        }; 
        fcSetPage("pageNavi", json);
        fcSetPage("small_pageNavi", json);
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
    
    function goPage(page) {
        $("#page").val(page);
        $("#frm").submit();
    };

    function fcSetPage(pageNavi, pageVo) {
        var pageArea =document.getElementById(pageNavi);
        $(pageArea).empty();

        if(pageVo==null)
            return;
        var currPage = pageVo.currentPage;
        var totPage = pageVo.totalPage;
        
        if(totPage>0){
            var strHtml;
            var startPage, endPage, size=4;
            startPage = currPage - (currPage % size) + 1;
            if(currPage%size == 0)
                startPage -= size;
            endPage = startPage + size - 1;
            if(endPage > totPage)
                endPage = totPage;

            strHtml = '';
            strHtml += "<ol>";
            if(startPage>1){
                strHtml += "<li><a href=\"javascript:goPage(1);\" class=\"btn_page_first\"><img src=\"/admin/images/util/btn_page_first.png\" alt=\"처음\"></a></li>";
                strHtml += "<li><a href=\"javascript:goPage("+(startPage-1)+");\" class=\"btn_page_prev\"><img src=\"/admin/images/util/btn_page_prev.png\" alt=\"이전\"></a></li>";
            }
            for(var i=startPage;i<=endPage;i++){
                if(i==currPage)
                    strHtml += "	<li><span href=\"javascript:void(0);\" class=\"current\">"+i+"</span></li>";
                
                else
                    strHtml += "	<li><a href=\"javascript:goPage("+i+");\">"+i+"</a></li>";
            }
            if(endPage<totPage){
                strHtml += "<li><a href=\"javascript:goPage("+(endPage+1)+");\" class=\"btn_page_next\"><img src=\"/admin/images/util/btn_page_next.png\" alt=\"다음\"></a></li>";
                strHtml += "<li><a href=\"javascript:goPage("+totPage+");\" class=\"btn_page_end\"><img src=\"/admin/images/util/btn_page_end.png\" alt=\"끝\"></a></li>";
            }
            strHtml += "</ol>";
            $(pageArea).append(strHtml);
        }
    };
    
    wFn.setStoreType = function(gubun) {
        if (gubun == "ALL") {
            wObj.$frm.find("input[name=open_yn]").val("");
        } else {
            wObj.$frm.find("input[name=open_yn]").val("신규매장");
        }

        goPage(1);
    };
    
    wFn.setSido = function(sido) {
        wObj.$frm.find("input[name=sido]").val(sido);
        goPage(1);
    };
</script>
</head>
<body>
<header class="header-v8 header_map" stlye="position: sticky !important;">
    <div class="header-menu">
        <div class="container">
            <div class="header-content-v8">
                <div class="logo-v8">
                    <a href="/" title="펫클럽 메인">
                        <img src="/assets/image/petclub_logo.png" alt="펫클럽">
                    </a>
                </div><!--logo-v8 end-->
                <nav>
                    <ul>
                        <li><a class="" href="/about.php" title="펫클럽 소개">펫클럽 소개</a>
                        </li>
                        <li><a href="/brand.php" title="브랜드">브랜드</a>
                            <ul>
                                <li><a href="/brand.php#dayspaw" title="데이스포">데이스포</a></li>
                                <li><a href="/brand.php#bellbird" title="">벨버드</a></li>
                            </ul>
                        </li>
                        <li><a class="active" href="/map/index.php" title="매장소개">매장소개</a>
                        </li>
                        <li><a href="/franchise-01.php" title="가맹정보">가맹정보</a>
                            <ul>
                                <li><a href="/franchise-01.php" title="가맹소개">가맹소개</a></li>
                                <li><a href="/franchise-02.php" title="수익구조">수익구조</a></li>
                                <li><a href="/franchise-03.php" title="비용 및 절차">비용 및 절차</a></li>
                                <li><a href="/franchise-04.php" title="매출 및 인터뷰">매출 및 인터뷰</a></li>
                            </ul>
                        </li>
                        <li><a href="/board.php" title="뉴스&이벤트">뉴스&이벤트</a>
                            <ul>
                                <li><a href="/board.php?keywordType=NEW" title="펫클럽 뉴스">펫클럽 뉴스</a></li>
                                <li><a href="/board.php?keywordType=EVENT" title="펫클럽 이벤트">펫클럽 이벤트</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav><!--nav end-->
                <button class="nav-toggle-btn a-nav-toggle ml-auto">
                    <span class="nav-toggle nav-toggle-sm">
                        <span class="stick stick-1"></span>
                        <span class="stick stick-2"></span>
                        <span class="stick stick-3"></span>
                    </span>
                </button>
            </div><!--header-content-v8 end-->
        </div>
    </div><!--header-menu end-->
</header><!--header end-->
<div class="responsive-menu">
    <div class="rep-header">
        <div class="rep-logo">
            <img src="/assets/image/petclub_logo.png" alt="">
        </div>
        <a href="#" title="" class="close-menu"><i class="lni lni-close"></i></a>
    </div>
    <ul class="mobile-menu">
        <li>
            <a class="active" href="/" title="홈">홈</a>
        </li>
        <li><a href="/about.php" title="펫클럽소개">펫클럽소개</a>
        </li>
        <li><a href="/brand.php" title="브랜드">브랜드</a>
            <ul>
                <li><a href="/brand.php#dayspaw" class="animsition-link" data-animsition-out-class="fade-out" title="" data-text="Porfolio Parallax">데이스포</a></li>
                <li><a href="/brand.php#bellbird" class="animsition-link" data-animsition-out-class="fade-out" title="" data-text="Porfolio Horizontal Scroll">벨버드</a></li>
            </ul>
        </li>
        <li><a href="/map/index.php" title="매장소개">매장소개</a>
        </li>
        <li><a href="/franchise-01.php" title="">가맹정보</a>
            <ul>
                <li><a href="/franchise-01.php" class="animsition-link" data-animsition-out-class="fade-out" title="" data-text="가맹소개">가맹소개</a></li>
                <li><a href="/franchise-02.php" class="animsition-link" data-animsition-out-class="fade-out" title="" data-text="수익구조">수익구조</a></li>
                <li><a href="/franchise-03.php" class="animsition-link" data-animsition-out-class="fade-out" title="" data-text="비용 및 절차">비용 및 절차</a></li>
                <li><a href="/franchise-04.php" class="animsition-link" data-animsition-out-class="fade-out" title="" data-text="매출 및 인터뷰">매출 및 인터뷰</a></li>
            </ul>
        </li>
        <li><a href="/board.php" title="뉴스&이벤트">뉴스&이벤트</a>
            <ul>
                <li><a href="/board.php?keywordType=NEW" class="animsition-link" data-animsition-out-class="fade-out" title="" data-text="펫클럽 뉴스">펫클럽 뉴스</a></li>
                <li><a href="/board.php?keywordType=EVENT" class="animsition-link" data-animsition-out-class="fade-out" title="" data-text="펫클럽 이벤트">펫클럽 이벤트</a></li>
            </ul>
        </li>
    </ul>
</div><!--responsive-menu end-->
<form id="frm" name="frm" action="index.php" method="post">  
<input type="hidden" id="page" name="page" value="<?= $page ?>"/>
<input type="hidden" name="open_yn" value="<?= $open_yn ?>"/>
<input type="hidden" name="sido" value="<?= $sido ?>"/>
<div>
    <div class="hidden-xs left_side_tag"  style="background-color:  #f18851; color:white; padding: 0; position: fixed; z-index:100; width:480px; height:100%; top:62px;">
        <div class="box box-success margin-top-10">
            <div class="box-header with-border t_center" style="border-bottom: 1px solid white; height: 12%;">
                <h3 class="t_center" style="font-size:28px; margin-top:20px;">매장 검색</h3>
                <input name="keyword"  class="t_center margin-bottom-20 keyword" style="margin-top:3%;" 
                    placeholder="매장명 또는 지역을 검색해주세요!"  onkeypress="if(event.keyCode==13) javascript:goPage(1);" value="<?= $keyword ?>" />
            </div>
            <div class="box-body" style="border-bottom: 1px solid white; height: 6%;">
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">&nbsp;</div>
                        <div class="swiper-slide"><a href="#" onClick="wFn.setSido('');"<?php if ($sido == null) {?> style="font-weight:600; color: #ffeb3b;" <?php } ?>>전체</a></div>
                        <div class="swiper-slide"><a href="#" onClick="wFn.setSido('서울');"<?php if ($sido == "서울") {?> style="font-weight:600; color: #ffeb3b;" <?php } ?>>서울</a></div>
                        <div class="swiper-slide"><a href="#" onClick="wFn.setSido('경기');"<?php if ($sido == "경기") {?> style="font-weight:600; color: #ffeb3b;" <?php } ?>>경기</a></div>
                        <div class="swiper-slide"><a href="#" onClick="wFn.setSido('인천');"<?php if ($sido == "인천") {?> style="font-weight:600; color: #ffeb3b;" <?php } ?>>인천</a></div>
                        <div class="swiper-slide">&nbsp;</div>
                        <div class="swiper-slide"><a href="#" onClick="wFn.setSido('강원');"<?php if ($sido == "강원") {?> style="font-weight:600; color: #ffeb3b;" <?php } ?>>강원</a></div>
                        <div class="swiper-slide"><a href="#" onClick="wFn.setSido('경상');"<?php if ($sido == "경상") {?> style="font-weight:600; color: #ffeb3b;" <?php } ?>>경상</a></div>
                        <div class="swiper-slide"><a href="#" onClick="wFn.setSido('전라');"<?php if ($sido == "전라") {?> style="font-weight:600; color: #ffeb3b;" <?php } ?>>전라</a></div>
                        <div class="swiper-slide"><a href="#" onClick="wFn.setSido('충청');"<?php if ($sido == "충청") {?> style="font-weight:600; color: #ffeb3b;" <?php } ?>>충청</a></div>
                        <div class="swiper-slide">&nbsp;</div>
                    </div>
                    <div class="swiper-button-next" style="color:white"></div>
                    <div class="swiper-button-prev" style="color:white"></div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="tab-content" id="tab-content">
                <div class="t_center" style="height: 8%;">
                <h2 class="button-title margin-right-20" style="margin-top:3%; <?php if ($open_yn == null) { ?>color: #f18851; background-color: white;<?php } ?> " onClick="wFn.setStoreType('ALL')">모든매장</h2>
                <h2 class="button-title margin-left-20" style="margin-top:3%; <?php if ($open_yn != null) { ?>color: #f18851; background-color: white;<?php } ?>" onClick="wFn.setStoreType('MAYBE')">신규매장</h2>
                </div>
                <div style="background-color: #fef2d8; overflow-y: auto; height:72%" id="search-list">
                    <?php
                        $sql = "
                            select * 
                            from gps_info_view
                            where sido like '%$sido%' 
                            and customname like '%$small_keyword%' 
                            and customname like '%$keyword%'
                            and open_yn like '%$open_yn%'
                            and display_yn = '노출'
                            order by customname asc
                        ";
                        $result = mysqli_query($conn, $sql);
                        $no = 0;
                        while($row = mysqli_fetch_array($result)) {
                    ?> 
                    <div class="header media no_<?= $no + 1 ?>" data-no="<?= $no + 1 ?>">
                        <div class="col-xs-4 col-sm-4" style="padding:unset !important;">
                            <img src="images/store/<?= $row["FILE_NAME"] ?>" style="width:125px; height:125px;"/>
                        </div>
                        <div class="col-xs-8 col-sm-8" style="padding:15px 5px 7px;">
                            <span style="color: black; font-size: 19px; font-weight: 600;"><?= $row["CUSTOMNAME"] ?></span> 
                            <br/>
                            <span class="orange" style="font-size:13px; margin-top:3px;">
                                    <?php
                                    if ($row["TIME_END"] == null) {
                                    ?>
                                        운영시간: <?= $row["TIME_START"] ?>
                                    <?php
                                    } else {  
                                    ?>
                                        주중 : <?= $row["TIME_START"] ?> <br/>
                                        주말 : <?= $row["TIME_END"] ?>
                                    <?php
                                    }
                                ?>
                            </span>
                            <br/>
                            <p class="gray"  style="font-size:15px; padding-top:10px; line-height:20px;">
                            <?= $row["ADDRESS"] ?> <?= $row["ADDRESS_DET"] ?><br/>
                            <?= $row["PHONE"] ?>
                            </p>
                        </div>
                    </div>
                    <?php
                        $no = $no + 1;
                        }
                        if ($no == 0) {
                    ?>
                        <h4 style="color:black; margin-top:50%; margin-bottom:50%; text-align:center;">
                            검색결과가 없습니다.
                        </h4>
                    <?php
                        }
                    ?>
                    <div style="width:125px; height:125px;">&nbsp;</div>
                </div>
                <div class="paging_wrap">
                    <div class="paging" id="pageNavi"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-left-none padding-right-none">
        <input name="small_keyword"  class="t_center margin-bottom-20 keyword hidden-sm hidden-md hidden-lg" 
        placeholder="매장명 또는 지역을 검색해주세요!" style="top:70px; left:5px; position:absolute; z-index:12; width: 60%;"
        onkeypress="if(event.keyCode==13) javascript:goPage(1);" value="<?= $small_keyword ?>"/>
        <div id="map"></div>
    </div>
    <div class="col-xs-12 hidden-sm hidden-md hidden-lg left_side_tag"  style="background-color:  #f18851; color:white; padding: 0; position:; top:462px;">
        <div class="box box-success margin-top-10">
            <div class="clearfix"></div>
            <div class="tab-content" id="tab-content">
            <div class="box-body" style="border-bottom: 1px solid white; height: 5.5%; margin-top:-10px;">
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">&nbsp;</div>
                        <div class="swiper-slide"><a href="#" onClick="wFn.setSido('');"<?php if ($sido == null) {?> style="font-weight:600; color: #ffeb3b;" <?php } ?>>전체</a></div>
                        <div class="swiper-slide"><a href="#" onClick="wFn.setSido('서울');"<?php if ($sido == "서울") {?> style="font-weight:600; color: #ffeb3b;" <?php } ?>>서울</a></div>
                        <div class="swiper-slide"><a href="#" onClick="wFn.setSido('경기');"<?php if ($sido == "경기") {?> style="font-weight:600; color: #ffeb3b;" <?php } ?>>경기</a></div>
                        <div class="swiper-slide"><a href="#" onClick="wFn.setSido('인천');"<?php if ($sido == "인천") {?> style="font-weight:600; color: #ffeb3b;" <?php } ?>>인천</a></div>
                        <div class="swiper-slide">&nbsp;</div>
                        <div class="swiper-slide"><a href="#" onClick="wFn.setSido('강원');"<?php if ($sido == "강원") {?> style="font-weight:600; color: #ffeb3b;" <?php } ?>>강원</a></div>
                        <div class="swiper-slide"><a href="#" onClick="wFn.setSido('경상');"<?php if ($sido == "경상") {?> style="font-weight:600; color: #ffeb3b;" <?php } ?>>경상</a></div>
                        <div class="swiper-slide"><a href="#" onClick="wFn.setSido('전라');"<?php if ($sido == "전라") {?> style="font-weight:600; color: #ffeb3b;" <?php } ?>>전라</a></div>
                        <div class="swiper-slide"><a href="#" onClick="wFn.setSido('충청');"<?php if ($sido == "충청") {?> style="font-weight:600; color: #ffeb3b;" <?php } ?>>충청</a></div>
                        <div class="swiper-slide">&nbsp;</div>
                    </div>
                    <div class="swiper-button-next" style="color:white"></div>
                    <div class="swiper-button-prev" style="color:white"></div>
                </div>
                </div>
                <div style="background-color: #fef2d8; overflow-y: auto;" id="search-list">
                    <?php
                        $sql = "
                            select * 
                            from gps_info_view
                            where sido like '%$sido%' 
                            and customname like '%$small_keyword%' 
                            and customname like '%$keyword%'
                            and open_yn like '%$open_yn%'
                            and display_yn = '노출'
                            order by customname asc
                        ";
                        $result = mysqli_query($conn, $sql);
                        $no = 0;
                        while($row = mysqli_fetch_array($result)) {
                    ?> 
                    <div class="header media no_<?= $no + 1 ?>" data-no="<?= $no + 1 ?>" >
                        <div class="col-xs-4" style="padding-left:0px;">
                            <img src="images/store/<?= $row["FILE_NAME"] ?>"  style="width:125px; height:125px;"/>
                        </div>
                        <div class="col-xs-8" style="padding-top:5px;">
                            <span style="color: black; font-size: 22px; font-weight: 600;"><?= $row["CUSTOMNAME"] ?></span> 
                            <br/>
                            <span class="orange">
                                <?php
                                if ($row["TIME_END"] == null) {
                                    echo ("운영시간: ". $row["TIME_START"]);
                                } else {  
                                ?>
                                    주중 : <?= $row["TIME_START"] ?> <br/>
                                    주말 : <?= $row["TIME_END"] ?>
                                <?php
                                }
                                ?>
                            </span>
                            <br/><br/>
                            <span class="gray">
                            <?= $row["ADDRESS"] ?> <?= $row["ADDRESS_DET"] ?><br/>
                            <?= $row["PHONE"] ?>
                            </span>
                        </div>
                    </div>
                    <?php
                            $no = $no + 1;
                        }

                        if ($no == 0) {
                    ?>
                        <h4 style="color:black; margin-top:50%; margin-bottom:50%;  text-align:center;">검색결과가 없습니다. </h4>
                    <?php
                        }
                     ?>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<!-- //wrap -->
<section class="pop_wrap data_pop_01" style="display: none;">
    <div>
        <div>
            <div class="pop_data middle" style="padding: 0px;">	
                <div style="background-color: #fef2d8; padding-top:15px; padding-bottom: 15px; padding-left: 35px;">
                    <span style="font-size: 24px; color:black;"><b class="header_title">펫클럽 명일점</b>&nbsp;&nbsp;&nbsp;</span><span style="font-size: 14px;color:black;"><span class="time">09:00 ~ 22:00</span></span>
                    <a href="javascript:;" onclick="wFn.contentPopClose(this);" class="btn_pop_close" style="background-color: #fef2d8;"></a>
                </div>
                <div class="list_data hidden-xs">
                    <div class="img_div" style="width:35%; float:left; background-color:white;">
                        <img src="images/store/거창점.jpg" class="pop_img"/>
                    </div>
                    <div style="width:65%; float:left; background-color:white; height: 250;">
                        <table class="list" style="margin-top:20px;">
                            <colgroup>
                                <col style="width:auto;">
                            </colgroup>
                            <tbody id="sortableTarget" class="ui-sortable" >
                                <tr>
                                    <td style="height:20px;"><b>ㆍ주소</b></td>
                                </tr>
                                <tr>                                    
                                    <td class="address title" style="height: 22.5px;">서울특별시 강동구 구천면로 428</td>
                                </tr>
                                <tr>
                                    <td style="height:10px;">&nbsp;</td>    
                                </tr>
                                <tr>
                                    <td style="height: 20px;"><b>ㆍ전화번호</b></td>
                                </tr>
                                <tr>
                                    <td class="phone title" style="height: 22.5px;">02-3428-4036</td>
                                </tr>
                                <tr>
                                    <td style="height:10px;">&nbsp;</td>    
                                </tr>
                                <tr>
                                    <td style="height: 20px;"><b>ㆍ영업시간</b></td>
                                </tr>
                                <tr>
                                    <td class="time title" style="height: 22.5px;">10:00~21:00</td>
                                </tr>
                                <tr>
                                    <td style="height:10px;">&nbsp;</td>    
                                </tr>
                                <tr>
                                    <td class="park" style="height: 22.5px;"><b>ㆍ주차가능여부 : 가능</b></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="list_data col-xs-12 hidden-sm hidden-md hidden-lg" style="background-color: white;">
                    <div class="img_div" style="background-color:white;height: 150px;text-align:center;"> 
                        <img src="images/store/거창점.jpg" class="pop_img" />
                    </div>
                    <div style="height: 150px;">
                        <table class="list">
                            <colgroup>
                                <col style="width:auto;">
                            </colgroup>
                            <tbody id="sortableTarget" class="ui-sortable" >
                                <tr> 
                                    <td style="height:22.5px;"><b>ㆍ주소 : </b><span class="address">울특별시 강동구 구천면로 428</span></td>
                                </tr>
                                <tr>
                                    <td style="height:10px;">&nbsp;</td>    
                                </tr>
                                <tr>
                                    <td style="height: 22.5px;"><b>ㆍ전화번호 : </b><span classs="phone">02-3428-403</span></td>
                                </tr>
                                <tr>
                                    <td style="height:10px;">&nbsp;</td>    
                                </tr>
                                <tr>
                                    <td style="height: 22.5px;"><b>ㆍ영업시간 : </b><span class="time title">10:00~21:00</span></td>
                                </tr>
                                <tr>
                                    <td style="height:10px;">&nbsp;</td>    
                                </tr>
                                <tr>
                                    <td colspan="2" class="park" style="height: 22.5px;"><b>ㆍ주차가능여부 : 가능</b></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="/assets/js/jquery.js"></script>
<script src="/assets/js/gsap.min.js"></script>
<script src="/assets/js/ScrollMagic.js"></script>
<script src="/assets/js/animation.gsap.js"></script>
<script src="/assets/js/html5lightbox.js"></script>
<script src="/assets/js/animsition.min.js"></script>
<script src="/assets/js/bootstrap.min.js"></script>
<script src="/assets/js/classie.js"></script>
<script src="/assets/js/counter.js"></script>
<script src="/assets/js/datecounter.js"></script>
<script src="/assets/js/isotope.js"></script>
<script src="/assets/js/jquery.pagepiling.min.js"></script>
<script src="/assets/js/tweenMax.js"></script>
<script src="/assets/js/wow.min.js"></script>
<script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
<script src="/assets/js/scripts.js"></script>
<script>
    let swiper = new Swiper(".mySwiper", {
        slidesPerView: 6,
        slidesPerGroup: 6,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        }
    });

	$(document).on("ready", function() {
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
</script>
</body>
</html>