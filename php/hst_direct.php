<?php


session_start();
include("conn.php");
include("read.php");

if (!isset($_SESSION["hst_page"])) {
  $_SESSION["hst_page"] = 0;
}

if (!isset($_SESSION["post_ans"])) {
  $_SESSION["post_ans"] = array();
}

if (!isset($_SESSION["ans_g_ids"])) {
  $_SESSION["ans_g_ids"] = array();
}

if (!isset($_SESSION["dec_g_ids"])) {
  get_q_sheets();
}

function get_q_sheets()
{
  $link = $GLOBALS['link'];
  $sql = "SELECT * FROM q_sheets where q_id=1111111";
  $result = mysqli_query($link, $sql);
  if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_array($result);

    $_SESSION["dec_g_ids"] = json_decode($row['g_ids']);
    $_SESSION["dec_qst_ids"] = json_decode($row['qst_ids']);
    $_SESSION["dec_object"] = json_decode($row['object_str'], true);
  }
}

header("Location: ../forms/health_status_form.html?gp=".$_SESSION["dec_g_ids"][$_SESSION["hst_page"]]);