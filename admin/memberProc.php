<?php
    session_start();
    $conn = mysqli_connect('localhost', 'mysql', 'petclub1!!', 'petclubs');
    $p_pw = $_POST['p_pw']; // 현재 패스워드
    $c_pw = $_POST['c_pw']; // 변경 패스워드
    $id = $_SESSION['id']; // 아이디 
    
    
    $sql = "select id, pw, hname from users where id = '$id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    if ($row["pw"] != $p_pw) {
        echo json_encode(array("login" => true, "status" => false, "msg" => "1. 현재 비밀번호가 틀립니다."));
        exit;
    } else {
        $sql = "
            update users set
                pw = '$c_pw'
            where id = '$id'
            and pw = '$p_pw' ";
        $result = mysqli_query($conn, $sql);
        
        if ($result == false ) {
            echo json_encode(array("login" => true, "status" => false, "msg" => "저장시 문제가 발생했습니다.$sql"));
            exit;
        } else {
            echo json_encode(array("login" => true, "status" => true, "msg" => "변경되었습니다."));
            exit;
        }
    }
?>