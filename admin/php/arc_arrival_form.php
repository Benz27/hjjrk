<?php
$table="arrivals_archives";
function get_name($link,$user_id){
    $sql="SELECT fname, lname FROM info where user_id=$user_id";
    $result = mysqli_query($link, $sql);

    if($result && mysqli_num_rows($result) > 0){ 
        $row = mysqli_fetch_array($result);
        return $row['fname'].' '.$row['lname'];

    }
}

function get_usertype($link, $user_id)
{
    $sql = "SELECT usertype FROM user where user_id=$user_id";
    $result = mysqli_query($link, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        $utype=$row['usertype'];
        if($utype==0){
            return "School Employee";
        }
        if($utype==1){
            return "Student";
        }
        return "Visitor";

    }
}

function get_data($link,$id){
   
    $sql="SELECT * FROM $GLOBALS[table] where a_id=$id";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_array($result);

    $dte = new DateTime($row['dte']);
    $subm = new DateTime($row['submitted']);

        return '<p class="strong mb-2">User ID:'.$row['user_id'].'</p>
        <p class="strong mb-2">User: '.get_name($link,$row['user_id']).'</p>
        <p class="strong mb-2">Usertype: '.get_usertype($link,$row['user_id']).'</p>
        <p class="strong mb-2">Department to visit: '.$row['dept'].'</p>
        <p class="strong mb-2">Date of visit: '.date_format($dte,"M j, Y").'</p>
        <p class="strong mb-2">Date requested: '.date_format($subm,"M j, Y").'</p>
        <br>
        <p class="strong mb-2">Reason for visit</p>
        <textarea id="reason" name="" rows="5" cols="130" readonly>'.$row['reason'].'</textarea>';

}


function get_button($link,$id){

    return '<a class="text-info" style="text-decoration:none;">Archived</a>';

   

}


function get_stat($link,$a_id){
    $sql="SELECT status FROM $GLOBALS[table] where a_id=$a_id";
    $result = mysqli_query($link, $sql);
    if($result && mysqli_num_rows($result) > 0){ 
        $row = mysqli_fetch_array($result);
        if($row['status']<0){
            return 'Denied';
        }
        if($row['status']>0){
            return 'Confirmed';
        }
        return 'Pending';
    }
}


function get_arrv_form($link, $a_id){


    echo '<div id="crt"><div class="pb-5">
        <div class="container">
          <div class="row">
    
            <div class="col-md-12">
                <div class="card border-0 ">
                    <div class="row mt-4">
                    
    
                        
                        <div class="col-12">
                            <p class="strong mb-2">REQUEST ID: '.$a_id.'<span class="strong mb-2" style="float:right;">'.get_stat($link,$a_id).'</span></p>
    
                            <hr class="mt-0">
                        </div>
                        <div class="col-12">
                        '.get_data($link,$a_id).'

                        <hr class="mt-0">
                        </div>
                        
                        <div class="col-12">
                        <p class="strong mb-2"><span class="strong mb-2">'.get_button($link,$a_id).'</span></p>
    
                        <hr class="mt-0">
                </div>
    
    
                        
                    </div>
                    
                </div>
            </div>
    
              </div>
            
            </div>';
    }