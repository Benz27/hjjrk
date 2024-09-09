<?php


function get_phone($link, $user_id, $arc)
{$table="info";
    if((bool)$arc){
        $table="info_arc";
    }
    $sql = "SELECT phone FROM $table where user_id=$user_id";
    $result = mysqli_query($link, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        return $row['phone'];
    }
}

function get_name($link, $user_id, $arc)
{$table="info";
    if((bool)$arc){
        $table="info_arc";
    }
    $sql = "SELECT fname, lname FROM $table where user_id=$user_id";
    $result = mysqli_query($link, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        return $row['fname'] . ' ' . $row['lname'];
    }
}
function get_bday($link, $user_id, $arc)
{$table="info";
    if((bool)$arc){
        $table="info_arc";
    }
    $sql = "SELECT bday FROM $table where user_id=$user_id";
    $result = mysqli_query($link, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        return $row['bday'];
    }
}




function get_users($link, $ut, $arc)
{  $table="user";
    if((bool)$arc){
        $table="user_arc";
    }
    $sql = "SELECT * FROM $table where usertype = $ut";
    $result = mysqli_query($link, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {

            $style = "text-decoration: none;";
            $onclick = "edit_user.html?id=" . $row['user_id'];

            $bday = new DateTime(get_bday($link, $row['user_id'],$arc));
            echo '<tr>
                    <td><a class="text-dark" style="' . $style . '">' . $row['user_id'] . '</a></td> 
                    <td><a class="text-dark" style="' . $style . '">' . get_name($link, $row['user_id'],$arc) . '</a></td>
                    <td><a class="text-dark" style="' . $style . '">' . get_phone($link, $row['user_id'],$arc) . '</a></td>
                    <td><a class="text-dark" style="' . $style . '">' . $row['email'] . '</a></td>
                    <td><a class="text-dark" style="' . $style . '">' . $row['password'] . '</a></td>
                    <td><a class="text-dark" style="' . $style . '">' . date_format($bday, "M j, Y") . '</a></td>
                    <td><a href="' . $onclick . '"><i class="fa fa-edit"></i></a></td>
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

            $dtev = new DateTime(get_bday($link, $row['user_id'],false));
            echo '<tr>
                        <td><a href="' . $href . '" class="' . $class . '" style="' . $style . '">' . $row['a_id'] . '</a></td> 
                        <td><a href="' . $href . '" class="' . $class . '" style="' . $style . '">' . $row['user_id'] . '</a></td> 
                        <td><a href="' . $href . '" class="' . $class . '" style="' . $style . '">' . get_name($link, $row['user_id'],false) . '</a></td>
                        <td><a href="' . $href . '" class="' . $class . '" style="' . $style . '">' . $row['dept'] . '</a></td> 
                        <td><a href="' . $href . '" class="' . $class . '" style="' . $style . '">' . date_format($dtev, "M j, Y") . '</a></td>
                        <td><a href="' . $href . '" class="' . $stat_class . '" style="' . $style . '">' . $stat . '</a></td> 
                </tr>';
        }
    }
}


function get_hsf($link)
{
    $sql = "SELECT * FROM ans_table";
    $result = mysqli_query($link, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {

            $style = "text-decoration: none;cursor:pointer;";
            $class = "text-primary font-weight-bold";
            $href = "hst_subm.html?a_id=" . $row['a_id'];

            echo '<tr>
                        <td><a href="' . $href . '" class="' . $class . '" style="' . $style . '">' . $row['a_id'] . '</a></td> 
                        <td><a href="' . $href . '" class="' . $class . '" style="' . $style . '">' . $row['user_id'] . '</a></td> 
                        <td><a href="' . $href . '" class="' . $class . '" style="' . $style . '">' . get_name($link, $row['user_id'],false) . '</a></td>
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

function delete_arr($link, $a_id)
{
    if (archive_arr($link, $a_id));
    $sql = "DELETE FROM arrivals  WHERE a_id=$a_id";
    if ($link->query($sql) === TRUE) {
        header("Location: ../arrivals.html");
    } else {
        echo 'delete error: ' . $link->error;
    }
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
function get_hsf_rec($link, $a_id)
{
    $st = '';
    $q_arr = array([20], [1, 2, 3, 4, 5, 6, 7, 8], [11, 12, 13, 14, 15]);
    $q_type = array("text", "option", "option");
    $sql = "SELECT * FROM ans_table where a_id = $a_id";
    $result = mysqli_query($link, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);


        for ($x = 0; $x < count($q_arr); $x++) {
            $num = 1;
            $no = '';
            $st .= '<div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="width: 70%;">Questions</th>
                            <th>Answers</th>
                        </tr>
                    </thead>
                    <tbody>';
            for ($y = 0; $y < count($q_arr[$x]); $y++) {
                $ans = $row[strval($q_arr[$x][$y])];
                if ($q_type[$x] == "option") {
                    $no = $num . '. ';
                    $ans = "YES";
                    if ($row[strval($q_arr[$x][$y])] == 0) {
                        $ans = "NO";
                    }
                }
                $st .= '<tr>
                <td>' . $no . get_question($link, $q_arr[$x][$y]) . '</td> 
                <td>' . $ans . '</td> 
            </tr>';
                $num += 1;
            }
            $st .= '</tbody>
            </table>
        </div>
    </div>';
        }
    }

    echo $st;
}
