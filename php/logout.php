<?php
session_start();
if(isset($_SESSION['user_id'])){
unset($_SESSION['user_id']);
unset($_SESSION["dec_g_ids"]);
unset($_SESSION["dec_qst_ids"]);
unset($_SESSION["dec_object"]);
unset($_SESSION["page"]);
unset($_SESSION["post_ans"]);
unset($_SESSION["hst_page"]);
unset($_SESSION["ans_g_ids"]);
}
header("Location: ../login/");
