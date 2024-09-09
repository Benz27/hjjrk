<?php



include("aconn.php");
date_default_timezone_set("Asia/Manila");

$x = $_POST['fun'];

if ($x == "publish") {
    publish($_POST['q_id'], $_POST['type']);
} else if ($x == "un_publish") {
    un_publish($_POST['q_id']);
} else if ($x == "add_q") {
    add_q($_POST['qtn'], $_POST['type']);
} else if ($x == "del_q") {
    del_q($_POST['q_id']);
} else if ($x == "mod_q") {
    mod_q();
}

function publish($q_id, $type)
{
    $datatype = "int(1)";
    if ($type == "text") {
        $datatype = "varchar(150)";
    }
    $link = $GLOBALS['link'];
    $sql = "ALTER TABLE ans_table
    ADD `$q_id` $datatype";

    if ($link->query($sql) === TRUE) {
        $sql = "UPDATE `questions` SET published=1 where q_id = $q_id";
        if ($link->query($sql) === TRUE) {
            return 1;
        }
        return "Error : " . $link->error;
    }
    return "Error : " . $link->error;
}

function un_publish($q_id)
{
    $link = $GLOBALS['link'];
    $sql = "ALTER TABLE ans_table
    DROP COLUMN `$q_id`";

    if ($link->query($sql) === TRUE) {
        $sql = "UPDATE `questions` SET published=0 where q_id = $q_id";
        if ($link->query($sql) === TRUE) {
            return 1;
        }
        return "Error : " . $link->error;
    }
    return "Error : " . $link->error;
}

function add_q($qtn, $type)
{
    $link = $GLOBALS['link'];
    $q_id = q_id_gen();
    $dte = date('Y-m-d H:i:s');
    $sql = "INSERT INTO `questions` VALUES ($q_id,'$qtn','$type',0,'$dte')";
    if ($link->query($sql) === TRUE) {
        return 1;
    }
    return  "Error : " . $link->error;
}

function del_q($q_id)
{
    $link = $GLOBALS['link'];
    $sql = "DELETE FROM questions WHERE q_id=$q_id";
    if ($link->query($sql) === TRUE) {

        if (check_publish($q_id)) {
            return un_publish($q_id);
        }
        return 1;
    }
    return  "Error : " . $link->error;
}

function check_publish($q_id)
{
    $sql = "SELECT published FROM questions where q_id=$q_id";
    $result = mysqli_query($GLOBALS['link'], $sql);
    if ($result && mysqli_num_rows($result) > 0) {

        $q_data = mysqli_fetch_assoc($result);
        if ($q_data['published'] == 0) {
            return false;
        }
        return true;
    }
}

function mod_q()
{
}

function q_id_gen()
{
    $q_id = mt_rand(1000000, 9999999);
    $sql = "SELECT q_id FROM questions where q_id=$q_id";
    $result = mysqli_query($GLOBALS['link'], $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $user_data = mysqli_fetch_assoc($result);
        while ($q_id ==  $user_data['q_id']) {
            $q_id = mt_rand(1000000, 9999999);
        }
    }
    return $q_id;
}
