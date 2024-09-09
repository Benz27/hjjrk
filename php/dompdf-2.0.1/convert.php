<?php

require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;

include('../conn.php');
include('../../admin/php/get_fn.php');
$html='';
$x=$_GET['x'];
$filename='';
date_default_timezone_set('Asia/Manila');
$date=date("M j, Y");
switch($x){
  case 'print_users_today':
    $html=print_users_today($link);
    $filename="Registered Users of St. Micehal School on ".$date;
  break;
  case 'print_hsf_today':
    $ut=$_GET['ut'];
    $html=print_hsf_today($link,$ut);
  if($ut==-1){
      $utype_str="School Employee and Student";
  }else if($ut==0){
      $utype_str="School Employee";
  }else if($ut==1){
      $utype_str="Student";
  }
    $filename=$utype_str." Health Status Form Submissions to St. Michael School on ".$date;
    // $html=print_users_today($link);
  break;
}



$dompdf = new Dompdf();

$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation 
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF 
$dompdf->render();

// Output the generated PDF to Browser 
$dompdf->stream($filename, array("Attachment" => 1));

// echo $html;
