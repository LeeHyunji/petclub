<?php
    $conn = mysqli_connect('localhost', 'mysql', 'petclub1!!', 'petclubs');
    
    $mode = $_POST['mode'];
    $idx = $_POST['idx']; 
    $yyyy = $_POST['yyyy']; 
    $mm = $_POST['mm']; 
    $seoul_price = $_POST['seoul_price']; 
    $gangwon_price = $_POST['gangwon_price']; 
    $gyeonggi_price = $_POST['gyeonggi_price']; 
    $seoul_mark = $_POST['seoul_mark']; 
    $gangwon_mark = $_POST['gangwon_mark']; 
    $gyeonggi_mark = $_POST['gyeonggi_mark']; 
    $display_yn = $_POST['display_yn'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $id = $_SESSION['id'];

    $yymm = $yyyy.'-'.$mm;

    if ($mode == "SAVE") {
        if ($idx != null) {
            $sql = "
            update franchise_list set
                yymm = '$yymm',
                seoul_price = '$seoul_price',
                seoul_mark= '$seoul_mark',
                gangwon_price= '$gangwon_price',
                gangwon_mark= '$gangwon_mark',
                gyeonggi_price= '$gyeonggi_price',
                gyeonggi_mark= '$gyeonggi_mark',
                display_yn = '$display_yn'
            where gubun = '$idx'";
            $result = mysqli_query($conn, $sql);
            
            if ($result == false ) {
                echo json_encode(array("login" => true, "status" => false, "msg" => "1.수정시 문제가 발생했습니다."));
                exit;
            } else {
                echo json_encode(array("login" => true, "status" => false, "msg" => "변경되었습니다."));
                exit;
            }
        } else {
            $sql = "select ifnull(max(idx), 0) + 1 as cnt from franchise_list";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);
            $idx = $row["cnt"];

            $sql = "
                insert into franchise_list (
                    idx,
                    yymm,
                    seoul_price,
                    seoul_mark,
                    gangwon_price,
                    gangwon_mark,
                    gyeonggi_price,
                    gyeonggi_mark,
                    display_yn,
                    ins_date,
                    ins_ip) 
                values (
                    '$idx',
                    '$yymm',
                    '$seoul_price',
                    '$seoul_mark',
                    '$gangwon_price',
                    '$gangwon_mark',
                    '$gyeonggi_price',
                    '$gyeonggi_mark',
                    '$display_yn',
                    DATE_FORMAT(now(), '%Y%m%d'),
                    '$ip'
                )";
            $result = mysqli_query($conn, $sql);
            
            if ($result == false ) {
                echo json_encode(array("login" => true, "status" => false, "msg" => "1.저장시 문제가 발생했습니다.$sql"));
                exit;
            } 
        }
        echo json_encode(array("login" => true, "status" => true, "msg" => "저장되었습니다."));
        exit;
    } else {
        $sql = "
        update franchise_list set
            delete_yn = 'Y'
        where idx = '$idx'";
        $result = mysqli_query($conn, $sql);
        
        if ($result == false ) {
            echo json_encode(array("login" => true, "status" => false, "msg" => "1.삭제시 문제가 발생했습니다."));
            exit;
        } else {
            echo json_encode(array("login" => true, "status" => false, "msg" => "삭제되었습니다."));
            exit;
        }
    }
?>