<?php
    session_start();
    $conn = mysqli_connect('localhost', 'mysql', 'petclub1!!', 'petclubs');

    $mode = $_POST['mode'];
    $sido = $_POST['sido'];
    $customname = $_POST['customname'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $park = $_POST['park'];
    $lati = $_POST['lati'];
    $lng = $_POST['lng'];
    $time_start = $_POST['time_start'];
    $time_end = $_POST['time_end'];
    $display_yn = $_POST['display_yn'];
    $open_yn = $_POST['open_yn'];
    $address_det = $_POST['address_det'];
    $idx = $_POST['idx']; 
    $file_idx = $_POST['file_idx'];
    $ip = $_SERVER['REMOTE_ADDR'];
    

    if ($mode == "DELFILE") {
        $sql = "delete from gps_file where idx = '$file_idx'";
        $result = mysqli_query($conn, $sql);

        if ($result == false ) {
            echo json_encode(array("login" => true, "status" => false, "msg" => "파일삭제시 문제가 발생했습니다."));
            exit;
        } 
        echo json_encode(array("login" => true, "status" => true, "msg" => "파일이 삭제되었습니다.."));
    } else if ($mode == "DEL") {
        $sql = "
            delete from gps_info
            where idx = '$idx'";
        $result = mysqli_query($conn, $sql);
        if ($result == false ) {
            echo json_encode(array("login" => true, "status" => false, "msg" => "1.삭제시 문제가 발생했습니다."));
            exit;
        } 
        $sql = "
            delete from gps_file
            where gps_idx = '$idx'";
        $result = mysqli_query($conn, $sql);
        if ($result == false ) {
            echo json_encode(array("login" => true, "status" => false, "msg" => "2.삭제시 문제가 발생했습니다."));
            exit;
        } 

        echo json_encode(array("login" => true, "status" => true, "msg" => "삭제되었습니다.."));
    } else {
        if ($idx == null) {
            $sql = "select ifnull(max(idx),0) + 1 as idx from gps_info";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);
            $idx = $row["idx"];
    
            $sql = "
                insert into gps_info (
                    IDX,
                    CUSTOMNAME,
                    SiDO,
                    LATI,
                    LNG,
                    PARK,
                    ADDRESS,
                    PHONE,
                    TIME_START,
                    TIME_END,
                    OPEN_YN,
                    DISPLAY_YN,
                    ADDRESS_DET,
                    INS_DATE,
                    INS_IP) 
                values (
                    '$idx',
                    '$customname',
                    '$sido',
                    '$lati',
                    '$lng',
                    '$park',
                    '$address',
                    '$phone',
                    '$time_start',
                    '$time_end',
                    '$open_yn',
                    '$display_yn',
                    '$address_det',
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
            update gps_info set 
                CUSTOMNAME = '$customname',
                SiDO = '$sido',
                LATI = '$lati',
                LNG = '$lng',
                PARK = '$park',
                ADDRESS = '$address',
                PHONE = '$phone',
                TIME_START = '$time_start',
                TIME_END = '$time_end',
                OPEN_YN = '$open_yn',
                ADDRESS_DET = '$address_det',
                DISPLAY_YN = '$display_yn'
            where idx = '$idx'";
        $result = mysqli_query($conn, $sql);
            if ($result == false ) {
                echo json_encode(array("login" => true, "status" => false, "msg" => "2.저장시 문제가 발생했습니다."));
                exit;
            } 
        }
    
        $uploads_dir = $_SERVER['DOCUMENT_ROOT'].'/map/images/store';
    
        // 변수 정리
        $error = $_FILES["img_file"]["error"];
        $name = $_FILES["img_file"]["name"];
        $ext = array_pop(explode('.', $name));
        $file_name = md5(microtime()). '.' .$ext;
    
        if($name != null) {
            // 오류 확인
            if( $error != UPLOAD_ERR_OK ) {
                switch( $error ) {
                    case UPLOAD_ERR_INI_SIZE:
                    case UPLOAD_ERR_FORM_SIZE:
                        echo json_encode(array("login" => true, "status" => false, "msg" => "파일이 너무 큽니다. ($error)"));
                        break;
                    case UPLOAD_ERR_NO_FILE:
                        echo json_encode(array("login" => true, "status" => true, "msg" => "파일이 첨부되지 않았습니다.($error)."));
                        break;
                    default:
                        echo json_encode(array("login" => true, "status" => false, "msg" => "파일이 제대로 업로드되지 않았습니다. ($error)"));
                        break;
                }
                exit;
            }
    
            if (move_uploaded_file( $_FILES['img_file']['tmp_name'], "$uploads_dir/$file_name") ) {
            } else {
                echo json_encode(array("login" => true, "status" => false, "msg" => "파일저장이 되지 않았습니다."));
            }
    
            if ($file_idx == null) {
                $sql = "select ifnull(max(idx), 0) + 1 as idx from gps_file";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_array($result);
                $file_idx = $row["idx"];
    
                $sql = "
                    insert into gps_file (
                        IDX,
                        GPS_IDX,
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
                    echo json_encode(array("login" => true, "status" => false, "msg" => "3.파일이 제대로 업로드되지 않았습니다."));
                    exit;
                } 
            } else {
                $sql = "
                update gps_file set 
                    file_name = '$file_name',
                    file_ext = '$ext',
                where idx = '$file_idx'";
                $result = mysqli_query($conn, $sql);
                if ($result == false ) {
                    echo json_encode(array("login" => true, "status" => false, "msg" => "4.파일이 제대로 업로드되지 않았습니다."));
                    exit;
                } 
            }
        }
        echo json_encode(array("login" => true, "status" => true, "msg" => "저장되었습니다."));
    }
?>