<?php

// session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $a_id = a_id_gen();
    $user_id = $_SESSION['user_id'];
    set_ans();
    date_default_timezone_set("Asia/Manila");
    $user_id =  $_SESSION["user_id"];

    $g_ids = json_encode($_SESSION["dec_g_ids"]);
    $qst_ids = json_encode($_SESSION["dec_qst_ids"]);
    $object_str = json_encode($_SESSION["dec_object"]);


    $sql = "INSERT INTO `ans_sheets` (`ans_id`,`user_id`,`g_ids`,`qst_ids`,`object_str`,`dte`) values ($a_id,$user_id,'$g_ids','$qst_ids','$object_str','" . date('Y-m-d H:i:s') . "')";

    if ($link->query($sql) === TRUE) {
        insert_arrv($a_id, $user_id);
    } else {
        echo "Error : " . $link->error;
    }



    // echo json_encode($_SESSION["post_ans"]);


}


function set_ans()
{

    $g_ids = $_SESSION['dec_g_ids'];
    $qst_ids = $_SESSION['dec_qst_ids'];
    $object = $_SESSION['dec_object'];


    $post_ans = $_SESSION["post_ans"];
    // $_SESSION["post_ans"][index]["qst"][gp_id][qst_id][value index];
    for ($i = 0; $i < count($g_ids); $i++) {
        $g_id = $g_ids[$i];
        for ($x = 0; $x < count($qst_ids[$i]); $x++) {
            $values = $object[$g_id]["items"][$qst_ids[$i][$x]]["values"];
            $type = $object[$g_id]["items"][$qst_ids[$i][$x]]["type"];

            if ($type == "radio") {
                if(isset($post_ans[$i]["qst"][(string)$g_id][(string)$qst_ids[$i][$x]])){
                    array_push($_SESSION['dec_object'][$g_id]["items"][$qst_ids[$i][$x]]["ans"], $post_ans[$i]["qst"][(string)$g_id][(string)$qst_ids[$i][$x]]);
                }else{
                    array_push($_SESSION['dec_object'][$g_id]["items"][$qst_ids[$i][$x]]["ans"], -1);
                }
            }

            if ($type == "cbox") {
                for ($y = 0; $y < count($values); $y++) {
                    if (isset($post_ans[$i]["qst"][(string)$g_id][(string)$qst_ids[$i][$x]][(string)$y])) {
                        array_push($_SESSION['dec_object'][$g_id]["items"][$qst_ids[$i][$x]]["ans"], 1);
                    } else {
                        array_push($_SESSION['dec_object'][$g_id]["items"][$qst_ids[$i][$x]]["ans"], 0);
                    }
                }
            }

            if ($type == "text") {
                for ($y = 0; $y < count($values); $y++) {
                    array_push($_SESSION['dec_object'][$g_id]["items"][$qst_ids[$i][$x]]["ans"], $post_ans[$i]["qst"][(string)$g_id][(string)$qst_ids[$i][$x]][$y]);
                }
            }

            //text and cbox: qst[gp_id][qst_id][index]
            //radio: qst[gp_id][qst_id]
        }
    }
}

function a_id_gen()
{
    $user_id = mt_rand(1000000, 9999999);
    $sql = "SELECT a_id FROM ans_table where a_id=$user_id";
    $result = mysqli_query($GLOBALS['link'], $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $user_data = mysqli_fetch_assoc($result);
        while ($user_id ==  $user_data['user_id']) {
            $user_id = mt_rand(1000000, 9999999);
        }
    }

    return $user_id;
}





function insert_arrv($a_id, $user_id)
{
    $link = $GLOBALS['link'];
    date_default_timezone_set("Asia/Manila");

    // $date = $_POST["dte"] . " " . $_POST["time"] . ":00";
    $sql = "INSERT INTO `arrivals` values($a_id,$user_id,'N/A','N/A','0000-00-00 00:00:00','" . date('Y-m-d H:i:s') . "',0)";

    if ($link->query($sql) === TRUE) {
        unset($_SESSION["dec_g_ids"]);
        unset($_SESSION["dec_qst_ids"]);
        unset($_SESSION["dec_object"]);
        unset($_SESSION["page"]);
        unset($_SESSION["post_ans"]);
        unset($_SESSION["hst_page"]);
        unset($_SESSION["ans_g_ids"]);
        $_POST=array();
    } else {
        $errmsg = "Error : " . $link->error;
        echo $errmsg;
    }

    // return $sql;
}
