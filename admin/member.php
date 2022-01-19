<?php include 'top.php'; ?>
<script type="text/javascript">
    jQuery(function($) {
        wObj.$frm = $("form[name=frm]");       
    });
    wFn.setChangePw = function() {
        var c_pw = wObj.$frm.find("input[name=c_pw]").val()
            , p_pw = wObj.$frm.find("input[name=p_pw]").val();

        if (wComm.isEmpty(c_pw)) {
            alert("변경 비밀번호를 넣어주세요.");
            return;
        }
        if (wComm.isEmpty(p_pw)) {
            alert("현재 비밀번호를 넣어주세요.");
            return;
        }

        if (c_pw === p_pw) {
            alert("변경 비밀번호와 현재 비밀번호가 같습니다.");
            return;
        }

        if (!confirm("변경하시겠습니까?")) { return; }

        wFn.doSave();
    };
     // 저장
     wFn.doSave = function() { 	 
        var options = {
            url: "memberProc.php"
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
<form id="frm" name="frm" action="main.php" onsubmit="return false;" method="post">
<section id="contents">
    <h2>메인</h2>
    <ul class="history">
        <li>메인</li>
        <li>패스워드변경</li>
    </ul>
    <div class="write_list">
        <h3 class="il_mid_title"><b>패스워드변경</b></h3>
        <fieldset>
            <legend>패스워드변경</legend>
            <table class="write">
                <caption></caption>
                <colgroup>
                    <col style="width:200px">
                    <col style="width:auto">
                </colgroup>
                <tbody>
                    <tr>
                        <th class="vertical_m" >
                            <span style="font-size: 18px; font-weight: 700;">
                                현재 비밀번호
                            </span>									
                        </th>
                        <td>
                            <input type="password" name="p_pw" placeholder="현재 비밀번호를 입력해주세요."/>
                        </td>
                    </tr>								
                    <tr>
                        <th class="vertical_m">
                            <span style="font-size: 18px; font-weight: 700;">
                                변경비밀번호
                            </span>									
                        </th>
                        <td>
                            <input type="password" name="c_pw" placeholder="변경하실 비밀번호를 입력해주세요." /> 
                        </td>
                    </tr>
                </tbody>
            </table>
        </fieldset>

        <div class="btn_page text_c">
            <a href="#" class="btn_big type_01" onClick="wFn.setChangePw();">변경하기</a>
        </div>
    </div>
</section>
</form>
<?php include 'bottom.php'; ?>
