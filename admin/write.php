<?php include 'top.php'; ?>
<?php
    $idx = $_GET['idx'];
    $sql = "select * from board_list_view where list_idx = '$idx'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    if($row != null) {
        $master_idx = $row['master_idx'];
        $en_board_name = $row['en_board_name'];
        $display = $row['display'];
        $title = $row['title'];
        $people = $row['people'];
        $company = $row['company'];
        $url = $row['url'];
        $content = $row['content'];
        $popular = $row['popular'];
    }
?>
<script type="text/javascript">
    jQuery(function($) {
        var editor = $("#content").smartEditor();
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
            url: "boardProc.php"
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
                        location.href = "list.php";    
                    }   
                } catch(ex) {
                    alert("error");
                    wComm.log(json, ex.message);
                }
            }
        };
        wObj.$frm.ajaxSubmit(options);
    };

    // 다운로드
    wFn.download = function(file_idx) {
        wObj.$frm.find("input[name=file_idx]").val(file_idx)
        var frm = document.frm;
        frm.method = "post";
        frm.action = "b_download.php"
        frm.submit();
    };
        // 파일 삭제
    wFn.setDelFile = function(file_idx) {
        wObj.$frm.find("input[name=file_idx]").val(file_idx)
        wObj.$frm.find("input[name=mode]").val("DELFILE");
        wFn.doSave();
    };

    // 삭제하기.
    wFn.setDel = function() {
        if(!confirm("삭제하시겠습니까?")) {
            return;
        }
        wObj.$frm.find("input[name=mode]").val("DEL");
        wFn.doSave();
    };

    // 리플레시
    wFn.goRefresh = function() {
        var frm = document.frm;
        frm.method = "post";
        frm.action = "write.php";
        frm.sumbit();
    };
</script>
<form id="frm" name="frm" action="#" onsubmit="return false;" method="post" encType="multipart/form-data">
<input type="hidden" name="mode" />
<input type="hidden" name="idx" value="<?= $idx ?>"/>
<input type="hidden" name="file_idx" />
<section id="contents">
<h2>뉴스&이벤트</h2>
    <ul class="history">
        <li>뉴스&이벤트</li>
        <li>게시글 등록</li>
    </ul>
    <!-- write_list -->
    <div class="write_list">
        <fieldset>
            <legend>게시판 등록 입력 폼</legend>
            <table class="write">
                <caption>게시판 등록 테이블</caption>
                <colgroup>
                    <col style="width:160px">
                    <col style="width:auto">
                    <col style="width:160px">
                    <col style="width:auto">
                </colgroup>
                <tbody>
                    <tr>
                        <th><em class="need">*</em>카테고리</th>
                        <td>
                            <select name="en_board_name"  style="width:175px">
                                <option value="EVENT" <?php if($en_board_name == "EVENT") {?>selected="selected"<?php } ?>>이벤트</option>
                                <option value="NEW" <?php if($en_board_name == "NEW") {?>selected="selected"<?php } ?>>뉴스</option>
                            </select>
                        </td>
                        <th><em class="need">*</em>노출여부</th>
                        <td>
                            <select name="display" style="width:175px">
                                <option value="Y" <?php if($display == "Y") {?>selected="selected"<?php } ?>>노출</option>
                                <option value="N" <?php if($display == "N") {?>selected="selected"<?php } ?>>미노출</option>
                            </select>
                        </td>		
                    </tr>		
                    <tr>
                        <th><em class="need">*</em>제목</th>
                        <td colspan="3"><input type="text" name="title" id="title" title="제목 입력" style="width:583px" value="<?= $row['title'] ?>" /></td>
                    </tr>
                    <tr>
                        <th>기자이름</th>
                        <td>
                            <input type="text" name="people" title="기자이름 입력" style="width:200px" value="<?= $row['people'] ?>" />
                        </td>
                        <th>신문사</th>
                        <td>
                            <input type="text" name="company" title="신문사 입력" style="width:200px" value="<?= $row['company'] ?>" />
                        </td>
                    </tr>
                    <tr>
                        <th>기사 URL</th>
                        <td><input type="text" name="url"  title="기사 URL 입력" style="width:200px" value="<?= $row['url'] ?>" /></td>
                        <th>인기 게시글</th>
                        <td>
                            <select name="popular" style="width:175px">
                                <option value="N" <?php if($popular == "N") {?>selected="selected"<?php } ?>>N</option>
                                <option value="Y" <?php if($popular == "Y") {?>selected="selected"<?php } ?>>Y</option>
                            </select>    
                        </td> 
                    </tr>	
                    <tr>
                        <th><em class="need">*</em>요약</th>
                        <td colspan="3">
                            <input type="text" name="summary" style="width:583px"  value="<?= $row['summary'] ?>" />
                        </td>
                    </tr>
                    <tr>
                        <th><em class="need">*</em>내용</th>
                        <td colspan="3">
                            <textarea id="content" name="content" style="96%" escapeXml="false" ><?= $content ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th>파일</th>
                        <td class="nPd" colspan="3">
                            <div id="fileList" class="file_add_list">
                            <?php 
                                $sql = "select * from board_file where list_idx = '$idx'";
                                $result = mysqli_query($conn, $sql);
                                
                                while($row = mysqli_fetch_array($result)) {
                                    $file_name = $row['FILE_NAME'];
                                    $file_idx = $row['IDX'];
                            ?>
                                <div class="list_item">
                                    <p class="item">
                                        <a href="#" id="fileDown<?= $file_name ?>" class="txt" onClick="wFn.download('<?= $file_idx ?>');">
                                            <?= $file_name ?>
                                        </a>
                                        <button type="button" class="btn_small type_02 btn_del"  onClick="wFn.setDelFile('<?= $file_idx ?>');"><span>삭제</span></button>
                                    </p>
                                </div>
                            <?php
                                }    
                            ?>
                            </div>
                            <ul class="file_parent">
                                <li class="add_input">
                                    <div class="file_cell">
                                        <input type="file" name="mulityFile0" title="파일 업로드" onchange="fileChange(this);">
                                        <input type="text" name="mulityFileTxt0" readonly="" value="" title="업로드된 파일 경로">
                                        <button class="btn_small type_03 btn_file"><span>파일찾기</span></button>
                                        <button class="btn_fild_add" onclick="addInputFile(this);"></button>
                                    </div>
                                    <span class="file_add_info">최대 10개/20MB까지 가능</span>
                                </li>
                            </ul>
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