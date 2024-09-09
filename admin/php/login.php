<?php
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "dbase";


    $link = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    if($link === false){
        die("Could not connect!" . mysqli_connect_error());
    }

    $ers=0;
if($_SERVER['REQUEST_METHOD']=='POST'){   




    $userborder="";     
    $passborder="";   
    $alertp="";    
    $userval="";   

    $uname=$_POST['uname'];    
    $pass=$_POST['password'];   

    $sql="SELECT * FROM admin where username='$uname'"; 
    $result=mysqli_query($link, $sql);  
    if($result && mysqli_num_rows($result) > 0){    
        $user_data=mysqli_fetch_assoc($result);    
        if($user_data['password']===$pass){ 
            $_SESSION['admin_user_id']=$user_data['user_id'];
            $_SESSION['usertype']=$user_data['usertype'];   
            header("Location: ./"); 
        }else{       
            $userval=$uname;    
            $ers=1; 
        }
    }else{   
        $userval=$uname;   
        $ers=2;
    }


}

$sql = "SELECT * FROM about where id=1";
if ($result = mysqli_query($link, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        $adnme = $row['admin_name'];
    }
}
