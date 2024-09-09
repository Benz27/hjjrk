<?php


session_start();
include('conn.php');
$arr=array();
$sql = "SELECT * FROM announcements where d_id=1111111";
if ($result = mysqli_query($link, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);

        array_push($arr,$row['img'],$row['content'],$row['dte']);


        echo json_encode($arr);




    }

    mysqli_free_result($result);
}
