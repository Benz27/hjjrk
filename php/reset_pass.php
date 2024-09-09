<?php

session_start();

if (isset($_GET['pass'])) {
    check_pass($_GET['pass']);
}
if (isset($_POST['pass'])) {
    updt_pass();
}

function updt_pass()
{
    include("../php/conn.php");
    if (!time_expired()) {

        $sql = "UPDATE user SET password = '$_POST[pass]' where email='$_SESSION[user_email]'";
        if ($link->query($sql) === TRUE) {
            unset_session_otp();
            echo 1;
        } else {
            echo $link->error;
        }

    }else{
        echo "expired";
    }
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

}

function time_expired()
{
    $d1 = new DateTime(date("Y-m-d H:i:s"));
    $d2 = new DateTime($_SESSION['otp_expires_on']);
    if ($d1 > $d2) {

        return true;
    }
    return false;
}



function valid(){
    if (!isset($_GET['s'])) {
        return false;
    }
    if (!isset($_SESSION['otp_id'])) {
        return false;
    }
    if ($_GET['s'] != $_SESSION['otp_id']) {
        return false;
    }
    return true;
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
        return false;
    }
    return true;
}

function check_pass($pass)
{
    if (expired()) {
        echo -1;
    } else if ($pass == $_SESSION['otp_pass']) {

        echo $_SESSION['otp_id'];
    } else {
        echo 0;
    }
}


function get_main()
{


    if(!valid()){
        $expired=true;
    }else{
        $expired = expired();
    }
    if ($expired) {
        $str = '<div class="card-header">
        <h3 class="font-weight-light mt-4 text-center" id="primarylabel">Session Error!</h3>
        <p class="font-weight-light mt-4 text-center">The session has expired or invalid.</p>
    </div>

    <div class="card-footer text-center py-3">
        <div class="small"><a href="../login/">Go back.</a></div>
    </div>
';
    } else {
        $_SESSION['otp_used'] = true;
        $str = '<div class="card-header"><h3 class="text-center font-weight-light my-4">Reset Your Password</h3></div>
        <div class="card-body">
    
                <div class="alert alert-danger" style="text-align:center" role="alert" id="alert" hidden>

                </div>
                <label for="inputPassword">New Password</label>
                <div class="form-floating mb-3">

                    <div class="mb-3">
                        <div class="input-group">

                            <input class="form-control" id="pass" type="password" placeholder="Type your new password" name="pass" required/>

                            <span class="input-group-append">
                                <button class="btn ms-n4" type="button"
                                    onclick="toggle_pass(`tpass`,`pass`)">
                                    <i id="tpass" class="bi-eye-fill"></i>
                                </button>
                            </span>
                        </div>
                        <small id="emp1" style="color: red;" hidden>This field cannot be empty!</small>

                    </div>


                    <!-- <input class="form-control" id="email" type="email" placeholder="name@example.com" name="email"/> -->

                </div>
                <label for="inputPassword">Confirm Password</label>
                <div class="form-floating mb-3 mt-2">

                    <div class="mb-3">
                        <div class="input-group">

                            <input class="form-control" id="conpass" type="password" placeholder="Confirm your password" name="conpass" required/>

                            <span class="input-group-append">
                                <button class="btn ms-n4" type="button"
                                    onclick="toggle_pass(`contpass`,`conpass`)">
                                    <i id="contpass" class="bi-eye-fill"></i>
                                </button>
                            </span>
                        </div>
                        <small id="emp2" style="color: red;" hidden>This field cannot be empty!</small>

                    </div>

                </div>
             
                <div class="d-flex align-items-center justify-content-center mt-4 mb-0">
                    <button class="btn btn-success" type="button" onclick="submit();">Reset Your Password</button>
                </div>
  
        </div>
';
    }
    return $str;
}
