
<?php include 'top.php'; ?>
<?php
    $idx = $_GET['idx'];
    $sql = "select * from franchise_list where idx = '$idx'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    
    $seoul_mark = "N";
    $gangwon_mark = "N";
    $gyeonggi_mark = "N";
    $display_yn = "Y";

    if($row != null) {
        $yymm = $row['yymm'];
        $seoul_price = $row['seoul_price'];
        $seoul_mark = $row['seoul_mark'];
        $gangwon_price = $row['gangwon_price'];
        $gangwon_mark = $row['gangwon_mark'];
        $gyeonggi_price = $row['gyeonggi_price'];
        $gyeonggi_mark = $row['gyeonggi_mark'];
        $display_yn = $row['display_yn'];
    }

    $sql = "select DATE_FORMAT(date_add(now(), interval -1 year), '%Y') as pre_year
        , DATE_FORMAT(now(), '%Y') as yy
        , DATE_FORMAT(date_add(now(), interval +1 year), '%Y') as after_yy
        , DATE_FORMAT(date_add(now(), interval -2 year), '%Y') as two_pre_year
        from dual";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    $yy = $row['yy'];
    $pre_year = $row['pre_year'];
    $after_yy = $row['after_yy'];
    $two_pre_year = $row['two_pre_year'];
?>
<script type="text/javascript">
    jQuery(function($) {
        wObj.$frm = $("form[name=frm]");                
    });

    // 저장 프로세스
    wFn.setSave = function(mode) {
        wObj.$frm.find("input[name=mode]").val(mode);
        var msg = mode == "SAVE" ? "저장하시겠습니까?" : "삭제하시겠습니까?";
        if (!confirm(msg)) {
            return;
        }
        if(wComm.isEmpty(wObj.$frm.find("input[name=seoul_price]").val())) {
            alert("A그룹(서울) 매출액을 입력해주세요.");
            return;
        }
        if(wComm.isEmpty(wObj.$frm.find("input[name=gyeonggi_price]").val())) {
            alert("B그룹(강원) 매출액을 입력해주세요.");
            return; 
        }
        if(wComm.isEmpty(wObj.$frm.find("input[name=gyeonggi_price]").val())) {
            alert("C그룹(경기) 매출액을 입력해주세요.");
            return;
        }
        
        wFn.doSave();
    };

    // 저장
    wFn.doSave = function() { 	 
        var options = {
            url: "franchise_proc.php"
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
                    location.href = "franchise_list.php";    
                } catch(ex) {
                    alert("error");
                    wComm.log(json, ex.message);
                }
            }
        };
        wObj.$frm.ajaxSubmit(options);
    };
</script>   
<form id="frm" name="frm" action="#" method="post" onsubmit="return false;">
<input type="hidden" name="mode" />
<input type="hidden" name="idx" value="<?= $idx ?>"/>
<section id="contents">
    <h2>가맹정보</h2>
    <ul class="history">
        <li>가맹정보</li>
        <li>가맹정보 데이터 수정</li>
    </ul>	
    <div class="write_list">
        <h3 class="il_mid_title"><b>가맹정보 데이터 수정</b></h3>
        <fieldset>
            <legend>가맹정보 데이터 수정 폼</legend>
            <table class="write">
                <caption></caption>
                <colgroup>
                    <col style="width:220px">
                    <col style="width:auto">
                </colgroup>
                <tbody>
                    <tr>
                        <th class="vertical_m">
                            <span style="font-size: 18px; font-weight: 700;">
                                년도<?= $seoul_mark ?>
                            </span>									
                        </th> 
                        <td > 
                            <select name="yyyy" style="width: 200px;">
                                <option value="<?= $two_pre_year ?>" <?php if($yyyy == $two_pre_year) {?>selected="selected"<?php } ?>><?= $two_pre_year ?></option>
                                <option value="<?= $pre_year ?>" <?php if($yyyy == $pre_year) {?>selected="selected"<?php } ?>><?= $pre_year ?></option>
                                <option value="<?= $yy ?>" <?php if($yyyy == $yy) {?>selected="selected"<?php } ?>><?= $yy ?></option>
                                <option value="<?= $after_yy ?>" <?php if($yyyy == $after_yy) {?>selected="selected"<?php } ?>><?= $after_yy ?></option>
    
                            </select>
                            <select name="mm" style="width: 80px;">
                                <option value="01" <?php if($mm == "01") {?>selected="selected"<?php } ?>>01</option>
                                <option value="02" <?php if($mm == "02") {?>selected="selected"<?php } ?>>02</option>
                                <option value="03" <?php if($mm == "03") {?>selected="selected"<?php } ?>>03</option>
                                <option value="04" <?php if($mm == "04") {?>selected="selected"<?php } ?>>04</option>
                                <option value="05" <?php if($mm == "05") {?>selected="selected"<?php } ?>>05</option>
                                <option value="06" <?php if($mm == "06") {?>selected="selected"<?php } ?>>06</option>
                                <option value="07" <?php if($mm == "07") {?>selected="selected"<?php } ?>>07</option>
                                <option value="08" <?php if($mm == "08") {?>selected="selected"<?php } ?>>08</option>
                                <option value="09" <?php if($mm == "09") {?>selected="selected"<?php } ?>>09</option>
                                <option value="10" <?php if($mm == "10") {?>selected="selected"<?php } ?>>10</option>
                                <option value="11" <?php if($mm == "11") {?>selected="selected"<?php } ?>>11</option>
                                <option value="12" <?php if($mm == "12") {?>selected="selected"<?php } ?>>12</option>
                            </select>
                        </td>
                    <tr>
                        <th class="vertical_m">A그룹(서울권) 매출액</th>
                        <td>
                            <input type="text" name="seoul_price"  data-currency="true" value="<?= $seoul_price ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <th class="vertical_m">A그룹 중요표시</th>
                        <td>
                            <select name="seoul_mark" style="width: 180px;">
                                <option value="N" <?php if($seoul_mark == "N") {?>selected="selected"<?php } ?>>미중요</option>
                                <option value="Y" <?php if($seoul_mark == "Y") {?>selected="selected"<?php } ?>>중요</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th class="vertical_m">B그룹(강원권) 매출액</th>
                        <td>
                            <input type="text" name="gangwon_price" data-currency="true" value="<?= $gangwon_price ?>"/>
                        </td>
                    </tr>		
                    <tr>
                        <th class="vertical_m">B그룹(강원권) 중요표시</th>
                        <td>
                            <select name="gangwon_mark" style="width: 180px;">
                                <option value="N" <?php if($gangwon_mark == "N") {?>selected="selected"<?php } ?>>미중요</option>
                                <option value="Y" <?php if($gangwon_mark == "Y") {?>selected="selected"<?php } ?>>중요</option>
                            </select>
                        </td>
                    </tr>	
                    <tr>
                        <th class="vertical_m">C그룹(경기권) 매출액</th>
                        <td>
                            <input type="text" name="gyeonggi_price" data-currency="true" value="<?= $gyeonggi_price ?>"/>
                        </td>
                    </tr>		
                    <tr>
                        <th class="vertical_m">C그룹(경기권) 중요표시</th>
                        <td>
                            <select name="gyeonggi_mark" style="width: 180px;">
                                <option value="N" <?php if($gyeonggi_mark == "N") {?>selected="selected"<?php } ?>>미중요</option>
                                <option value="Y" <?php if($gyeonggi_mark == "Y") {?>selected="selected"<?php } ?>>중요</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th class="vertical_m">노출여부</th>
                        <td>
                            <select name="display_yn" style="width: 180px;">
                                <option value="Y" <?php if($display_yn == "Y") {?>selected="selected"<?php } ?>>노출</option>
                                <option value="N" <?php if($display_yn == "N") {?>selected="selected"<?php } ?>>미노출</option>
                            </select>
                        </td>
                    </tr>	
                </tbody>
            </table>
        </fieldset>
        <div class="btn_page text_c">
            <a href="franchise_list.php" class="btn_big type_02">이전화면</a>
            <?php if ($idx != null) { ?>
            <a href="#" class="btn_big type_05" onClick="wFn.setSave('DEL');">삭제하기</a>
            <?php } ?>
            <a href="#" class="btn_big type_01" onClick="wFn.setSave('SAVE');">등록하기</a>
        </div>
    </div>
</section>
</form>
<?php include 'bottom.php'; ?>