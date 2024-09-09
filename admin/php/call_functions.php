<?php
$x=$_GET['x'];

session_start();
date_default_timezone_set("Asia/Manila");
include("conn.php");


switch ($x) {
    case "get_users":
        include("get_fn.php");
        get_users($link,$_GET['ut']);
    break;
    case "print_users_today":
        include("get_fn.php");
        print_users_today($link);
    break;
    case "get_users_arc":
        include("get_fn.php");
        get_users_arc($link,$_GET['ut']);
    break;
    case "get_admins":
        include("get_fn.php");
        get_admins($link);
    break;
    case "get_admins_arc":
        include("get_fn.php");
        get_admins_arc($link);
    break;
    case "get_arrivals":
        include("get_fn.php");
        get_arrivals($link);
    break;
    case "get_arc_arrivals":
        include("get_fn.php");
        get_arc_arrivals($link);
    break;
    case "get_hsf":
        include("get_fn.php");
        get_hsf($link,$_GET['ut']);
    break;
    case "get_arc_hsf":
        include("get_fn.php");
        get_arc_hsf($link);
    break;
    case "get_arc_hsf_rec":
        include("get_fn.php");
        get_arc_hsf_rec($link,$_GET['a_id']);
    break;
    case "decline_arr":
        include("get_fn.php");
        decline_arr($link,$_POST['a_id']);
    break;
    case "confirm_arr":
        include("get_fn.php");
        confirm_arr($link,$_POST['a_id']);
    break;
    case "delete_arr":
        include("get_fn.php");
        delete_arr($link,$_GET['a_id']);
    break;
    case "health_tips_mod":
        include("get_fn.php");
        health_tips_mod($link,$_POST['ht']);
    break;
    case "school_updates":
        include("get_fn.php");
        school_updates($link,$_POST['sp']);
    break;
    case "get_hsf_rec":
        include("get_fn.php");
        get_hsf_rec($link,$_GET['a_id'],$_GET['arc']);
    break;
    case "delete_hsf":
        include("get_fn.php");
        delete_hsf($link,$_GET['a_id']);
    break;
    case "delete_both":
        include("get_fn.php");
        delete_both($link,$_GET['a_id'],$_GET['form']);
    break;
    case "get_admin_type":
        include("get_fn.php");
        get_admin_type($link);
    break;
    case "get_q_sheet_ids":
        include("get_fn.php");
        get_q_sheet_ids($link);
    break;
    case "save_q_sheet":
        include("get_fn.php");
        save_q_sheet($link);
    break;
}

