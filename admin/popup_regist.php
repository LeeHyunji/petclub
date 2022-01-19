<?php include 'top.php'; ?>
<?php
    $idx = $_GET['idx'];
    $sql = "select * from popup_list where idx = '$idx'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    if($row != null) {
        $pop_left = $row['pop_left'];
        $pop_top = $row['pop_top'];
        $pop_height = $row['pop_height'];
        $pop_width = $row['pop_width'];
        $display_yn = $row['display_yn'];
        $start_date = $row['start_date'];
        $end_date = $row['end_date'];
        $title = $row['title'];
        $content = $row['content'];
    }
?>
<script type="text/javascript">
    jQuery(function($) {
        var editor = $("#content").smartEditor();
        $(".datepicker").datepicker({
            showOn:"both",
            buttonImage:"images/datepicker/btn_datepicker.png",
            buttonImageOnly:true,
            dateFormat: 'yy.mm.dd',
            prevText: '이전 달',
            nextText: '다음 달',
            monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
            monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
            dayNames: ['일','월','화','수','목','금','토'],
            dayNamesShort: ['일','월','화','수','목','금','토'],
            dayNamesMin: ['일','월','화','수','목','금','토'],
            showMonthAfterYear: true,
            yearRange: "1900:2100",
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true
        });
        wObj.$frm = $("form[name=frm]");
        $("#btnReg").on("click", function() {
            if (wComm.isEmpty(wObj.$frm.find("input[name=title]").val() ) ) {
                alert("제목을 입력해주세요.");
                return;
            } 

            if ( editor.val() != "<br/>" ) { editor.update() };

            if (wComm.isEmpty($("#content").val()) ) {
                alert("내용을 입력해주세요.");
                return;
            } 

            if(!confirm("저장하시겠습니까?")) {
                return;
            }
            wObj.$frm.find("input[name=mode]").val("SAVE");
            wFn.doSave();
        });
    });

    // 저장
    wFn.doSave = function() { 	 
        var options = {
            url: "popupProc.php"
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
                    location.href = "popup.php";    
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
</script>
<form id="frm" name="frm" action="#" onsubmit="return false;" method="post">
<input type="hidden" name="mode" />
<input type="hidden" name="idx" value="<?= $idx ?>"/>
<section id="contents">
<h2>메인화면</h2>
    <ul class="history">
        <li>메인화면</li>
        <li>메인 팝업 관리</li>
    </ul>
    <!-- write_list -->
    <div class="write_list">
        <fieldset>
            <legend>메인 팝업 입력 폼</legend>
            <table class="write">
                <caption>메인 팝업 등록 테이블</caption>
                <colgroup>
                    <col style="width:160px">
                    <col style="width:auto">
                    <col style="width:160px">
                    <col style="width:auto">
                </colgroup>
                <tbody>
                    <tr>
                        <th><em class="need">*</em>제목</th>
                        <td colspan="3">
                            <input type="text" name="title" id="title" title="제목 입력"  style="width:583px" value="<?= $title ?>" />
                        </td>
                    </tr>
                    <tr>
                        <th><em class="need">*</em>오픈 일자</th>
                        <td colspan="3">
                            <input type="text" name="start_date" class="datepicker" style="width:150px"title="시작 달력 입력" value="<?= $start_date ?>"/>
                            ~
                            <input type="text" name="end_date" class="datepicker" style="width:150px" title="종료 달력 입력" value="<?= $end_date ?>"/>
                        <div>
                        </td>
                    </tr>
                    <tr>
                        <th><em class="need">*</em>위치</th>
                        <td colspan="3">
                            <input type="text" name="pop_left" 
                            title="왼쪽 고정값" style="width:100px" data-digit="ture" value="<?= $pop_left ?>" />px
                            &nbsp;&nbsp;&nbsp;
                            <input type="text" name="pop_top" 
                            title="상단 고정값" style="width:100px" data-digit="ture" value="<?= $pop_top ?>" />px
                        </td>
                    </tr>
                    <tr>
                        <th><em class="need">*</em>크기</th>
                        <td colspan="3">
                            <input type="text" name="pop_width" 
                            title="넓이 입력" style="width:100px" data-digit="ture"  value="<?= $pop_width ?>" />px
                            &nbsp;&nbsp;&nbsp;
                            <input type="text" name="pop_height" 
                            title="높이 입력" style="width:100px" data-digit="ture"  value="<?= $pop_height ?>" />px
                        </td>
                    </tr>
                    <tr>
                        <th><em class="need">*</em>사용여부</th>
                        <td colspan="3">
                            <select name="display_yn" style="width:175px">
                                <option value="N" <?php if($display_yn == "N") {?>selected="selected"<?php } ?>>노출</option>
                                <option value="Y" <?php if($display_yn == "Y") {?>selected="selected"<?php } ?>>비노출</option>
                            </select>    
                        </td>
                    </tr>
                    <tr>
                        <th><em class="need">*</em>내용</th>
                        <td colspan="3">
                            <textarea id="content" name="content" style="96%" escapeXml="false" ><?= $content ?></textarea>
                        </td>
                    </tr>
                </tbody>
            </table>
        </fieldset>
    </div>
    <div class="btn_page text_c">
        <a href="list.php" class="btn_big type_02">이전화면</a>
        <?php if ($idx != null) { ?>
        <a href="#" class="btn_big type_05" onClick="wFn.setDel();">삭제하기</a>
        <?php } ?>
        <a href="#" class="btn_big type_01" id="btnReg">등록하기</a>
    </div>
</section>
</form>
<?php include 'bottom.php'; ?>