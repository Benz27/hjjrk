<?php


function get_phone($link, $user_id)
{
    $sql = "SELECT phone FROM info where user_id=$user_id";
    $result = mysqli_query($link, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        return $row['phone'];
    }
}

function get_name($link, $user_id)
{
    $sql = "SELECT fname,mname, lname FROM info where user_id=$user_id";
    $result = mysqli_query($link, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        return $row['fname'] . ' ' . $row['mname'] . ' ' . $row['lname'];
    }
}

function get_phone_arc($link, $user_id)
{
    $sql = "SELECT phone FROM info_arc where user_id=$user_id";
    $result = mysqli_query($link, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        return $row['phone'];
    }
}

function get_name_arc($link, $user_id)
{
    $sql = "SELECT fname,mname, lname FROM info_arc where user_id=$user_id";
    $result = mysqli_query($link, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        return $row['fname'] . ' ' . $row['mname'] . ' ' . $row['lname'];
    }
}


function get_arrv_data($link, $a_id, $arc)
{
    $table = "arrivals";
    if ($arc == 1) {
        $table = "arrivals_archives";
    }

    $sql = "SELECT * FROM $table where a_id=$a_id";
    $result = mysqli_query($link, $sql);
    $array = array();
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        array_push($array, $row['dte']);
        array_push($array, $row['submitted']);
        array_push($array, $row['status']);
        return json_encode($array);
    }
}


function get_phone_admin($link, $user_id)
{
    $sql = "SELECT phone FROM admin_info where user_id=$user_id";
    $result = mysqli_query($link, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        return $row['phone'];
    }
}

function get_name_admin($link, $user_id)
{
    $sql = "SELECT fname, lname FROM admin_info where user_id=$user_id";
    $result = mysqli_query($link, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        return $row['fname'] . ' ' . $row['lname'];
    }
}

function sql_query_get_data($link, $query, $return_data, $encoded)
{
    $sql = $query;
    $result = mysqli_query($link, $sql);
    $return_array=explode(", ",$return_data);


    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        $data_to_return=array();
        foreach($return_array as $data){
            array_push($data_to_return,$row[$data]);
        }
        if($encoded){
            return json_encode($data_to_return);
        }
        return implode(" ",$data_to_return);
    }
}


function get_bday_admin($link, $user_id)
{
    $sql = "SELECT bday FROM admin_info where user_id=$user_id";
    $result = mysqli_query($link, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        return $row['bday'];
    }
}
function get_admin_type($link)
{
    // $sql = "SELECT usertype FROM admin where user_id=$_SESSION[admin_id]";
    // $result = mysqli_query($link, $sql);

    // if ($result && mysqli_num_rows($result) > 0) {
    //     $row = mysqli_fetch_array($result);
    //     echo $row['usertype'];
    // }

    echo $_SESSION['usertype'];
}


function get_bday($link, $user_id)
{
    $sql = "SELECT bday FROM info where user_id=$user_id";
    $result = mysqli_query($link, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        return $row['bday'];
    }
}

function get_bday_arc($link, $user_id)
{
    $sql = "SELECT bday FROM info_arc where user_id=$user_id";
    $result = mysqli_query($link, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        return $row['bday'];
    }
}

function print_hsf_today($link,$ut)
{
    $arc = false;
    $utype="AND `user_id` IN (SELECT `user_id` from `user` where `usertype` = $ut)";
    $table = "ans_sheets";
    $arc_href = "";

    if (isset($_GET['arc'])) {
        $table = "ans_sheets_archives";
        $utype="AND `usertype` = $ut";
        $arc = true;
        $arc_href = "&arc=true";
    }

    if($ut==-1){
        $utype="";
        $utype_str="(School Employee and Student)";
    }else if($ut==0){
        $utype_str="(School Employee)";

    }else if($ut==1){
        $utype_str="(Student)";
    }
    $str='';
    $sql = "SELECT * FROM $table WHERE `dte` <= CONCAT(CURRENT_DATE, ' 23:59:59') and `dte` >= CONCAT(CURRENT_DATE, ' 00:00:00') $utype";
    $result = mysqli_query($link, $sql);
    date_default_timezone_set('Asia/Manila');
    $time=date("M j, Y");
    $str = '
 <!DOCTYPE html>
  <html>
  <head>
  <style>
  table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
  }
  
  td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
  }
  
  tr:nth-child(even) {
  background-color: #dddddd;
  }
  </style>
  </head>
  <body>
      <div id="content">
  
      <h2>Health Status Form Submissions to St. Michael School on '.$time.'</h2>
      <h4>'.$utype_str.'</h4>
      <table>
  <tr>
  <th>Submit ID</th>
  <th>User ID</th>
  <th>User</th>
  <th>Usertype</th>
  <th>Submitted</th>
  <th>Status</th>

  </tr>';
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $arrv_data = json_decode(get_arrv_data($link, $row['ans_id'], $arc));
            $style = "text-decoration: none;cursor:pointer;";
            $class = "text-dark font-weight-bold";
            $href = "record.html?a_id=" . $row['ans_id'] . $arc_href;
            $dte = new DateTime($arrv_data[0]);
            $subm = new DateTime($arrv_data[1]);
            $stat = "Pending";
            $stat_class = "text-info font-weight-bold";
            if ($arrv_data[2] == 1) {
                $stat = "Confirmed";
                $stat_class = "text-success font-weight-bold";
            } else if ($arrv_data[2] == -1) {
                $stat = "Denied";
                $stat_class = "text-danger font-weight-bold";
            }

            if (isset($_GET['arc'])) {
                $name = $row['fname'] . ' ' . $row['mname'] . ' ' . $row['lname'];
                $usertype = get_usertype_str($row['usertype']);
            } else {
                $name = get_name($link, $row['user_id']);
                $usertype = get_usertype($link, $row['user_id']);
            }
            $dte = new DateTime($row['dte']);
            $str.= '<tr>
                        <td><p style="' . $style . '">' . $row['ans_id'] . '</p></td> 
                        <td><p style="' . $style . '">' . $row['user_id'] . '</p></td> 
                        <td><p style="' . $style . '">' . $name . '</p></td>
                        <td><a style="' . $style . '">' . $usertype . '</a></td>
                        <td><a style="' . $style . '">' . date_format($dte, "M j, Y")  . '</a></td>
                        <td><a style="' . $style . '">' . $stat . '</a></td>
                </tr>';
        }
    }
    $str .= '</table></div></body>
    </html>';
    return $str;
}


function print_users_today($link)
{   
    $sql = "SELECT * FROM `user` WHERE `dte` <= CONCAT(CURRENT_DATE, ' 23:59:59') and `dte` >= CONCAT(CURRENT_DATE, ' 00:00:00')";
    $result = mysqli_query($link, $sql);
    date_default_timezone_set('Asia/Manila');
    $time=date("M j, Y");
    $str = '
 <!DOCTYPE html>
  <html>
  <head>
  <style>
  table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
  }
  
  td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
  }
  
  tr:nth-child(even) {
  background-color: #dddddd;
  }
  </style>
  </head>
  <body>
      <div id="content">
  
      <h2>Users registered of St. Michael School on '.$time.'</h2>
      <table>
  <tr>
      <th>User ID</th>
      <th>Name</th>
      <th>Phone</th>
      <th>Email</th>
      <th>Birth Date</th>
      <th>Usertype</th>
  </tr>';
    if ($result && mysqli_num_rows($result) > 0) {
  
      while ($row = mysqli_fetch_array($result)) {
  
        $usertype = "School Employee";
        if ($usertype == 1) {
          $usertype = "Student";
        }
  
        $bday = new DateTime(get_bday($link, $row['user_id']));
        $dte = new DateTime($row['dte']);
        $str .= '<tr>
                      <td>' . $row['user_id'] . '</td> 
                      <td>' . get_name($link, $row['user_id']) . '</td>
                      <td>' . get_phone($link, $row['user_id']) . '</td>
                      <td>' . $row['email'] . '</td>
                      <td>' . date_format($bday, "M j, Y") . '</td>
                      <td>' . $usertype . '</td>
                  </tr>';
      }
     
    }
    $str .= '</table></div></body>
    </html>';
    return $str;
  
}

function get_users($link, $ut)
{   
    $sql = "SELECT * FROM user where usertype = $ut";
    $result = mysqli_query($link, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {

            $style = "text-decoration: none;";
            $onclick = "edit_user.html?id=" . $row['user_id'];
            $password='';
            $anc='<a href="view_user.html?id=' . $row['user_id'] . '" style="text-decoration:none;" class="text-primary">';
            $cl_anc='</a>';

            for($i=0;$i < strlen($row['password']);$i++){
                $password.='*';
            }

            $bday = new DateTime(sql_query_get_data($link,"SELECT bday from info WHERE user_id=$row[user_id]",'bday',false));
            echo '<tr id="' . $row['user_id'] . '" style="cursor:pointer;">
                    <td id="td[user_id]:' . $row['user_id'] . '" name="td_save">' . $row['user_id'] . '</td> 
                    <td>' .$anc. sql_query_get_data($link,"SELECT fname, lname from info WHERE user_id=$row[user_id]",'fname, lname',false) .$cl_anc. '</td>
                    <td>' .$anc. sql_query_get_data($link,"SELECT phone from info WHERE user_id=$row[user_id]",'phone',false) .$cl_anc. '</td>
                    <td>' .$anc. $row['email'] .$cl_anc. '</td>
                    <td>' .$anc. $password .$cl_anc. '</td>
                    <td>' .$anc. date_format($bday, "M j, Y") .$cl_anc. '</td>  
                    <td> <button class="me-3 border border-0" onclick="chnge_link(`edit_user_info.html?id=' . $row['user_id'] . '`)"
                    id="updt"><i class="fas fa-fw fa-edit"></i></button>
                <button class="me-3 border border-0" onclick="setselected(' . $row['user_id'] . ')" data-toggle="modal" data-target="#modal"
                    id="del"><i class="fas fa-fw fa-archive"></i></button></td>
                </tr>';
        }
    }
    //     echo '<tr id="row[' . $row['user_id'] . ']" class="">
    //     <td><a class="text-dark" style="' . $style . '">' . $row['user_id'] . '</a></td> 
    //     <td><a class="text-dark" style="' . $style . '">' . get_name($link, $row['user_id']) . '</a></td>
    //     <td><a class="text-dark" style="' . $style . '">' . get_phone($link, $row['user_id']) . '</a></td>
    //     <td><a class="text-dark" style="' . $style . '">' . $row['email'] . '</a></td>
    //     <td><a class="text-dark" style="' . $style . '">' . $row['password'] . '</a></td>
    //     <td><a class="text-dark" style="' . $style . '">' . date_format($bday, "M j, Y") . '</a></td>
    //     <td><a href="' . $onclick . '"><i class="fa fa-edit"></i></a></td>
    // </tr>';
}
function get_users_arc($link, $ut)
{   
    $sql = "SELECT * FROM user_arc where usertype = $ut";
    $result = mysqli_query($link, $sql);


    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {

            $style = "text-decoration: none;";
            $onclick = "edit_user.html?id=" . $row['user_id'];
            $anc='<a href="view_user.html?id=' . $row['user_id'] . '&arc=true" style="text-decoration:none;" class="text-primary">';
            $cl_anc='</a>';
            $password='';
            for($i=0;$i < strlen($row['password']);$i++){
                $password.='*';
            }

            $bday = new DateTime(sql_query_get_data($link,"SELECT bday from info_arc WHERE user_id=$row[user_id]",'bday',false));
            echo '<tr id="' . $row['user_id'] . '" style="cursor:pointer;">
                    <td>' .$anc. $row['user_id'] .$cl_anc. '</a></td> 
                    <td>' .$anc. sql_query_get_data($link,"SELECT fname, lname from info_arc WHERE user_id=$row[user_id]",'fname, lname',false) .$cl_anc. '</td>
                    <td>' .$anc. sql_query_get_data($link,"SELECT phone from info_arc WHERE user_id=$row[user_id]",'phone',false) .$cl_anc. '</td>
                    <td>' .$anc. $row['email'] .$cl_anc. '</td>
                    <td>' .$anc. $password .$cl_anc. '</td>
                    <td>' .$anc. date_format($bday, "M j, Y") .$cl_anc. '</td>
                </tr>';
        }
    }
}

function get_admins($link)
{

    $sql = "SELECT * FROM admin where usertype > 0";
    $result = mysqli_query($link, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {

            $style = "text-decoration: none;";
            $onclick = "edit_user.html?id=" . $row['user_id'];
            $anc='<a href="view_admin.html?id=' . $row['user_id'] . '" style="text-decoration:none;" class="text-primary">';
            $cl_anc='</a>';
            $password='';
            for($i=0;$i < strlen($row['password']);$i++){
                $password.='*';
            }

            $bday = new DateTime(sql_query_get_data($link,"SELECT bday from admin_info WHERE user_id=$row[user_id]",'bday',false));
            echo '<tr id="' . $row['user_id'] . '" style="cursor:pointer;">
                    <td>' .$anc. $row['user_id'] .$cl_anc. '</td> 
                    <td>' .$anc. sql_query_get_data($link,"SELECT fname, lname from admin_info WHERE user_id=$row[user_id]",'fname, lname',false) .$cl_anc. '</td>
                    <td>' .$anc. sql_query_get_data($link,"SELECT phone from admin_info WHERE user_id=$row[user_id]",'phone',false) .$cl_anc. '</td>
                    <td>' .$anc. $row['email'] .$cl_anc. '</td>
                    <td>' .$anc. $password .$cl_anc. '</td>
                    <td>' .$anc. date_format($bday, "M j, Y") .$cl_anc. '</td>
                    <td> <button class="me-3 border border-0" onclick="chnge_link(`edit_admin_info.html?id=' . $row['user_id'] . '`)"
                    id="updt"><i class="fas fa-fw fa-edit"></i></button>
                <button class="me-3 border border-0" onclick="setselected(' . $row['user_id'] . ')" data-toggle="modal" data-target="#modal"
                    id="del"><i class="fas fa-fw fa-archive"></i></button></td>

                   
                </tr>';
        }
    }
}

function get_admins_arc($link)
{

    $sql = "SELECT * FROM admin_arc where usertype > 0";
    $result = mysqli_query($link, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {

            $style = "text-decoration: none;";
            $onclick = "edit_user.html?id=" . $row['user_id'];
            $anc='<a href="view_admin.html?id=' . $row['user_id'] . '&arc=true" style="text-decoration:none;" class="text-primary">';
            $cl_anc='</a>';
            $bday = new DateTime(sql_query_get_data($link,"SELECT bday from admin_info_arc WHERE user_id=$row[user_id]",'bday',false));
            echo '<tr id="' . $row['user_id'] . '" style="cursor:pointer;">
                    <td>' .$anc. $row['user_id'] .$cl_anc. '</td> 
                    <td>' .$anc. sql_query_get_data($link,"SELECT fname, lname from admin_info_arc WHERE user_id=$row[user_id]",'fname, lname',false) .$cl_anc. '</td>
                    <td>' .$anc. sql_query_get_data($link,"SELECT phone from admin_info_arc WHERE user_id=$row[user_id]",'phone',false) .$cl_anc. '</td>
                    <td>' .$anc. $row['email'] .$cl_anc. '</td>
                    <td>' .$anc. $row['password'] .$cl_anc. '</td>
                    <td>' .$anc. date_format($bday, "M j, Y") . $cl_anc.'</td>
                </tr>';
        }
    }
}
function get_arrivals($link)
{

    $sql = "SELECT * FROM arrivals";
    $result = mysqli_query($link, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {

            $style = "text-decoration: none;cursor:pointer;";
            $stat = $row['status'];
            $class = "text-primary font-weight-bold";
            $f_color = "info";
            $href = "arrival_req.html?a_id=" . $row['a_id'];
            switch ($row['status']) {
                case 0:
                    $stat = "Pending";
                    break;
                case 1:
                    $stat = "Confirmed";
                    $f_color = "success";
                    break;
                case -1:
                    $stat = "Denied";
                    $f_color = "danger";
                    break;
            }
            $stat_class = "text-" . $f_color . " font-weight-bold";

            $dtev = new DateTime(get_bday($link, $row['user_id']));
            echo '<tr>
                        <td><a href="' . $href . '" class="' . $class . '" style="' . $style . '">' . $row['a_id'] . '</a></td> 
                        <td><a href="' . $href . '" class="' . $class . '" style="' . $style . '">' . $row['user_id'] . '</a></td> 
                        <td><a href="' . $href . '" class="' . $class . '" style="' . $style . '">' . get_name($link, $row['user_id']) . '</a></td>
                        <td><a href="' . $href . '" class="' . $class . '" style="' . $style . '">' . get_usertype($link, $row['user_id']) . '</a></td>
                        <td><a href="' . $href . '" class="' . $class . '" style="' . $style . '">' . $row['dept'] . '</a></td> 
                        <td><a href="' . $href . '" class="' . $class . '" style="' . $style . '">' . date_format($dtev, "M j, Y") . '</a></td>
                        <td><a href="' . $href . '" class="' . $stat_class . '" style="' . $style . '">' . $stat . '</a></td> 
                </tr>';
        }
    }
}
function get_arc_arrivals($link)
{

    $sql = "SELECT * FROM arrivals_archives";
    $result = mysqli_query($link, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {

            $style = "text-decoration: none;cursor:pointer;";
            $stat = $row['status'];
            $class = "text-primary font-weight-bold";
            $f_color = "info";
            $href = "arc_arrival_req.html?a_id=" . $row['a_id'];
            switch ($row['status']) {
                case 0:
                    $stat = "Pending";
                    break;
                case 1:
                    $stat = "Confirmed";
                    $f_color = "success";
                    break;
                case -1:
                    $stat = "Denied";
                    $f_color = "danger";
                    break;
            }
            $stat_class = "text-" . $f_color . " font-weight-bold";

            $dtev = new DateTime(get_bday($link, $row['user_id']));
            echo '<tr>
                        <td><a href="' . $href . '" class="' . $class . '" style="' . $style . '">' . $row['a_id'] . '</a></td> 
                        <td><a href="' . $href . '" class="' . $class . '" style="' . $style . '">' . $row['user_id'] . '</a></td> 
                        <td><a href="' . $href . '" class="' . $class . '" style="' . $style . '">' . get_name($link, $row['user_id']) . '</a></td>
                        <td><a href="' . $href . '" class="' . $class . '" style="' . $style . '">' . get_usertype($link, $row['user_id']) . '</a></td>
                        <td><a href="' . $href . '" class="' . $class . '" style="' . $style . '">' . $row['dept'] . '</a></td> 
                        <td><a href="' . $href . '" class="' . $class . '" style="' . $style . '">' . date_format($dtev, "M j, Y") . '</a></td>                </tr>';
        }
    }
}

function get_hsf($link,$ut)
{
    $arc = false;
    $table = "ans_sheets WHERE `user_id` IN (SELECT `user_id` from `user` where `usertype` = $ut) ORDER BY `dte` DESC";
    $arc_href = "";
    if (isset($_GET['arc'])) {
        $table = "ans_sheets_archives WHERE `usertype` = $ut";
        $arc = true;
        $arc_href = "&arc=true";
    }
    $sql = "SELECT * FROM $table";
    $result = mysqli_query($link, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $arrv_data = json_decode(get_arrv_data($link, $row['ans_id'], $arc));
            $style = "text-decoration: none;cursor:pointer;";
            $class = "text-dark font-weight-bold";
            $href = "record.html?a_id=" . $row['ans_id'] . $arc_href;
            // $dte = new DateTime($arrv_data[0]);
            $subm = new DateTime($arrv_data[1]);
            $dte = new DateTime($row['dte']);
            $stat = "Pending";
            $stat_class = "text-info font-weight-bold";
            if ($arrv_data[2] == 1) {
                $stat = "Confirmed";
                $stat_class = "text-success font-weight-bold";
            } else if ($arrv_data[2] == -1) {
                $stat = "Denied";
                $stat_class = "text-danger font-weight-bold";
            }

            if (isset($_GET['arc'])) {
                $name = $row['fname'] . ' ' . $row['mname'] . ' ' . $row['lname'];
                $usertype = get_usertype_str($row['usertype']);
            } else {
                $name = get_name($link, $row['user_id']);
                $usertype = get_usertype($link, $row['user_id']);
            }

            echo '<tr>
                        <td><a href="' . $href . '" class="' . $class . '" style="' . $style . '">' . $row['ans_id'] . '</a></td> 
                        <td><a href="' . $href . '" class="' . $class . '" style="' . $style . '">' . $row['user_id'] . '</a></td> 
                        <td><a href="' . $href . '" class="' . $class . '" style="' . $style . '">' . $name . '</a></td>
                        <td><a href="' . $href . '" class="' . $class . '" style="' . $style . '">' . $usertype . '</a></td>
                        <td><a href="' . $href . '" class="' . $class . '" style="' . $style . '">' . date_format($dte, "M j, Y")  . '</a></td>
                        <td><a href="' . $href . '" class="' . $stat_class . '" style="' . $style . '">' . $stat . '</a></td>
                </tr>';
        }
    }
}

function decline_arr($link, $a_id)
{
    $sql = "UPDATE arrivals SET status = -1 WHERE a_id=$a_id";
    if ($link->query($sql) === TRUE) {
        echo 1;
    } else {
        echo 'delete error: ' . $link->error;
    }
}

function confirm_arr($link, $a_id)
{

    $sql = "UPDATE arrivals SET status = 1 WHERE a_id=$a_id";
    if ($link->query($sql) === TRUE) {
        echo 1;
    } else {
        echo 'delete error: ' . $link->error;
    }
}

function delete_both($link, $a_id, $form)
{

    delete_hsf($link, $a_id);
    delete_arr($link, $a_id);


    header("Location: ../record_list.html");
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

function health_tips_mod($link, $ht)
{

    $sql = "UPDATE health_tips SET health_tips = '$ht'";
    if ($link->query($sql) === TRUE) {
        echo 1;
    } else {
        echo 'delete error: ' . $link->error;
    }
}

function school_updates($link, $sp)
{

    $sql = "UPDATE school_updates SET school_update = '$sp'";
    if ($link->query($sql) === TRUE) {
        echo 1;
    } else {
        echo 'delete error: ' . $link->error;
    }
}
function get_question($link, $q_id)
{
    $sql = "SELECT * FROM questions where q_id = $q_id";
    $result = mysqli_query($link, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        return $row['question'];
    }
}

function get_usertype($link, $user_id)
{
    $sql = "SELECT usertype FROM user where user_id=$user_id";
    $result = mysqli_query($link, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        $utype = $row['usertype'];
        if ($utype == 0) {
            return "School Employee";
        }
        if ($utype == 1) {
            return "Student";
        }
        return "Visitor";
    }
}
function get_usertype_str($utype)
{
    if ($utype == 0) {
        return "School Employee";
    }
    if ($utype == 1) {
        return "Student";
    }
    return "Visitor";
}


function get_data($link, $id)
{

    $sql = "SELECT * FROM arrivals where a_id=$id";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_array($result);

    $dte = new DateTime($row['dte']);
    $subm = new DateTime($row['submitted']);

    return '<p class="strong mb-2">User ID:' . $row['user_id'] . '</p>
        <p class="strong mb-2">User: ' . get_name($link, $row['user_id']) . '</p>
        <p class="strong mb-2">Department to visit: ' . $row['dept'] . '</p>
        <p class="strong mb-2">Date of visit: ' . date_format($dte, "M j, Y") . '</p>
        <p class="strong mb-2">Date requested: ' . date_format($subm, "M j, Y") . '</p>
        <br>
        <p class="strong mb-2">Reason for visit</p>
        <textarea id="reason" name="" rows="5" cols="130" readonly>' . $row['reason'] . '</textarea>';
}


function get_button($link, $id, $arc)
{

    if ($arc == 1) {
        return '<a class="text-info" style="text-decoration:none;">Archived</a>';
    }

    $sql = "SELECT status FROM arrivals where a_id=$id";
    $result = mysqli_query($link, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        if ($row['status'] != 0) {
            return '<a data-toggle="modal" data-target="#delmodal" class="text-danger" style="cursor:pointer;text-decoration:none;">Archive</a>';
        }
    }

    return '<span class="text-info" onclick="stat(' . $id . ',1)" style="cursor:pointer;">Confirm</span> | <span class="text-warning" onclick="stat(' . $id . ',-1)" style="cursor:pointer;">Deny</span>';
}


function get_stat($link, $a_id)
{
    $sql = "SELECT status FROM arrivals where a_id=$a_id";
    $result = mysqli_query($link, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        if ($row['status'] < 0) {
            return 'Canceled';
        }
        if ($row['status'] > 0) {
            return 'Confirmed';
        }
        return 'Pending';
    }
}



function get_arrv_form($link, $a_id)
{


    echo '<div id="crt"><div class="pb-5">
        <div class="container">
          <div class="row">
    
            <div class="col-md-12">
                <div class="card border-0 ">
                    <div class="row mt-4">
                    
    
                        
                        <div class="col-12">
                            <p class="strong mb-2">REQUEST ID: ' . $a_id . '<span class="strong mb-2" style="float:right;">' . get_stat($link, $a_id) . '</span></p>
    
                            <hr class="mt-0">
                        </div>
                        <div class="col-12">
                        ' . get_data($link, $a_id) . '

                        <hr class="mt-0">
                        </div>
                        
                        <div class="col-12">
                        <p class="strong mb-2"><span class="strong mb-2">' . get_button($link, $a_id) . '</span></p>
    
                        <hr class="mt-0">
                </div>
    
    
                        
                    </div>
                    
                </div>
            </div>
    
              </div>
            
            </div>';
}


function get_hsf_head_data($link, $id, $arc)
{
    $table = "ans_sheets";
    $table2 = "arrivals";

    if ($arc == 1) {
        $table = "ans_sheets_archives";
        $table2 = "arrivals_archives";
    }

    $sql = "SELECT * FROM $table where ans_id=$id";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_array($result);

    if ($arc == 1) {
        $name = $row['fname'] . ' ' . $row['mname'] . ' ' . $row['lname'];
        $usertype = get_usertype_str($row['usertype']);
    } else {
        $name = get_name($link, $row['user_id']);
        $usertype = get_usertype($link, $row['user_id']);
    }


    $head = '<p class="strong mb-2">User ID: ' . $row['user_id'] . '</p>
    <p class="strong mb-2">User: ' . $name . '</p>
    <p class="strong mb-2">Usertype: ' . $usertype . '</p>';

    $sql = "SELECT * FROM $table2 where a_id=$id";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_array($result);

    $stat = '<p class="strong mb-2">Form Status: <span class="text-info">Pending</span></p>';
    if ($row['status'] == 1) {
        $stat = '<p class="strong mb-2">Form Status: <span class="text-success">Confirmed</span></p>';
    } else if ($row['status'] == -1) {
        $stat = '<p class="strong mb-2">Form Status: <span class="text-danger">Denied</span></p>';
    }
    return $stat . $head;
}


function get_arc_hsf_head_data($link, $id)
{

    $sql = "SELECT * FROM ans_sheets_archives where ans_id=$id";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_array($result);


    return '<p class="strong mb-2">User ID: ' . $row['user_id'] . '</p>
        <p class="strong mb-2">User: ' . get_name($link, $row['user_id']) . '</p>
        <p class="strong mb-2">Usertype: ' . get_usertype($link, $row['user_id']) . '</p>';
}
function get_hsf_head($link, $a_id, $arc)
{
    $table = "arrivals";
    if ($arc == 1) {
        $table = "arrivals_archives";
    }

    $sql = "SELECT * FROM $table where a_id=$a_id";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_array($result);

    $dte = new DateTime($row['dte']);
    $subm = new DateTime($row['submitted']);

    $head = '<div class="card shadow m-3">            
    <div class="card-header py-3 ps-3 pe-3">
    <p class="font-weight-bold text-primary">Arrival Information</p>
</div>
<div class="col-12 mt-3 ps-3 pe-3">
<p class="strong mb-2">Department to visit: ' . $row['dept'] . '</p>
    <p class="strong mb-2">Date of visit: ' . date_format($dte, "M j, Y") . '</p>
    <p class="strong mb-2">Date submitted: ' . date_format($subm, "M j, Y") . '</p>
    <br>
    <p class="strong mb-2">Reason for visit</p>
    <textarea id="reason" class="form-control mb-3" name="" rows="5" cols="130" readonly>' . $row['reason'] . '</textarea>
    </div>
    </div>';

    return '          
<div class="col-12 mt-3 ps-3 pe-3">
    <p class="strong">FORM ID: ' . $a_id . '<span id="con_den_form" class="strong me-2" style="float:right;">' . get_button($link, $a_id, $arc) . '</span></p>

    <hr class="mt-0">
</div>
<div class="col-12 mt-1 ps-3 pe-3">
                    ' . get_hsf_head_data($link, $a_id, $arc) . '
                        <hr class="mt-0">
            </div>
            ';
}

function get_arc_hsf_head($link, $a_id)
{

    return '<div class="col-12 mt-3">
       <p class="strong">FORM ID: ' . $a_id . '<span class="strong me-2" style="float:right;"><a class="text-info" style="text-decoration:none;">Archived</a></span></p>
   
       <hr class="mt-0">
   </div>
   <div class="col-12 mt-1">
                       ' . get_arc_hsf_head_data($link, $a_id) . '
                           <hr class="mt-0">
                           
               </div>
              ';
}

function get_hsf_rec($link, $a_id, $arc)
{


    $table = "ans_sheets";
    if ($arc == 1) {
        $table = "ans_sheets_archives";
    }

    $st = get_hsf_head($link, $a_id, $arc);

    $sql = "SELECT * FROM $table  where ans_id = $a_id";
    $result = mysqli_query($link, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        $g_ids = json_decode($row['g_ids']);
        $qst_ids = json_decode($row['qst_ids']);
        $obj = json_decode($row['object_str'], true);
        $st .= '<div class="card shadow m-3">            
        <div class="card-header py-3 ps-3 pe-3">
        <p class="font-weight-bold text-primary">Health Status Information</p>
</div>';
        for ($x = 0; $x < count($g_ids); $x++) {

            $st .= '
            <div class="card shadow m-3">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">' . $obj[$g_ids[$x]]["name"] . '</h6>
            </div>
            <div class="card-body">';
            for ($y = 0; $y < count($qst_ids[$x]); $y++) {
                $type = $obj[$g_ids[$x]]["items"][$qst_ids[$x][$y]]["type"];
                $labels = $obj[$g_ids[$x]]["items"][$qst_ids[$x][$y]]["labels"];
                $values = $obj[$g_ids[$x]]["items"][$qst_ids[$x][$y]]["values"];
                $ans = $obj[$g_ids[$x]]["items"][$qst_ids[$x][$y]]["ans"];
                $required = $obj[$g_ids[$x]]["items"][$qst_ids[$x][$y]]["required"];
                $req_str = '';
                $st .= '
                <div class="table-responsive">
                    <table class="table">';
                if ((bool)$required) {
                    $req_str = '<span style="color:red;">*</span> ';
                }


                if ($type == "radio") {
                    if ((int)$ans[0] == -1) {
                        $rad_ans = '<i>No answer</i>';
                    } else {
                        $rad_ans = $labels[(int)$ans[0]];
                    }




                    $st .= '<thead class="bg-secondary text-white">
<tr>
  <th scope="col" style="width: 70%;">Question</th>
  <th scope="col">Answer</th>

</tr>
</thead>
<tbody>
<tr>
<th scope="row">' . $req_str . $obj[$g_ids[$x]]["items"][$qst_ids[$x][$y]]["string"] . '</th>
<td>' . $rad_ans . '</td></tr></tbody>';

                    // class="thead-dark"
                }




                if ($type == "cbox") {

                    $st .= '<thead class="bg-dark text-white">
                    <tr>
                      <th colspan="2">' . $req_str . $obj[$g_ids[$x]]["items"][$qst_ids[$x][$y]]["string"] . '</th>
                    </tr>
                  </thead>
                  <thead class="bg-secondary text-white">
<tr>
  <th scope="col" style="width: 70%;">Options</th>
  <th scope="col">Answer</th>

</tr>
</thead>
<tbody>
';


                    for ($z = 0; $z < count($labels); $z++) {


                        $st .= '<tr>
                        <th scope="row">' . $obj[$g_ids[$x]]["items"][$qst_ids[$x][$y]]["labels"][$z] . '</th>';
                        if ($ans[$z] == 1) {
                            $st .= '<td><i class="fas fa-check-square fa-sm fa-fw mr-2"></i></td>';
                        } else {
                            $st .= '<td><i class="fas fa-square fa-sm fa-fw mr-2"></i></td>';
                        }

                        $st .= '</tr>';
                    }



                    $st .= '</tbody>';
                }



                if ($type == "text") {

                    $st .= '<thead class="bg-dark text-white">
                    <tr>
                      <th colspan="2">' . $req_str . $obj[$g_ids[$x]]["items"][$qst_ids[$x][$y]]["string"] . '</th>
                    </tr>
                  </thead>
                  <thead class="bg-secondary text-white">
<tr>
  <th scope="col" style="width: 70%;">Questions</th>
  <th scope="col">Answer</th>

</tr>
</thead>
<tbody>
';


                    for ($z = 0; $z < count($labels); $z++) {


                        $st .= '<tr>
                        <th scope="row">' . $obj[$g_ids[$x]]["items"][$qst_ids[$x][$y]]["labels"][$z] . '</th>
                        <td>' . $obj[$g_ids[$x]]["items"][$qst_ids[$x][$y]]["ans"][$z] . '</td>';
                        $st .= '</tr>';
                    }



                    $st .= '</tbody>';
                }



                $st .= '
</table>
</div>';
            }

            $st .= '
  </div>
</div>';
        }

        $st .= '
  </div>';
    }

    echo $st;
}










function get_q_sheet_ids($link)
{
    $sql = "SELECT * FROM q_sheets where q_id=1111111";
    $result = mysqli_query($link, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        $arr = array();

        $dec_g_ids = json_decode($row['g_ids']);
        $dec_qst_ids = json_decode($row['qst_ids']);
        $dec_object = json_decode($row['object_str']);

        array_push($arr, $row['q_id']);
        array_push($arr, json_encode($dec_g_ids));
        array_push($arr, json_encode($dec_qst_ids));
        array_push($arr, json_encode($dec_object));

        echo json_encode($arr);
        // return json_encode($dec_object);
    }
}
function save_q_sheet($link)
{
    $sql = "UPDATE q_sheets SET g_ids='$_POST[gp_ids]', qst_ids='$_POST[qst_ids]', object_str='$_POST[object_str]' WHERE q_id = $_POST[q_id]";
    if ($link->query($sql) === TRUE) {
        echo 1;
    } else {
        echo $link->error;
    }
}
