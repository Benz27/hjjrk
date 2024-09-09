<?php

session_start();
include("conn.php");

$user_id=mt_rand(1000000, 9999999);  
$sql="SELECT user_id FROM user where user_id=$user_id"; 
$result=mysqli_query($link, $sql);     
if($result && mysqli_num_rows($result) > 0){      
    $user_data=mysqli_fetch_assoc($result);      
    while($user_id ==  $user_data['user_id']){    
        $user_id=mt_rand(1000000, 9999999);     
    }
}

echo $user_id;