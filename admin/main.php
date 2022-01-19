<?php include 'top.php'; ?>
<script type="text/javascript">
    jQuery(function($) {
        wObj.$frm = $("form[name=frm]");       
    });

    wFn.setUserContent = function(mode) {
        wObj.$frm.find("input[name=mode]").val(mode);
        if (!confirm("저장하시겠습니까?")) {
            return;
        }
        wFn.doSave();
    };
    // 저장
    wFn.doSave = function() { 	 
        var options = {
            url: "mainProc.php"
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
                    location.href = "main.php";    
                } catch(ex) {
                    alert("error");
                    wComm.log(json, ex.message);
                }
            }
        };
        wObj.$frm.ajaxSubmit(options);
    };
</script>   
<form id="frm" name="frm" action="mainProc.php" method="post">
<input type="hidden" name="mode"/>
<section id="contents">
    <h2>메인화면</h2>
    <ul class="history">
        <li>메인화면</li>
        <li>메인화면 데이터 수정</li>
    </ul>	
    <div class="write_list">
        <h3 class="il_mid_title"><b>메인 슬라이드 데이터 수정</b></h3>
        <fieldset>
            <legend>홈화면 관리 입력 폼</legend>
            <?php  
                $sql = "
                select FORMAT(content, 0) as content
                    , FORMAT(content_1, 1) as content_1
                    , FORMAT(content_2, 0) as content_2
                    , FORMAT(content_3, 0) as content_3 
                    , content_4 
                    , content_5
                from user_content where gubun = 'A' and idx=9 ";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_array($result);
            ?>
            <table class="write">
                <caption></caption>
                <colgroup>
                    <col style="width:180px">
                    <col style="width:400px">
                    <col style="width:auto">
                </colgroup>
                <tbody>
                    <tr>
                        <th rowspan="4" class="vertical_m" style="padding: 40px 20px;"><span style="font-size: 18px; font-weight: 700;">숫자데이터 수정</span></th>
                        <td class="text_c">
                            <input type="text" name="a_content_4" value="<?= $row['content_4'] ?>" />
                        </td>
                        <td>
                            <input type="text" name="a_content"  data-currency="true" value="<?= $row['content'] ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="text_c">
                            <input type="text" name="a_content_5" value="<?= $row['content_5'] ?>" />
                        </td>
                        <td>
                            <input type="text" name="a_content_1" data-currency="true"  value="<?= $row['content_1'] ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="text_c">매장수 입력</td>
                        <td>
                            <input type="text" name="a_content_2" data-currency="true"  value="<?= $row['content_2'] ?>"/>
                        </td>
                    </tr>		
                    <tr>
                        <td class="text_c">회원수 입력</td>
                        <td>
                            <input type="text" name="a_content_3"  data-currency="true" value="<?= $row['content_3'] ?>"/>
                        </td>
                    </tr>																
                    
                </tbody>
            </table>
        </fieldset>
        <div class="btn_page text_c">
            <a href="#" id="btnReg" class="btn_big type_01" onClick="javascript:wFn.setUserContent('A');">저장</a>
        </div>
    </div>
    
    <div class="write_list">
        <h3 class="il_mid_title"><b>펫클럽 가맹점 월매출</b></h3>
        <fieldset>
            <legend>홈화면 관리 입력 폼</legend>
            <?php
                $sql = "select * from user_content a where a.gubun = 'S' order by a.idx desc limit 4";
                $result = mysqli_query($conn, $sql);
                $no = 1;
                while($row = mysqli_fetch_array($result)) {
            ?>
            <table class="write">
                <caption></caption>
                <colgroup>
                    <col style="width:180px">
                    <col style="width:220px">
                    <col style="width:auto">
                </colgroup>
                <tbody>
                        <th rowspan="6" class="vertical_m" style="padding: 40px 20px;">
                            <span style="font-size: 18px; font-weight: 700; line-height:24px;">가맹점 <?= $no ?><br/>월매출</span>
                        </th>									
                        <td colspan="2">
                            <input type="hidden" name="idx[]" value="<?= $row['IDX'] ?>"/>
                            <input type="text" name="content[]" value="<?= $row['CONTENT'] ?>">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="text" name="content_2[]" value="<?= $row['CONTENT_2'] ?>">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="text" name="content_1[]" value="<?= $row['CONTENT_1'] ?>">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="text" name="content_3[]" data-curreny="true" value="<?= $row['CONTENT_3'] ?>">
                        </td>
                    </tr>																										
                </tbody>		
            </table>	
            <?php
                $no = $no + 1;
                }
            ?>            																			
        </fieldset>
        <div class="btn_page text_c">
            <a href="#" id="btnReg" class="btn_big type_01" onClick="javascript:wFn.setUserContent('S');">저장</a>
        </div>
    </div>				
</section>
</form>
<?php include 'bottom.php'; ?>