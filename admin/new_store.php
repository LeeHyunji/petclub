<?php include 'top.php'; ?>
<?php
    $idx = $_GET['idx'];
    $sql = "select * from gps_info_view where idx = '$idx'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    if($row != null) {
        $lati = $row['LATI'];
        $lng = $row['LNG'];
        $customname = $row['CUSTOMNAME'];
        $address = $row['ADDRESS'];
        $park = $row['PARK'];
        $phone = $row['PHONE'];
        $time_start = $row['TIME_START'];
        $time_end = $row['TIME_END'];
        $address_det = $row['ADDRESS_DET'];
        $file_idx = $row['FILE_IDX'];
        $file_name = $row['FILE_NAME'];
        $open_yn = $row['OPEN_YN'];
        $display_yn = $row['DISPLAY_YN'];
    }
?>
<script type="text/javascript" src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=apv7xiryg1&submodules=panorama,geocoder,drawing,visualization"></script>
<script type="text/javascript" src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script>
jQuery(function($) {
    wObj.$frm = $("form[name=frm]");       
});

// 다음 주소 검색
wFn.setAddress = function($this) {
    var $this = $($this).parent();
    new daum.Postcode({
        oncomplete: function(data) {
            $this.find("input[name=address]").val(data.roadAddress);
            wFn.searchAddressToCoordinate();
        }
    }).open();
};

// 위경도 값 구하기
wFn.searchAddressToCoordinate = function() {
    var $lati = wObj.$frm.find("input[name=lati]")
        , $lng = wObj.$frm.find("input[name=lng]");

    naver.maps.Service.geocode({
        query: wObj.$frm.find("input[name=address]").val()
        , count: 10
        }, function(status, response) {
        if (status === naver.maps.Service.Status.ERROR) {
            if (!address) {
                alert('주소를 다시 한번 확인해주세요.');
                return;
            }
            alert('주소를 다시 한번 확인해주세요, address:' + address);
            return;
        }

        if (response.v2.meta.totalCount === 0) {
            alert('주소가 존재하지 않습니다.');
            return;
        }

        var item = response.v2.addresses[0];

        $lng.val(item.x);
        $lati.val(item.y);
    });
};

wFn.setStore = function() {
    if (wComm.isEmpty(wObj.$frm.find("input[name=address]").val() ) ) {
        alert("주소를 입력해주세요.");
        return;
    } 
    if (wComm.isEmpty(wObj.$frm.find("input[name=img_file]").val()) && wComm.isEmpty(wObj.$frm.find("input[name=idx]").val())  ) {
        alert("파일을 넣어주세요.");
        return;
    } 
    if (wComm.isEmpty(wObj.$frm.find("input[name=customname]").val() ) ) {
        alert("매장명을 입력해주세요.");
        return;
    } 
    if (wComm.isEmpty(wObj.$frm.find("input[name=phone]").val() ) ) {
        alert("전화 번호를 입력해주세요.");
        return;
    } 

    if(!confirm("저장하시겠습니까?")) {
        return;
    }
    wObj.$frm.find("input[name=mode]").val("SAVE");
	wFn.doSave();
};
// 저장
wFn.doSave = function() { 	 
    var options = {
        url: "new_storeProc.php"
        , type: "post"
        , dataType: "json"
        , complete: function(response, stateText, xhr, $form) {
            var json = response.responseText, msg = "";
            try {
                json = wComm.parseJs(json)
                msg = unescape(json.msg);
                if(json.login && !json.status) {
                    msg = wComm.nvl(wComm.fmtDBError(msg), msg);
                    alert(msg);
                    return;
                }
                alert(msg);          
                if (wObj.$frm.find("input[name=mode]").val() == "DELFILE")  {
                    wFn.goRefresh();
                } else {
                    location.href = "store_list.php";    
                }
            } catch(ex) {
                alert("error");
                wComm.log(json, ex.message);
            }
        }
    };
    wObj.$frm.ajaxSubmit(options);
};

// 삭제하기.
wFn.setDel = function() {
    if(!confirm("삭제하시겠습니까?")) {
        return;
    }
    wObj.$frm.find("input[name=mode]").val("DEL");
	wFn.doSave();
};

// 다운로드
wFn.download = function() {
    var frm = document.frm;
    frm.method = "post";
    frm.action = "download.php"
    frm.submit();
};

// 파일 삭제
wFn.setDelFile = function() {
    wObj.$frm.find("input[name=mode]").val("DELFILE");
    wFn.doSave();
};

// 리플레시
wFn.goRefresh = function() {
    var frm = document.frm;
    frm.method = "post";
    frm.action = "new_store.php";
    frm.sumbit();
};

</script>
<form id="frm" name="frm" action="#" onsubmit="return false;" method="post" encType="multipart/form-data">
<input type="hidden" name="mode" />
<input type="hidden" name="lati" value="<?= $lati ?>"/>
<input type="hidden" name="lng" value="<?= $lng ?>"/>
<input type="hidden" name="idx" value="<?= $idx ?>" />
<section id="contents">
    <h2>매장소개</h2>
    <ul class="history">
        <li>매장소개</li>
        <li>매장 신규등록</li>
    </ul>
    <div class="write_list">
        <h3 class="il_mid_title"><b>매장 등록</b></h3>
        <fieldset>
            <legend>매장 등록</legend>
            <table class="write">
                <caption></caption>
                <colgroup>
                    <col style="width:200px">
                    <col style="width:auto">
                </colgroup>
                <tbody>
                    <tr>
                    <th class="vertical_m" style="padding: 40px 20px;">
                        <span style="font-size: 18px; font-weight: 700;">
                            매장사진
                        </span>									
                    </th>
                    <td>
                        <input type="hidden" name="file_idx" value="<?= $file_idx ?>"/>
                        <ul class="file_parent">
                            <li class="add_input" style="padding:0; margin-bottom:10px;">
                                <div class="file_cell">
                                    <input type="file" name="img_file" title="파일 업로드" onchange="fileChange(this);">
                                    <input type="text" name="img_fileTxt" readonly="" value="" title="업로드된 파일 경로">
                                    <button class="btn_small type_03 btn_file"><span>파일찾기</span></button>
                                </div>
                                <span class="file_add_info">20MB까지 가능</span>
                            </li>
                        </ul>
                        <div id="fileList" class="file_add_list" style="padding:0">
                        <?php if ($file_idx != null) {
                        ?>
                            <div class="list_item">
                                <p class="item">
                                    <a href="#" id="fileDown<?= $file_idx ?>" class="txt" onClick="wFn.download();">
                                        <?= $file_name ?>
                                    </a>
                                    <button type="button" class="btn_small type_02 btn_del"  onClick="wFn.setDelFile();"><span>삭제</span></button>
                                </p>
                            </div>
                        <?php
                            }    
                        ?>
                        </div>
                    </td>
                </tr>								
                    <tr>
                        <th class="vertical_m" style="padding: 20px 20px;">
                            <span style="font-size: 18px; font-weight: 700;">
                                지역
                            </span>									
                        </th>
                        <td>
                            <select name="sido" style="width: 180px;">
                                <option vlaue="서울" <?php if($sido == "서울") {?>selected="selected"<?php } ?>>서울</option>
                                <option vlaue="경기" <?php if($sido == "경기") {?>selected="selected"<?php } ?>>경기</option>
                                <option vlaue="인천" <?php if($sido == "인천") {?>selected="selected"<?php } ?>>인천</option>
                                <option vlaue="강원" <?php if($sido == "강원") {?>selected="selected"<?php } ?>>강원</option>
                                <option vlaue="경상" <?php if($sido == "경상") {?>selected="selected"<?php } ?>>경상</option>
                                <option vlaue="전라" <?php if($sido == "전라") {?>selected="selected"<?php } ?>>전라</option>
                                <option vlaue="충정" <?php if($sido == "충청") {?>selected="selected"<?php } ?>>충청</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th class="vertical_m" style="padding: 20px 20px;">
                            <span style="font-size: 18px; font-weight: 700;">
                                가맹점 이름
                            </span>									
                        </th>
                        <td>
                            <input type="text" name="customname" style="width: 100%;" value="<?= $customname ?>">
                        </td>
                    </tr>
                    <tr>
                        <th class="vertical_m" style="padding: 20px 20px;">
                            <span style="font-size: 18px; font-weight: 700;">
                                주중운영시간
                            </span>									
                        </th>
                        <td>
                            <input type="text" name="time_start" style="width:100%;" value="<?= $time_start ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <th class="vertical_m" style="padding: 20px 20px;">
                            <span style="font-size: 18px; font-weight: 700;">
                                주말운영시간
                            </span>									
                        </th>
                        <td>
                            <input type="text" name="time_end" style="width:100%;" value="<?= $time_end ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <th class="vertical_m" style="padding: 40px 20px;">
                            <span style="font-size: 18px; font-weight: 700;">
                                매장주소
                            </span>									
                        </th>
                        <td>
                            <input type="text" name="address" readonly="readonly" onClick="javasript:wFn.setAddress(this);" value="<?= $address ?>" >
                        </td>
                    </tr>
                    <tr>
                        <th class="vertical_m" style="padding: 40px 20px;">
                            <span style="font-size: 18px; font-weight: 700;">
                                매장상세주소
                            </span>									
                        </th>
                        <td>
                            <input type="text" name="address_det" value="<?= $address_det ?>" >
                        </td>
                    </tr>
                    <tr>
                        <th class="vertical_m" style="padding: 20px 20px;">
                            <span style="font-size: 18px; font-weight: 700;">
                                전화번호
                            </span>									
                        </th>
                        <td>
                            <input type="text" name="phone" style="width: 100%;" placeholder="전화번호를 입력해주세요." value="<?= $phone ?>">
                        </td>
                    </tr>								
                    <tr>
                        <th class="vertical_m" style="padding: 20px 20px;">
                            <span style="font-size: 18px; font-weight: 700;">
                                주차가능여부
                            </span>									
                        </th>
                        <td>
                            <select name="park" style="width: 180px;">
                                <option value="가능" <?php if($park == "가능") {?>selected="selected"<?php } ?> >가능</option>
                                <option value="불가능" <?php if($park == "불가능") {?>selected="selected"<?php } ?> >불가능</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th class="vertical_m" style="padding: 20px 20px;">
                            <span style="font-size: 18px; font-weight: 700;">
                                노출여부
                            </span>									
                        </th>
                        <td>
                            <select name="display_yn" style="width: 180px;">
                                <option value="노출" <?php if($display_yn == "노출") {?>selected="selected"<?php } ?> >노출</option>
                                <option value="미노출" <?php if($display_yn == "미노출") {?>selected="selected"<?php } ?> >미노출</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th class="vertical_m" style="padding: 20px 20px;">
                            <span style="font-size: 18px; font-weight: 700;">
                                오픈여부
                            </span>									
                        </th>
                        <td>
                            <select name="open_yn" style="width: 180px;">
                                <option value="오픈" <?php if($open_yn == "오픈") {?>selected="selected"<?php } ?> >오픈</option>
                                <option value="오픈예정" <?php if($open_yn == "오픈예정") {?>selected="selected"<?php } ?> >오픈예정</option>
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>
        </fieldset>

        <div class="btn_page text_c">
            <a href="store_list.php" class="btn_big type_02">이전화면</a>
            <?php if ($idx != null) { ?>
            <a href="#" class="btn_big type_05" onClick="wFn.setDel();">삭제하기</a>
            <?php } ?>
            <a href="#" class="btn_big type_01" onClick="wFn.setStore();">등록하기</a>
        </div>
    </div>
</section>
</form>
<!-- <?php include 'bottom.php'; ?> -->