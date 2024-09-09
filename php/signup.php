<?php
    $errmsg="";

    if($_SERVER['REQUEST_METHOD']=='POST'){ 


        $fname=$_POST['fname'];     
        $lname=$_POST['lname'];     
        $mname=$_POST['mname'];    
        $addr=$_POST['addr']; 
        $email=$_POST['email'];   
        $pass=$_POST['pass'];     
        $bday=$_POST['dte'];     
        $phone=$_POST['phone'];     
        $usertype=$_POST['usertype'];

        $user_id=$_POST['txtid'];    
       
        $dte=date('Y-m-d H:i:s');
        // $dtedisp=date('m/d/Y');
        // $dtenum=(date('Y')*10000)+(date('n')*100)+date('j');


                    $sql="INSERT INTO user (user_id, email, password, usertype,dte) values ($user_id,'$email','$pass','$usertype','$dte')"; 
                    if ($link->query($sql) === TRUE) {
        
                            $sql="INSERT INTO info (user_id, fname, lname,mname,address,email,bday,phone) values 
                            ($user_id,'$fname','$lname','$mname','$addr','$email','$bday','$phone')";
                            if ($link->query($sql) === TRUE){
                                header("Location: ../login/"); 
                            }else{
                                $errmsg="Error : " . $link->error;
                            }

                    }else{
            
                        $errmsg="Error : " . $link->error;
                    }

                    

            
                    

    }


    
