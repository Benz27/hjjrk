
<?php
session_start();
include("conn.php");

$pass = $_GET["pass"];

$sql = "SELECT password FROM user where user_id=$_SESSION[user_id]";
$result = mysqli_query($link, $sql);
if ($result && mysqli_num_rows($result) > 0) {
    $user_data = mysqli_fetch_assoc($result);

    if ($user_data['password'] == $pass = $_GET["pass"]) {
        echo "1";
    } else {
        echo "0";
    }
} else {
    echo "2";
}

mysqli_close($link);
