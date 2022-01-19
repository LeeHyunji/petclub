
<?php include 'top.php'; ?>
<script type="text/javascript">
    jQuery(function($) {
        wObj.$frm = $("form[name=frm]");                
    });

    // 파일 저장하기.
    wFn.setUserContent = function(mode) {
        wObj.$frm.find("input[name=mode]").val(mode);
        if (!confirm("저장하시겠습니까?")) {
            return;
        }
        
        wComm.doSJson(
            wComm.fmtForm(wObj.$frm)
            , "mainProc.php"
            , function() { }
            , function(msg) {
                alert(msg);
                location.href ="petclub_about.php";       
            }
        );
    };
</script>   
<form id="frm" name="frm" action="#" onsubmit="return false;">
<input type="hidden" name="mode" />
<section id="contents">
    <h2>펫클럽 소개</h2>
    <ul class="history">
        <li>펫클럽 소개</li>
        <li>숫자데이터 수정</li>
    </ul>	
    <!--
    <div class="write_list">
        <h3 class="il_mid_title"><b>숫자데이터 수정</b></h3>
        <fieldset>
            <legend>홈화면 관리 입력 폼</legend>
            <table class="write">
                <caption></caption>
                <colgroup>
                    <col style="width:180px">
                    <col style="width:400px">
                    <col style="width:auto">
                </colgroup>
                <tbody>
                <?php  
                      $sql = "
                      select FORMAT(content, 0) as content
                          , FORMAT(content_1, 1) as content_1
                          , FORMAT(content_2, 0) as content_2
                          , FORMAT(content_3, 0) as content_3 
                          , content_4 
                          , content_5 
                      from user_content where gubun = 'A' ";
                      $result = mysqli_query($conn, $sql);
                      $row = mysqli_fetch_array($result);
                ?>
                  <tr>
                        <th rowspan="4" class="vertical_m" style="padding: 40px 20px;"><span style="font-size: 18px; font-weight: 700;">숫자데이터 수정</span></th>
                        <td class="text_c">
                            <input type="text" name="a_content_4" value="<?= $row['content_4'] ?>" />
                        </td>
                        <td>
                            <input type="text" name="a_content"  data-currency="true" value="<?php echo $row['content'] ?>"/>
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
    -->
    <div class="write_list">
        <h3 class="il_mid_title"><b>직전 월 매출 수정</b></h3>
        <fieldset>
            <legend>홈화면 관리 입력 폼</legend>
            <table class="write">
                <caption></caption>
                <colgroup>
                    <col style="width:180px">
                    <col style="width:220px">
                    <col style="width:auto">
                </colgroup>
                <tbody>
                <?php  
                      $sql = "
                      select idx
                          , content
                          , content_1
                          , content_2
                          , FORMAT(content_3, 0) as content_3 
                          , FORMAT(content_4, 1) as content_4 
                      from user_content where gubun = 'C'  ";
                      $result = mysqli_query($conn, $sql);
                      $no = 1;  
                      while($row = mysqli_fetch_array($result)) {
                ?>
                  <tr>
                        <th rowspan="5" class="vertical_m" style="padding: 40px 20px;"><span style="font-size: 18px; font-weight: 700;">직전 월 매출 수정(<?= $no ?>)</span></th>
                        <td class="text_c">지점명</td>
                        <td>
                            <input type="hidden" name="idx[]" value="<?= $row['idx'] ?>"/>
                            <input type="text" name="content[]" value="<?= $row['content'] ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="text_c">평수</td>
                        <td>
                            <input type="text" name="content_1[]"  value="<?= $row['content_1'] ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="text_c">직영점</td>
                        <td>
                            <input type="text" name="content_2[]" value="<?= $row['content_2'] ?>"/>
                        </td>
                    </tr>		
                    <tr>
                        <td class="text_c">직전 월 매출</td>
                        <td>
                            <input type="text" name="content_3[]"  data-currency="true" value="<?= $row['content_3'] ?>"/>
                        </td>
                    </tr>	
                    <tr>
                        <td class="text_c">직전 수익율</td>
                        <td>
                            <input type="text" name="content_4[]"  value="<?= $row['content_4'] ?>"/>
                        </td>
                    </tr>
                    <?php
                        $no = $no + 1;
                        }
                    ?>       
                </tbody>
            </table>
        </fieldset>
        <div class="btn_page text_c">
            <a href="#" id="btnReg" class="btn_big type_01" onClick="javascript:wFn.setUserContent('C');">저장</a>
        </div>
    </div>
</section>
</form>
<?php include 'bottom.php'; ?>