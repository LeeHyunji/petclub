<?php
    session_start();
    $conn = mysqli_connect('localhost', 'mysql', 'petclub1!!', 'petclubs');
    $id = $_POST['user_id']; // 아이디
    $pw = $_POST['user_pw']; // 패스워드
      
    $sql = "select id, pw, hname from users where id = '$id'    ";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    
    if ($row == null) {
        echo json_encode(array("login" => true, "status" => false, "msg" => "1.아이디가 존재하지 않습니다."));
        exit;
    } else {
        if ($row["pw"] != $pw) {
            echo json_encode(array("login" => true, "status" => false, "msg" => "2. 비밀번호가 틀립니다 \n 다시 입력해주시기 바랍니다."));
            exit;
        } else {
            $_SESSION['id'] = $id;
            $_SESSION['ss_auth'] = $row['auth'];
            $_SESSION['hname'] = $row['hname'];
            echo json_encode(array("login" => true, "status" => true, "msg" => "로그인에 성공하였습니다."));
            exit;
        }
    }    
?>