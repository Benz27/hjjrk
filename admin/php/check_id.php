<?php

session_start();
include("conn.php");
$x=$_GET["id"];
$bool=false;
$sql="SELECT user_id FROM user where user_id=$x"; 
$result=mysqli_query($link, $sql);     
if($result && mysqli_num_rows($result) > 0){      
    $user_data=mysqli_fetch_assoc($result);      
    while($user_id ==  $user_data['user_id']){    
        $bool=true;
    }
}

echo $bool;