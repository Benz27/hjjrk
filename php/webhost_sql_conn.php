<?php
$dbhost = "sql205.epizy.com";
$dbuser = "epiz_33013148";
$dbpass = "2fgp3RkGWJ5gum";
$dbname = "epiz_33013148_dbase";

$link = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if($link === false){
    die("Could not connect!" . mysqli_connect_error());
}

