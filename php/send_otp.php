<?php

include("conn.php");

function set_name($email){
    $link = $GLOBALS['link'];
    
    $sql = "SELECT `fname`, 
    `lname`, 
    `mname`
    FROM `info` where `email`='$email'";
    $result = mysqli_query($link, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
    
    
        $row = mysqli_fetch_assoc($result);
        // $user_id = $row['user_id'];
        return $row['fname'] . " " . $row['mname'] . " " . $row['lname'];
    } else {
    
        $sql = "SELECT `fname`, 
        `lname`, 
        `mname`
        FROM `admin_info` where `email`='$email'";
        $result = mysqli_query($link, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            // $user_id = $row['user_id'];
            return $row['fname'] . " " . $row['mname'] . " " . $row['lname'];
        }
    }
}



$otp_id = otp_id_gen();

function create_otp($user_id, $otp_id)
{
    $link = $GLOBALS['link'];
    if (del_otp($user_id)) {
        date_default_timezone_set("Asia/Manila");
        $created = date("Y-m-d H:i:s");
        $expire = expire($created);
        $pass = gen_pass();
        $sql = "INSERT INTO otp_request values ($otp_id,$user_id,'$pass','$created','$expire','',0,0)";
        if ($link->query($sql) === TRUE) {
            return true;
        } else {
            echo "Error : " . $link->error;
            return false;
        }
    }
}

function create_session_otp($email, $otp_id)
{
    $_SESSION['otp_id'] = $otp_id;
    $_SESSION['otp_pass'] = gen_pass();
    $_SESSION['user_email'] = $email;
    $created = date("Y-m-d H:i:s");
    $expire = expire($created);
    $_SESSION['otp_created'] = $created;
    $_SESSION['otp_expires_on'] = $expire;
    $_SESSION['otp_expired'] = false;
    $_SESSION['otp_used'] = false;
    return true;
}

function unset_session_otp()
{
    unset(
        $_SESSION['otp_id'],
        $_SESSION['otp_pass'],
        $_SESSION['user_email'],
        $_SESSION['otp_created'],
        $_SESSION['otp_expires_on'],
        $_SESSION['otp_expired'],
        $_SESSION['otp_used']
    );
    return true;
}

function randomPassword()
{
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array();
    $alphaLength = strlen($alphabet) - 1;
    for ($i = 0; $i < 7; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass);
}



function del_otp($user_id)
{
    $link = $GLOBALS['link'];

    $sql = "DELETE FROM otp_request WHERE user_id=$user_id and link_used = 0 and expired = 0";
    if ($link->query($sql) === TRUE) {
        return true;
    } else {
        echo "Error : " . $link->error;
        return false;
    }
}

function gen_pass()
{
    $pass = randomPassword();
    $sql = "SELECT password FROM otp_request where password=$pass";
    $result = mysqli_query($GLOBALS['link'], $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $user_data = mysqli_fetch_assoc($result);
        while ($pass ==  $user_data['password']) {
            $pass = randomPassword();
        }
    }

    return $pass;
}

function otp_id_gen()
{
    $user_id = mt_rand(1000000, 9999999);
    $sql = "SELECT otp_id FROM otp_request where otp_id=$user_id";
    $result = mysqli_query($GLOBALS['link'], $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $user_data = mysqli_fetch_assoc($result);
        while ($user_id ==  $user_data['user_id']) {
            $user_id = mt_rand(1000000, 9999999);
        }
    }

    return $user_id;
}

function expire($created)
{
    $minutes_to_add = 30;

    $time = new DateTime($created);
    $time->add(new DateInterval('PT' . $minutes_to_add . 'M'));

    $stamp = $time->format('Y-m-d H:i:s');
    return $stamp;
}

function expired()
{
    if (isset($_SESSION['otp_id'])) {
        if ($_SESSION['otp_used']) {
            return true;
        }

        $d1 = new DateTime(date("Y-m-d H:i:s"));
        $d2 = new DateTime($_SESSION['otp_expires_on']);
        if ($d1 > $d2) {
            return true;
        }
    }
    return false;
}







    // for ($x = 0; $x < 2, $found == true; $x++) {
//     echo 1;
//     $sql = "SELECT $tables[$x].fname, 
//     $tables[$x].lname, 
//     $tables[$x].mname
//     FROM $tables[$x],$tables_base[$x] where $tables_base[$x].email='$email'";
//     $result = mysqli_query($link, $sql);
//     if ($result && mysqli_num_rows($result) > 0) {
//         $found = true;
//         $submit=true;
//         $row=mysqli_fetch_assoc($result);
//         $user_fullname=$row['fname']." ".$row['mname']." ".$row['lname'];




//     }else{
//         echo $link->error;
//     }
   

// }