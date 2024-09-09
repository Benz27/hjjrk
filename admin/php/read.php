<?php
$adbhost = "";
$adbuser = "";
$adbpass = "";
$adbname = "";

$alink = mysqli_connect($adbhost, $adbuser, $adbpass, $adbname);


$nav_fname = "";
$nav_lname = "";
$usertype;
$adnme = "";
$nav_pfp = "./img/empty.png";
if ($alink === false) {
    die("Could not connect!" . mysqli_connect_error());
}

$sql = "SELECT * FROM about where id=1";
if ($result = mysqli_query($alink, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        $adnme = $row['admin_name'];
    }
}

function check_login($alink)
{

    if (isset($_SESSION['admin_user_id'])) {
        $id = $_SESSION['admin_user_id'];

        $sql = "SELECT * FROM admin_info where user_id=$id";
        if ($result = mysqli_query($alink, $sql)) {
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_array($result);
                    $GLOBALS['nav_fname'] = $row['fname'];
                    $GLOBALS['nav_lname'] = $row['lname'];
                    if($row['pfp']!=""){
                        $GLOBALS['nav_pfp']="./img/pfp/".$id."/".$row['pfp'];
                    }
                mysqli_free_result($result);
            } else {
                echo "No records matching your query were found1.";
            }
        } else {
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($alink);
        }


        $query = "select user_id,usertype from admin where user_id = '$id'";
        $result = mysqli_query($alink, $query);
        if ($result && mysqli_num_rows($result) > 0) {


            $user_data = mysqli_fetch_assoc($result);
            $GLOBALS['usertype'] = $user_data['usertype'];
            return $user_data['user_id'];
        }
    }

    header("Location: ../login/");
}

function check_root()
{
    // if($GLOBALS['priv']!="admin"){
    //     header("Location: ./");
    // }

}
