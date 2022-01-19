
<?php include 'top.php'; ?>
<?php
    $keyword = $_POST['keyword'];

    $sql = "select count(*) as cnt from franchise_list 
        where yymm like '%$keyword%'
        and delete_yn = 'N'";
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
<form id="frm" name="frm" action="franchise_list.php" method="post">
<input type="hidden" id="page" name="page" value="<?= $page ?>" />
<section id="contents">
    <h2>가맹정보</h2>
    <ul class="history">
        <li>가맹정보</li>
        <li>가맹정보 데이터 수정</li>
    </ul>
    <div class="write_list">
        <h3 class="il_mid_title"><b>가맹정보 데이터 수정</b></h3>
        <div class="list_top_sort">
            <div class="action">
                <div class="list_search">
                    <fieldset>
                        <legend>리스트 검색 입력 폼</legend>
                        <input type="text" id="keyword" name="keyword" value="<?= $keyword ?>" style="width:294px" onkeypress="if(event.keyCode==13) javascript:goPage(1);"/>
                        <input type="button" id="btnSearch" class="btn_list_search" value="매장명 또는 지역을 검색하세요.">
                    </fieldset>
                </div>
            </div>
        </div>
                        
        <div class="list_data">						
            <table class="list" id="list">
                <caption>가맹정보 데이터 수정</caption>
                <colgroup>
                    <col style="width:90px">
                    <col style="width:auto">
                    <col style="width:100px">
                </colgroup>
                <thead>
                    <tr>
                        <th scope="col">번호</th>
                        <th scope="col">연도</th>
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
                            from franchise_list
                            where yymm like '%$keyword%' 
                            and delete_yn = 'N'
                            order by idx desc) a
                            limit $start , $pageSize
                        ";
                        $result = mysqli_query($conn, $sql);
                        $no = 0;
                        while($row = mysqli_fetch_array($result)) {
                    ?>
                        <tr>
                            <td class="text_c f_500 color_04"><?= $pageSize * ($page - 1) + $no + 1 ?></td>
                            <td class="text_c f_500 color_04">
                                <a href="franchise_regist.php?idx=<?= $row['idx'] ?>">
                                    <?= $row['yymm'] ?>
                                </a>
                            </td>
                            <td class="text_c f_500 color_04">
                                <?php
                                    if ($row['display_yn'] == "Y") {
                                        echo "노출";
                                    } else {
                                        echo "미노출";
                                    }
                                ?>
                            </td>
                        </tr>
                      <?php
                        $no = $no + 1;
                        }
                        if ($no == 0) {                        
                      ?>
                      <tr><td class="text_c f_500 color_04" colspan="3"> 값이 존재하지 않습니다.</td></tr>
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
                <a href="franchise_regist.php" id="btnReg" class="btn_big type_01">신규 등록</a>
            </p>
        </div>
    
    </div>
</section>
</form>
<?php include 'bottom.php'; ?>