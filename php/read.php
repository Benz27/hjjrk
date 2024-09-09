<?php
    $s_id=false;

function check_login($link){

    if(isset($_SESSION['user_id']) || $_SESSION['user_id']==""){       
        $GLOBALS['s_id']=true;
        
        $id = $_SESSION['user_id'];     
        $query="select user_id from user where user_id = '$id'";    
        $result=mysqli_query($link,$query);     
        if($result && mysqli_num_rows($result) > 0){    


            
            return $_SESSION['user_id'];      

        }
    }   
    header("Location: ../login/");  



}
function check_hst_forthisweekhst_forthisweek($link){

        $id = $_SESSION['user_id'];  
        $bool=false;
        $query="SELECT `dte` FROM `ans_sheets` WHERE `user_id` = $id ORDER BY `dte` DESC LIMIT 1";    
        $result=mysqli_query($link,$query);     
        if($result && mysqli_num_rows($result) > 0){    
            $row=mysqli_fetch_assoc($result); 

            date_default_timezone_set("Asia/Manila");
            $dte=explode(" ",$row['dte']);
            $startTimeStamp = strtotime($dte[0]);
            $endTimeStamp = strtotime(date('Y-m-d'));
            
            $timeDiff = abs($endTimeStamp - $startTimeStamp);
            
            $numberDays = $timeDiff/86400;
            
            $numberDays = intval($numberDays);

            if($numberDays<7){
                $bool=true;
            }

        }
    
        return $bool;  
}
$user_data=check_login($link);
$hst_forthisweek=check_hst_forthisweekhst_forthisweek($link);

if($hst_forthisweek){
    $hst_notif='';
}else{
    $hst_notif='<div class="sidebar-card bg-info d-none d-lg-flex">
<img class="sidebar-card-illustration mb-2" src="../img/hst_logo.png" alt="...">
                <p class="text-center mb-2 text-dark">You have yet to submit your health status form for this week.</p>
                <a class="btn btn-warning text-dark btn-sm" href="health_status_form.html">Submit now.</a>
            </div>';
};