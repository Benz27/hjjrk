
<?php
session_start();
include("conn.php");
$us_edit = "";
if (isset($_SESSION["user_id"])) {
    $us_edit = " and user_id <> $_SESSION[user_id]";
}

$q = $_GET['q'];
$qu = $_GET['qu'];
$table = $_GET['table'];

$qu_table="user";
$qu_table_admin="admin";
if($qu=="phone"){
    $qu_table="info";
    $qu_table_admin="admin_info"; 
}


$sql = "SELECT * FROM $qu_table where $qu='$q'$us_edit";
$result = mysqli_query($link, $sql);
if ($result && mysqli_num_rows($result) > 0) {



    echo "1";
} else {

    $sql = "SELECT * FROM $qu_table_admin where $qu='$q'$us_edit";
    $result = mysqli_query($link, $sql);
    if ($result && mysqli_num_rows($result) > 0) {

        echo "1";
    } else {

        echo "0";
    }
}



// $sql = "SELECT * FROM $table where $qu='$q'$us_edit";
// $result = mysqli_query($link, $sql);
// if ($result && mysqli_num_rows($result) > 0) {


//     $user_data = mysqli_fetch_assoc($result);
//     echo "1";
// } else {

//     echo "0";
// }



mysqli_close($link);
