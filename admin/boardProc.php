<?php
    session_start();
    $conn = mysqli_connect('localhost', 'mysql', 'petclub1!!', 'petclubs');

    //LIST 값.
    $mode = $_POST['mode'];
    $title = addslashes($_POST['title']);
    $en_board_name = $_POST['en_board_name'];
    $display = $_POST['display'];
    $popular = $_POST['popular'];
    $people = $_POST['people'];
    $company = $_POST['company'];
    $url = addslashes($_POST['url']);
    $content = addslashes($_POST['content']);
    $idx = $_POST['idx']; 
    $summary = addslashes($_POST['summary']);
    $ip = $_SERVER['REMOTE_ADDR'];    
    $id = $_SESSION['id'];
    $file_idx = $_POST['file_idx'];

    $sql = "select idx from board_master where en_name = '$en_board_name'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $master_idx = $row["idx"];

    if ($mode == "DELFILE") {
        $sql = "delete from board_file where idx = '$file_idx'";
        $result = mysqli_query($conn, $sql);

        if ($result == false ) {
            echo json_encode(array("login" => true, "status" => false, "msg" => "파일삭제시 문제가 발생했습니다."));
            exit;
        } 
        echo json_encode(array("login" => true, "status" => true, "msg" => "파일이 삭제되었습니다."));
    } else if ($mode == "DEL") {
        $sql = "
            delete from board_list
            where idx = '$idx'";
        $result = mysqli_query($conn, $sql);
        if ($result == false ) {
            echo json_encode(array("login" => true, "status" => false, "msg" => "1.삭제시 문제가 발생했습니다."));
            exit;
        } 
        $sql = "
            delete from board_file
            where list_idx = '$idx'";
        $result = mysqli_query($conn, $sql);
        if ($result == false ) {
            echo json_encode(array("login" => true, "status" => false, "msg" => "2.삭제시 문제가 발생했습니다."));
            exit;
        } 

        echo json_encode(array("login" => true, "status" => true, "msg" => "삭제되었습니다.."));
    } else {
        if ($idx == null) {
            $sql = "select ifnull(max(idx), 0) + 1 as cnt from board_list";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);
            $idx = $row["cnt"];

            $sql = "
                insert into board_list (
                    IDX,
                    MASTER_IDX,
                    ULTRA_IDX,
                    TITLE,
                    CONTENT,
                    WRITER,
                    PEOPLE,
                    URL,
                    COMPANY,
                    POPULAR,
                    DISPLAY,
                    SUMMARY,
                    INS_DATE,
                    INS_IP) 
                values (
                    '$idx',
                    '$master_idx',
                    '$idx',
                    '$title',
                    '$content',
                    '$id',
                    '$people',
                    '$url',
                    '$company',
                    '$popular',
                    '$display',
                    '$summary', 
                    DATE_FORMAT(now(), '%Y%m%d'),
                    '$ip'
                )";
            $result = mysqli_query($conn, $sql);
            
            if ($result == false ) {
                echo json_encode(array("login" => true, "status" => false, "msg" => "1.저장시 문제가 발생했습니다. $sql"));
                exit;
            } 
        } else {
            $sql = "
            update board_list set 
                TITLE = '$title',
                CONTENT = '$content',
                WRITER = '$id',
                PEOPLE = '$people',
                URL = '$url',
                COMPANY = '$company',
                POPULAR = '$popular',
                SUMMARY = '$summary',
                DISPLAY = '$display'
            where IDX = '$idx'";

            $result = mysqli_query($conn, $sql);
            if ($result == false ) {
                echo json_encode(array("login" => true, "status" => false, "msg" => "2.저장시 문제가 발생했습니다."));
                exit;
            } 
        }
    
        $uploads_dir = $_SERVER['DOCUMENT_ROOT'].'/upfile/board';
    
        for ($i = 0; $i < 11; $i++ ) {        
            // 변수 정리
            $error = $_FILES["mulityFile$i"]["error"];
            $name = $_FILES["mulityFile$i"]["name"];
            $ext = array_pop(explode('.', $name));
            $file_name = md5(microtime()). '.' .$ext;
            
            if($name != null) {
                // 오류 확인
                if( $error != UPLOAD_ERR_OK ) {
                    switch( $error ) {
                        case UPLOAD_ERR_INI_SIZE:
                        case UPLOAD_ERR_FORM_SIZE:
                            echo json_encode(array("login" => true, "status" => false, "msg" => "1.파일이 너무 큽니다. ($error)"));
                            break;
                        case UPLOAD_ERR_NO_FILE:
                            echo json_encode(array("login" => true, "status" => true, "msg" => "2.파일이 첨부되지 않았습니다.($error)."));
                            break;
                        default:
                            echo json_encode(array("login" => true, "status" => false, "msg" => "3.파일이 제대로 업로드되지 않았습니다. ($error)"));
                            break;
                    }
                    exit;
                }
        
                if (!move_uploaded_file( $_FILES["mulityFile$i"]["tmp_name"], "$uploads_dir/$file_name") ) {
                    echo json_encode(array("login" => true, "status" => false, "msg" => "4.파일저장이 되지 않았습니다."));
                    exit;
                }
        
                if ($file_idx == null) {
                    $sql = "select ifnull(max(idx), 0)+ 1 as idx from board_file";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_array($result);
                    $file_idx = $row["idx"];
        
                    $sql = "
                        insert into board_file (
                            IDX,
                            LIST_IDX,
                            FILE_NAME,
                            FILE_EXT,
                            INS_DATE,
                            INS_IP) 
                        values (
                            '$file_idx',
                            '$idx',
                            '$file_name',
                            '$ext',
                            DATE_FORMAT(now(), '%Y%m%d'),
                            '$ip'
                        )";
                    $result = mysqli_query($conn, $sql);
                    
                    if ($result == false ) {
                        echo json_encode(array("login" => true, "status" => false, "msg" => "5.파일이 제대로 업로드되지 않았습니다.$sql"));
                        exit;
                    } 
                } else {
                    $sql = "
                    update board_file set 
                        file_name = '$file_name',
                        file_ext = '$ext',
                    where idx = '$file_idx'";
                    $result = mysqli_query($conn, $sql);
                    if ($result == false ) {
                        echo json_encode(array("login" => true, "status" => false, "msg" => "6.파일이 제대로 업로드되지 않았습니다."));
                        exit;
                    } 
                }
            }
        }
        echo json_encode(array("login" => true, "status" => true, "msg" => "저장되었습니다."));
    }
?>