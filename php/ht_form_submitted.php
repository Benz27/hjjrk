<?php


// $_SESSION["hst_page"]=0;
// $_SESSION["post_ans"]=array();
// $_POST = array();
// get_q_sheets();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (!in_array($_SESSION["dec_g_ids"][count($_SESSION["dec_g_ids"]) - 1], $_SESSION["ans_g_ids"])) {
    array_push($_SESSION["post_ans"], $_POST);
    array_push($_SESSION["ans_g_ids"], $_SESSION["dec_g_ids"][count($_SESSION["dec_g_ids"]) - 1]);
  } else {
    $index = array_search($_SESSION["dec_g_ids"][count($_SESSION["dec_g_ids"]) - 1], $_SESSION["ans_g_ids"]);
    $_SESSION["post_ans"][$index] = $_POST;
  }
  // set_ans();
  $_POST = array();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (!in_array($_POST["gp_id"], $_SESSION["ans_g_ids"])) {
    array_push($_SESSION["post_ans"], $_POST);
    array_push($_SESSION["ans_g_ids"], $_POST["gp_id"]);
  } else {
    $index = array_search($_POST["gp_id"], $_SESSION["ans_g_ids"]);
    $_SESSION["post_ans"][$index] = $_POST;
  }
  // set_ans();
  $_POST = array();
}
