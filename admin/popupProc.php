<?php
    session_start();
    $conn = mysqli_connect('localhost', 'mysql', 'petclub1!!', 'petclubs');
   
    $pop_left = $row['pop_left'];
    $pop_top = $row['pop_top'];
    $pop_height = $row['pop_height'];
    $pop_width = $row['pop_width'];
    $display_yn = $row['display_yn'];
    $start_date = $row['start_date'];
    $end_date = $row['end_date'];
    $title = $row['title'];
    $content = $row['content'];

    //LIST 값.
    $idx = $_POST['idx']; 
    $mode = $_POST['mode'];
    $title = $_POST['title'];
    $pop_left = $_POST['pop_left'];
    $display_yn = $_POST['display_yn'];
    $pop_top = $_POST['pop_top'];
    $pop_height = $_POST['pop_height'];
    $pop_width = $_POST['pop_width'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $content = $_POST['content'];
    $ip = $_SERVER['REMOTE_ADDR'];    
    $id = $_SESSION['id'];

    if ($mode == "DEL") {
        $sql = "
            delete from popup_list
            where idx = '$idx'";
        $result = mysqli_query($conn, $sql);
        if ($result == false ) {
            echo json_encode(array("login" => true, "status" => false, "msg" => "1.삭제시 문제가 발생했습니다."));
            exit;
        } 
        $sql = "
            delete from popup_list
            where list_idx = '$idx'";
        $result = mysqli_query($conn, $sql);
        if ($result == false ) {
            echo json_encode(array("login" => true, "status" => false, "msg" => "2.삭제시 문제가 발생했습니다."));
            exit;
        } 

        echo json_encode(array("login" => true, "status" => true, "msg" => "삭제되었습니다.."));
    } else {
        if ($idx == null) {
            $sql = "select ifnull(max(idx), 0) + 1 as cnt from popup_list";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);
            $idx = $row["cnt"];

            $sql = "
                insert into popup_list (
                    idx,
                    title,
                    start_date,
                    end_date,
                    pop_left,
                    pop_top,
                    pop_width,
                    pop_height,
                    content,
                    display_yn,
                    ins_date,
                    ins_ip) 
                values (
                    '$idx',
                    '$title',
                    '$start_date',
                    '$end_date',
                    '$pop_left',
                    '$pop_top',
                    '$pop_width',
                    '$pop_height',
                    '$content',
                    '$display_yn', 
                    DATE_FORMAT(now(), '%Y%m%d'),
                    '$ip'
                )";
            $result = mysqli_query($conn, $sql);
            
            if ($result == false ) {
                echo json_encode(array("login" => true, "status" => false, "msg" => "1.저장시 문제가 발생했습니다."));
                exit;
            } 
        } else {
            $sql = "
            update popup_list set 
                title = '$title',
                start_date = '$start_date',
                end_date = '$end_date',
                pop_left = '$pop_left',
                pop_top = '$pop_top',
                pop_width = '$pop_width',
                pop_height = '$pop_height',
                content = '$content',
                display_yn ='$display_yn'
            where idx = '$idx'";

            $result = mysqli_query($conn, $sql);
            if ($result == false ) {
                echo json_encode(array("login" => true, "status" => false, "msg" => "2.저장시 문제가 발생했습니다."));
                exit;
            } 
        }
        echo json_encode(array("login" => true, "status" => true, "msg" => "저장되었습니다."));
    }
?>