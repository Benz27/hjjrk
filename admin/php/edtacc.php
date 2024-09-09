<?php


session_start();
include("aconn.php");
include("read.php");
$x = $_GET['fun'];





switch ($x) {
    case "updt":
        updt($alink);
        break;
    case "chngpass":
        chngpass($alink);
        break;
        case "chngpass_me":
            chngpass_me($alink);
            break;
    case "delacc":
        delacc($alink);
        break;
    case "uidupdt":
        uidupdt($alink);
        break;
        case "updt_pfp":
            updt_pfp($alink);
            break;
}





function updt_pfp($link)
{

    $file_set = false;
    // $columns = json_decode($_POST['columns'], true);
    $values = json_decode($_POST['values'], true);
    // $tables = json_decode($_POST['tables'], true);
    // $types = json_decode($_POST['types'], true);

    // $query = "";
    $fle_name = $_POST['fle_name'];
    $user_id =  $_SESSION["admin_user_id"];
    if ($values[0] != "") {


        $structure = '../img/pfp/' . $user_id;
        if (!file_exists($structure)) {
            mkdir($structure, 0777, true);
        }





        $data = $values[0];

        list($type, $data) = explode(';', $data);
        list(, $data)      = explode(',', $data);
        $data = base64_decode($data);

        // $ext = str_replace("data:image/", ".", $type);
        $destdir = $structure . '/' . $fle_name;
        $files = glob($structure . '/');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }

        if (file_put_contents($destdir, $data)) {
            $file_set = true;
        };
    } else {
        $file_set = true;
    }
    if ($file_set) {
        $sql = "UPDATE admin_info SET pfp='$fle_name' WHERE user_id=$user_id";
        if ($link->query($sql) === TRUE) {
            $arr_info = array();
            $img='./img/pfp/'.$user_id.'/'.$fle_name;
            if($fle_name==""){
                $img='./img/empty.png';
            }

            array_push($arr_info, 1, $img);
            echo json_encode($arr_info);
        } else {
            echo "Error updating record: " . $link->error;
        }
    }













    // for ($x = 0; $x < count($columns); $x++) {
    //     if ($x != count($columns) - 1) {
    //         if ($types[$x] == "string" || $types[$x] == "date") {
    //             $query .= "$columns[$x]='$values[$x]',";
    //         } else {
    //             $query .= "$columns[$x]=$values[$x],";
    //         }
    //     } else {
    //         if ($types[$x] == "string" || $types[$x] == "date") {
    //             $query .= "$columns[$x]='$values[$x]'";
    //         } else {
    //             $query .= "$columns[$x]=$values[$x]";
    //         }
    //     }
    // }




    // $sql = "UPDATE $tables[0] set $query where user_id=$user_id";
    // if ($link->query($sql) === TRUE) {
    //     echo 1;
    // } else {
    //     echo "Error : " . $link->error;
    // }
}



function updt($alink)
{
    $link = $alink;

    $columns = json_decode($_POST['columns'], true);
    $values = json_decode($_POST['values'], true);
    $tables = json_decode($_POST['tables'], true);
    $types = json_decode($_POST['types'], true);

    $query = "";

    for ($x = 0; $x < count($columns) - 1; $x++) {
        if ($x != count($columns) - 2) {
            if ($types[$x] == "string" || $types[$x] == "date") {
                $query .= "$columns[$x]='$values[$x]',";
            } else {
                $query .= "$columns[$x]=$values[$x],";
            }
        } else {
            if ($types[$x] == "string" || $types[$x] == "date") {
                $query .= "$columns[$x]='$values[$x]'";
            } else {
                $query .= "$columns[$x]=$values[$x]";
            }
        }
    }

    $user_id =  $_POST['id'];

    if($tables[0]=="admin"){
        $sql = "UPDATE $tables[0] set email='$values[4]' where user_id=$user_id"; 
    }else{
        $sql = "UPDATE $tables[0] set email='$values[4]',usertype=$values[9] where user_id=$user_id";
    }

    if ($link->query($sql) === TRUE) {

        $sql = "UPDATE $tables[1] set $query where user_id=$user_id";
        if ($link->query($sql) === TRUE) {
            echo 1;
        } else {
            echo "Error (info): " . $link->error." query:".$query;
        }
    } else {

        echo "Error (user): " . $link->error;
    }
}


function chngpass($alink)
{
    $link = $alink;
    $ab_pass =  $_POST['pass'];
    $user_id =  $_POST['id'];
    $table = "user";
    if (isset($_GET['user_type'])) {
        $table = "admin";
    }
    $sql = "UPDATE $table set password='$ab_pass' where user_id=$user_id";
    if ($link->query($sql) === TRUE) {

        echo 1;
    } else {

        echo "Error : " . $link->error;
    }
}

function chngpass_me($link)
{

    $ab_pass =  $_POST['pass'];
    $currpass =  $_POST['currpass'];
    $user_id =  $_SESSION["admin_user_id"];


    $sql = "SELECT password FROM admin where user_id=$user_id";
    $result = mysqli_query($link, $sql);
    if ($result && mysqli_num_rows($result) > 0) {

        $user_data = mysqli_fetch_assoc($result);
        if ($user_data["password"] == $currpass) {
            $sql = "UPDATE admin set password='$ab_pass' where user_id=$user_id";

            if ($link->query($sql) === TRUE) {

                echo 1;
            } else {

                echo "Error : " . $link->error;
            }
        } else {
            echo 0;
        }
    }
}


function delacc($alink)
{
    $link = $alink;
    $table = "user";
   

    if (isset($_GET['me'])) {
        $id = $_SESSION['admin_user_id'];
    } else {
        $id = $_POST['id'];
        
    }

    if (isset($_GET['user_type'])) {
        $table = "admin";
        archive_admin($id,$link);
    }else{
        if(archive_user($id,$link)){
            del_all_hst($id,$link);
        }
    }

    $sql = "DELETE FROM $table WHERE user_id=$id";
    if ($link->query($sql) === TRUE) {
        echo 1;
    } else {
        echo 'delete error: ' . $link->error;
    }
}


function uidupdt($link)
{
    $id = $_POST['id'];
    $newid = $_POST['newid'];

    $sql="SELECT user_id FROM user where user_id=$newid"; 
    $result=mysqli_query($link, $sql);     
    if($result && mysqli_num_rows($result) > 0){      
        echo 0;
        return;
    };
    
    $sql = "UPDATE `user` SET `user_id`=$newid WHERE `user_id`=$id;";
    if ($link->query($sql) === TRUE) {
        echo 1;
    } else {
        echo 'Error at user: ' . $link->error;
    }
}



//hst and arr 


function del_all_hst($user_id,$link)
{

    $sql = "SELECT `ans_id` FROM `ans_sheets` WHERE `user_id`=$user_id;";
    $result = mysqli_query($link, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {


            delete_both($link, $row['ans_id']);


        }
    }
    
    return true;
}



function archive_user($user_id,$link){
    $sql = "INSERT INTO user_arc
    SELECT user.*, CURRENT_TIMESTAMP()
    FROM user
    WHERE user_id = $user_id;";
    if ($link->query($sql) === TRUE) {

        return archive_info($user_id,$link);
    } else {
        echo "Error on archive user:". $link->error;
        return false;
    }
}

function archive_info($user_id,$link){
    $sql = "INSERT INTO info_arc
    SELECT info.*, CURRENT_TIMESTAMP()
    FROM info
    WHERE user_id = $user_id;";
    if ($link->query($sql) === TRUE) {

        return true;
        
    } else {
        echo "Error on archive info:". $link->error;
        return false;
    }
}
function archive_admin($user_id,$link){
    $sql = "INSERT INTO admin_arc
    SELECT admin.*, CURRENT_TIMESTAMP()
    FROM admin
    WHERE user_id = $user_id;";
    if ($link->query($sql) === TRUE) {

        return archive_admin_info($user_id,$link);
    } else {
        echo "Error on archive admin:". $link->error;
        return false;
    }
}
function archive_admin_info($user_id,$link){
    $sql = "INSERT INTO admin_info_arc
    SELECT admin_info.*, CURRENT_TIMESTAMP()
    FROM admin_info
    WHERE user_id = $user_id;";
    if ($link->query($sql) === TRUE) {

        return true;
        
    } else {
        echo "Error on archive admin_info:". $link->error;
        return false;
    }
}
function delete_both($link, $a_id)
{

    delete_hsf($link, $a_id);
    delete_arr($link, $a_id);


    
}





function delete_hsf($link, $a_id)
{
    if (archive_hsf($link, $a_id));
    $sql = "DELETE FROM ans_sheets  WHERE ans_id=$a_id";
    if ($link->query($sql) === TRUE) {
        return true;
    }
    // echo 'delete error: ' . $link->error;
    return false;
}

function archive_hsf($link, $a_id)
{

    $sql = "INSERT INTO `ans_sheets_archives`
    SELECT `ans_sheets`.ans_id,`ans_sheets`.user_id,`info`.fname,
    `info`.lname,`info`.mname,`user`.usertype,`ans_sheets`.g_ids,`ans_sheets`.qst_ids,
    `ans_sheets`.object_str,`ans_sheets`.dte,
    CURRENT_TIMESTAMP()
    FROM `ans_sheets`,`info`,`user`
    WHERE `ans_sheets`.ans_id=$a_id and `info`.user_id=`ans_sheets`.user_id and `user`.user_id=`ans_sheets`.user_id;";
    if ($link->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

function delete_arr($link, $a_id)
{
    if (archive_arr($link, $a_id));
    $sql = "DELETE FROM arrivals  WHERE a_id=$a_id";
    if ($link->query($sql) === TRUE) {
        return true;
    }
    // echo 'delete error: ' . $link->error;
    return false;
}
function archive_arr($link, $a_id)
{

    $sql = "INSERT INTO arrivals_archives
    SELECT arrivals.*, CURRENT_TIMESTAMP()
    FROM arrivals
    WHERE a_id = $a_id;";
    if ($link->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}
