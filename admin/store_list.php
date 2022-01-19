
<?php include 'top.php'; ?>
<?php
    $keywordType = $_POST['keywordType'];
    $keyword = $_POST['keyword'];

    $sql = "select count(*) as cnt from gps_info_view 
        where sido like '%$keywordType%' 
        and customname like '%$keyword%'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
 
    $page = $_POST['page'];
    
    if ($page == null) {
        $page = 1;
    }
    $pageSize = 10 ;
    $totalPage = ceil($row['cnt']/$pageSize) ;

    $start = $pageSize * ($page -1);
?>
<script type="text/javascript">
    jQuery(function($) {
        var json = {
            currentPage : "<?= $page ?>"
            , totalPage : "<?= $totalPage ?>"
        }; 
        fcSetPage("pageNavi", json);
    });

    function goPage(page) {
        $("#page").val(page);
        $("#frm").submit();
    };
</script>
<form id="frm" name="frm" action="store_list.php" method="post">
<input type="hidden" id="page" name="page" value="<?= $page ?>" />
<section id="contents">
    <h2>매장소개</h2>
    <ul class="history">
        <li>매장소개</li>
        <li>매장 관리</li>
    </ul>
    <div class="write_list">
        <h3 class="il_mid_title"><b>매장 관리</b></h3>
        <div class="list_top_sort">
            <div class="action">
                <div class="list_search">
                    <fieldset>
                        <legend>리스트 검색 입력 폼</legend>
                        <select id="keywordType" name="keywordType" style="width:108px;">
                            <option value="" <?php if($keywordType == null) {?>selected="selected"<?php } ?>>전체지역</option>
                            <option value="서울" <?php if($keywordType == "서울") {?>selected="selected"<?php } ?>>서울</option>
                            <option value="경기" <?php if($keywordType == "경기") {?>selected="selected"<?php } ?>>경기</option>
                            <option value="인천" <?php if($keywordType == "인천") {?>selected="selected"<?php } ?>>인천</option>
                            <option value="강원" <?php if($keywordType == "강원") {?>selected="selected"<?php } ?>>강원</option>
                            <option value="경상" <?php if($keywordType == "경상") {?>selected="selected"<?php } ?>>경상</option>
                            <option value="전라" <?php if($keywordType == "전라") {?>selected="selected"<?php } ?>>전라</option>
                            <option value="충청" <?php if($keywordType == "충청") {?>selected="selected"<?php } ?>>충청</option>
                        </select>
                        <input type="text" id="keyword" name="keyword" value="<?= $keyword ?>" style="width:294px" onkeypress="if(event.keyCode==13) javascript:goPage(1);"/>
                        <input type="button" id="btnSearch" class="btn_list_search" value="매장명 또는 지역을 검색하세요.">
                    </fieldset>
                </div>
            </div>
        </div>
                        
        <div class="list_data">						
            <table class="list" id="list">
                <caption>매장 리스트</caption>
                <colgroup>
                    <col style="width:90px">
                    <col style="width:90px">
                    <col style="width:auto">
                    <col style="width:100px">
                </colgroup>
                <thead>
                    <tr>
                        <th scope="col">번호</th>
                        <th scope="col">지역</th>
                        <th scope="col">매장명</th>
                        <th scope="col">노출여부</th>
                    </tr>
                </thead>
                <tbody>
                    <tbody>
                    <?php  
                        $sql = "
                            select a.*
                            from(
                            select * 
                            from gps_info_view
                            where sido like '%$keywordType%' 
                            and customname like '%$keyword%'
                            order by idx desc) a
                            limit $start , $pageSize;
                        ";
                        $result = mysqli_query($conn, $sql);
                        $no = 0;
                        while($row = mysqli_fetch_array($result)) {
                    ?>
                        <tr>
                            <td class="text_c f_500 color_04"><?= $pageSize * ($page - 1) + $no + 1 ?></td>
                            <td class="text_c f_500 color_04"><?= $row['SIDO'] ?></td>
                            <td class="text_l f_500 color_04">
                                <a href="new_store.php?idx=<?= $row['IDX'] ?>">
                                    <?= $row['CUSTOMNAME'] ?>
                                </a>
                            </td>
                            <td class="text_c f_500 color_04"><?= $row['DISPLAY_YN'] ?></td>
                        </tr>
                      <?php
                        $no = $no + 1;
                        }
                        if ($no == 0) {                        
                      ?>
                      <tr><td class="text_c f_500 color_04" colspan="4"> 값이 존재하지 않습니다.</td></tr>
                      <?php
                        }
                      ?>
                    </tbody>
                </tbody>
            </table>
        </div>

        <div class="paging_wrap">
            <div class="paging" id="pageNavi"></div>
            <p class="btn_pos_right">
                <a href="new_store.php" id="btnReg" class="btn_big type_01">신규 등록</a>
            </p>
        </div>

        
    
    </div>
</section>
</form>
<?php include 'bottom.php'; ?>