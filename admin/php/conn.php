<?php
$dbhost = "";
$dbuser = "";
$dbpass = "";
$dbname = "";

$link = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if($link === false){
    die("Could not connect!" . mysqli_connect_error());
}
date_default_timezone_set("Asia/Manila");