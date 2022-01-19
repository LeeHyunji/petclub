<?php
    $conn = mysqli_connect('localhost', 'mysql', 'petclub1!!', 'petclubs');
    $mode = $_POST['mode'];
    if ($mode == "A") {
        $a_content = $_POST['a_content']; 
        $a_content_1 = $_POST['a_content_1']; 
        $a_content_2 = $_POST['a_content_2']; 
        $a_content_3 = $_POST['a_content_3']; 
        $a_content_4 = $_POST['a_content_4']; 
        $a_content_5 = $_POST['a_content_5']; 
        
        $sql = "
            update user_content set
                content = replace('$a_content', ',', '')
                , content_1 = replace('$a_content_1', ',', '')
                , content_2 = replace('$a_content_2', ',', '')
                , content_3 = replace('$a_content_3', ',', '')
                , content_4 = '$a_content_4'
                , content_5 = '$a_content_5' 
            where gubun = 'A' and idx = 9";
        $result = mysqli_query($conn, $sql);
        
        if ($result == false ) {
            echo json_encode(array("login" => true, "status" => false, "msg" => "저장시 문제가 발생했습니다."));
            exit;
        } else {
            echo json_encode(array("login" => true, "status" => true, "msg" => "변경되었습니다."));
            exit;
        }
    } elseif ($mode == "B") {
        // 배열 (가맹점 매출)
        $idxs = $_POST['idx'];
        $contents = $_POST['content']; 
        $content_1s = $_POST['content_1']; 
        $content_2s = $_POST['content_2']; 
        $content_3s = $_POST['content_3']; 

        foreach( $contents as $key => $content ) {
            $sql = "
            update user_content set
                content = '$content'
                , content_1 = '$content_1s[$key]'
                , content_2 = '$content_2s[$key]'
                , content_3 = '$content_3s[$key]'
            where gubun = 'S'
            and idx = '$idxs[$key]'";
       
            $result = mysqli_query($conn, $sql);
            if ($result == false ) {
                echo json_encode(array("login" => true, "status" => false, "msg" =>$sql));
                exit;
            }
        }
        echo json_encode(array("login" => true, "status" => true, "msg" => "변경되었습니다."));
        exit;
    } elseif ($mode == "C") {
        $idxs = $_POST['idx'];
        $contents = $_POST['content']; 
        $content_1s = $_POST['content_1']; 
        $content_2s = $_POST['content_2']; 
        $content_3s = $_POST['content_3']; 
        $content_4s = $_POST['content_4']; 

        foreach( $contents as $key => $content ) {
            $sql = "
                update user_content set
                    content = '$content'
                    , content_1 = '$content_1s[$key]'
                    , content_2 = '$content_2s[$key]'
                    , content_3 = replace('$content_3s[$key]', ',', '')
                    , content_4 = '$content_4s[$key]'
                where gubun = 'C' 
                and idx = '$idxs[$key]'";
            $result = mysqli_query($conn, $sql);
            
            if ($result == false ) {
                echo json_encode(array("login" => true, "status" => false, "msg" => "저장시 문제가 발생했습니다."));
                exit;
            } 
        }
        echo json_encode(array("login" => true, "status" => true, "msg" => "변경되었습니다."));
        exit;
    }
?>