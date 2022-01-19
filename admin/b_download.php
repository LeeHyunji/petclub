<?php
    session_start();
    $conn = mysqli_connect('localhost', 'mysql', 'petclub1!!', 'petclubs');

    $file_idx = $_POST['file_idx'];

    $sql = "select file_name from board_file where idx = '$file_idx'";

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    $target_Dir = $_SERVER['DOCUMENT_ROOT'].'/upfile/board/';
    $file = $row['file_name'];

    $down = $target_Dir.$file;
    $filesize = filesize($down);

    if (is_file($down)) {
        header("Content-Type:application/octet-stream");
        header("Content-Disposition:attachment;filename=$file");
        header("Content-Transfer-Encoding:binary");
        header("Content-Length:".filesize($target_Dir.$file));
        header("Cache-Control:cache,must-revalidate");
        header("Pragma:no-cache");
        header("Expires:0");        
        $fp = fopen($down, "rb"); 
	    fpassthru($fp);
	    fclose($fp);
    } else {   
?>
<script type="text/javascript">
    alert("파일이 존재 하지 않습니다.");
</script>
<?php
    }
?>

