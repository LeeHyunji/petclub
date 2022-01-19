<!DOCTYPE>
<html>
<head>
<meta http-equiv="Content-Script-Type" content="text/javascript"/>
<meta http-equiv="content-style-type" content="text/css"/>
<meta http-equiv="expires" content="-1"/>
<meta http-equiv="pragma" content="no-cache"/>
<meta http-equiv="cache-control" content="no-cache"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<meta name="_csrf" content="cbee9a06-5a2a-42e1-a699-31a87ff608bf" data-url="/">
<meta name="_csrf_header" content="X-CSRF-TOKEN">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"/>
<title>맵</title>
</haed>
<body>
    <?php
        $conn = mysqli_connect('localhost', 'mysql', 'petclub1!!', 'petclubs');
        $sql = "INSERT INTO gps_info
        (customName,
        lati,
        lng,
        park,
        address,
        phone,
        time_start,
        time_end,
        ins_date,
        ins_ip)
        VALUES
        ('펫클럽 선정릉점',
        '37.51204427330895',
        '127.04289332663572',
        '가능',
        '서울특별시 강남구 선릉로 619 1층 102호',
        '0507-1396-6505',
        '00:00',
        '24:00',
        DATE_FORMAT(NOW(), '%Y%m%d'),
        '192.168.0.1')";
        mysqli_query($conn, $sql);
    ?>
</body>
</html>

echo("<script type='text/javascript'>wFn.markerSet($row['IDX'], , $row['CUSTOMNAME'], $row['TIME_START'], $row['TIME_END'], $row['ADDRESS'], $row['PHONE'] , $row['PARK'], $row['FILE_NAME'], $row['LATI'], $row['LNG']);</script>");
 