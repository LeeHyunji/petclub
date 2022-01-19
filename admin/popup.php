<?php include 'top.php'; ?>
<?php
    $keyword = $_POST['keyword'];

    $sql = "select count(*) as cnt from popup_list where delete_yn = 'N' and display_yn = 'Y'";
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
<!-- contents -->
<section id="contents">
    <h2>메인화면</h2>
    <ul class="history">
        <li>메인화면</li>
        <li>메인 팝업 관리</li>
    </ul>
    <!-- list_data -->
    <div class="list_data">
        <h3 class="il_mid_title"><b>메인 팝업 관리</b></h3>	
        <table class="list" id="list">
            <caption>리스트 테이블</caption>
            <colgroup>
                <col style="width:90px">
                <col style="width:auto">
                <col style="width:300px">
                <col style="width:150px">
            </colgroup>
            <thead>
                <tr>
                    <th scope="col">번호</th>
                    <th scope="col">제목</th>
                    <th scope="col">기간</th>
                    <th scope="col">상태</th>
                </tr>
            </thead>
            <tbody>
                <?php  
                    $sql = "
                        select a.*
                        from(
                        select * 
                        from popup_list
                        where display_yn ='Y'
                        and delete_yn = 'N'
                        order by idx desc) a
                        limit $start , $pageSize;
                    ";
                    $result = mysqli_query($conn, $sql);
                    $no = 0;
                    while($row = mysqli_fetch_array($result)) {
                ?>
                    <tr>
                        <td class=""><?= $pageSize * ($page - 1) + $no + 1 ?></td>
                        <td class="text_l">		
                            <a href="popup_regist.php?idx=<?= $row['idx'] ?>" class="btn_link">
                                <?= $row['title'] ?>
                            </a>
                        </td>
                        <td class=""><?= $row['start_date'] ?> ~ <?= $row['end_date'] ?></td>
                        <td class="">
                            <?php
                                if($display == "Y") {
                                    echo "노출";
                                } else {
                                    echo "미노출";
                                }
                            ?>
                        </td>
                    </tr>
                <?php
                    }
                    $no =  no + 1;
                    if ($no == "0") {
                 ?>
                    <tr><td colspan="4"> 값이 존재하지 않습니다.</td></tr>
                 <?php       
                    } 
                ?>       
            </tbody>
        </table>
    </div>
    <!-- //list_data -->

    <div class="paging_wrap">
        <div class="paging" id="pageNavi"></div>
        <p class="btn_pos_right">
            <a href="popup_regist.php" class="btn_big type_01">팝업추가</a>
        </p>
    </div>
</section>
<?php include 'bottom.php'; ?>