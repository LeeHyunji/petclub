
<?php include 'top.php'; ?>
<?php
    $keywordType = $_POST['keywordType'];
    $keyword = $_POST['keyword'];

    $sql = "select count(*) as cnt from board_list_view 
        where en_board_name like '%$keywordType%' 
        and title like '%$keyword%'";
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
<form id="frm" name="frm" action="list.php" method="post">
<input type="hidden" id="page" name="page" value="<?= $page ?>" />
<section id="contents">
    <h2>뉴스&이벤트</h2>
    <ul class="history">
        <li>뉴스&이벤트</li>
        <li>게시글 관리</li>
    </ul>
    <div class="write_list">
        <h3 class="il_mid_title"><b>게시글 관리</b></h3>
        <div class="list_top_sort">
            <div class="action">
                <div class="list_search">
                    <fieldset>
                        <legend>리스트 검색 입력 폼</legend>
                        <select id="keywordType" name="keywordType" style="width:108px;">
                            <option value="" <?php if($keywordType == null) {?>selected="selected"<?php } ?>>전체</option>
                            <option value="NEW" <?php if($keywordType == "NEW") {?>selected="selected"<?php } ?>>뉴스</option>
                            <option value="EVENT" <?php if($keywordType == "EVENT") {?>selected="selected"<?php } ?>>이벤트</option>
                        </select>
                        <input type="text" id="keyword" name="keyword" value="<?= $keyword ?>" style="width:294px" onkeypress="if(event.keyCode==13) javascript:goPage(1);"/>
                        <input type="button" id="btnSearch" class="btn_list_search" value="게시글 종류 및 제목을 입력하세요.">
                    </fieldset>
                </div>
            </div>
        </div>
                        
        <div class="list_data">						
            <table class="list" id="list">
                <caption>매장 리스트</caption>
                <colgroup>
                    <col style="width:90px">
                    <col style="width:auto">
                    <col style="width:90px">
                    <col style="width:100px">
                </colgroup>
                <thead>
                    <tr>
                        <th scope="col">번호</th>
                        <th scope="col">제목</th>
                        <th scope="col">작성자</th>
                        <th scope="col">등록일</th>
                    </tr>
                </thead>
                <tbody>
                    <tbody>
                    <?php  
                        $sql = "
                            select a.*
                            from(
                            select * 
                            from board_list_view
                            where en_board_name like '%$keywordType%' 
                            and title like '%$keyword%'
                            order by b.list_idx desc) a
                            limit $start , $pageSize;
                        ";
                        $result = mysqli_query($conn, $sql);
                        $no = 0;
                        while($row = mysqli_fetch_array($result)) {
                    ?>
                        <tr>
                            <td class="text_c f_500 color_04"><?= $pageSize * ($page - 1) + $no + 1 ?></td>
                            <td class="text_c f_500 color_04"><a href="write.php?idx=<?= $row['list_idx'] ?>"><?= $row['title'] ?></a></td>
                            <td class="text_l f_500 color_04"><?= $row['writer'] ?></td>
                            <td class="text_c f_500 color_04"><?= $row['ins_date'] ?></td>
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
                <a href="write.php" id="btnReg" class="btn_big type_01">신규 등록</a>
            </p>
        </div>

    
    </div>
</section>
</form>
<?php include 'bottom.php'; ?>