<?php

if (
  !isset($_SESSION["hst_page"]) ||
  !isset($_SESSION["post_ans"]) ||
  !isset($_SESSION["ans_g_ids"]) ||
  !isset($_SESSION["dec_g_ids"])||
  !isset($_GET["gp"])
) {
  header("Location: ../php/hst_direct.php");
}

$_SESSION["hst_page"] = array_search($_GET["gp"], $_SESSION["dec_g_ids"]);


// $_SESSION["hst_page"]=0;
// $_SESSION["post_ans"]=array();
// $_POST = array();
// get_q_sheets();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (!isset($_POST["page_back"])) {
    if (!in_array($_POST["gp_id"], $_SESSION["ans_g_ids"])) {
      array_push($_SESSION["post_ans"], $_POST);
      array_push($_SESSION["ans_g_ids"], $_POST["gp_id"]);
    } else {
      $index = array_search($_POST["gp_id"], $_SESSION["ans_g_ids"]);
      $_SESSION["post_ans"][$index] = $_POST;
    }
    // set_ans();

  }

  $_POST = array();
}

$page = $_SESSION["hst_page"];

//functions


function qst_ans()
{
}

function set_ans()
{

  $page = $_SESSION["hst_page"];
  $g_ids = $_SESSION['dec_g_ids'];
  $qst_ids = $_SESSION['dec_qst_ids'];
  $object = $_SESSION['dec_object'];
  $g_id = $g_ids[$page];
  // print_r($_SESSION["post_ans"]);

  // print_r($_SESSION["ans_g_ids"]);
  for ($x = 0; $x < count($qst_ids[$page]); $x++) {
    $values = $object[$g_id]["items"][$qst_ids[$page][$x]]["values"];
    $string = $object[$g_id]["items"][$qst_ids[$page][$x]]["string"];
    $type = $object[$g_id]["items"][$qst_ids[$page][$x]]["type"];




    if ($type == "radio") {
      array_push($_SESSION['dec_object'][$g_id]["items"][$qst_ids[$page][$x]]["ans"], $_POST["qst"][(string)$g_id][(string)$qst_ids[$page][$x]]);
    }

    if ($type == "cbox") {
      for ($y = 0; $y < count($values); $y++) {
        if (isset($_POST["qst"][(string)$g_id][(string)$qst_ids[$page][$x]][(string)$y])) {
          array_push($_SESSION['dec_object'][$g_id]["items"][$qst_ids[$page][$x]]["ans"], 1);
        } else {
          array_push($_SESSION['dec_object'][$g_id]["items"][$qst_ids[$page][$x]]["ans"], 0);
        }
      }
    }

    if ($type == "text") {
      for ($y = 0; $y < count($values); $y++) {
        array_push($_SESSION['dec_object'][$g_id]["items"][$qst_ids[$page][$x]]["ans"], $_POST["qst"][(string)$g_id][(string)$qst_ids[$page][$x]][$y]);
      }
    }



    // if ($type == "radio") {
    //   array_push($object[$g_id]["items"][$qst_ids[$page][$x]]["ans"], $_POST["qst"][(string)$g_id][(string)$qst_ids[$page][$x]]);
    // }

    // if ($type == "cbox") {
    //   for ($y = 0; $y < count($values); $y++) {
    //     if (isset($_POST["qst"][(string)$g_id][(string)$qst_ids[$page][$x]][(string)$y])) {
    //       array_push($object[$g_id]["items"][$qst_ids[$page][$x]]["ans"], 1);
    //     } else {
    //       array_push($object[$g_id]["items"][$qst_ids[$page][$x]]["ans"], 0);
    //     }
    //   }
    // }

    // if ($type == "text") {
    //   for ($y = 0; $y < count($values); $y++) {
    //     array_push($object[$g_id]["items"][$qst_ids[$page][$x]]["ans"], $_POST["qst"][(string)$g_id][(string)$qst_ids[$page][$x]][$y]);
    //   }
    // }

    //text and cbox: qst[gp_id][qst_id][index]
    //radio: qst[gp_id][qst_id]

  }
}


// function get_q_sheets()
// {
//   $link = $GLOBALS['link'];
//   $sql = "SELECT * FROM q_sheets where q_id=1111111";
//   $result = mysqli_query($link, $sql);
//   if ($result && mysqli_num_rows($result) > 0) {
//     $row = mysqli_fetch_array($result);

//     $_SESSION["dec_g_ids"] = json_decode($row['g_ids']);
//     $_SESSION["dec_qst_ids"] = json_decode($row['qst_ids']);
//     $_SESSION["dec_object"] = json_decode($row['object_str'], true);
//   }
// }


function get_qst()
{
  if($GLOBALS['hst_forthisweek']){
    return'<h3>You have already submitted a form for this week.</h3>';
  }
  $page = $GLOBALS['page'];
  $g_ids = $_SESSION['dec_g_ids'];
  $qst_ids = $_SESSION['dec_qst_ids'];
  $object = $_SESSION['dec_object'];
  $g_id = $g_ids[$page];


  $action = array();

  for ($i = 1; $i < count($g_ids); $i++) {
    array_push($action, 'health_status_form.html?gp=' . $g_ids[$i]);
  }
  array_push($action, "submitted.html");





  // $element = json_encode($_SESSION['dec_object']);
  $element = '<div class="card-header">
  <h3 class="text-start font-weight-light">' . $object[$g_id]["name"] . '</h3>
</div>
<div class="card-body">
  <form method="post" id="form_' . $g_id . '" action="' . $action[$page] . '">
  <input type="text" name="gp_id" value="' . $g_id . '" hidden>
';
  for ($x = 0; $x < count($qst_ids[$page]); $x++) {
    $labels = $object[$g_id]["items"][$qst_ids[$page][$x]]["labels"];
    $values = $object[$g_id]["items"][$qst_ids[$page][$x]]["values"];
    $string = $object[$g_id]["items"][$qst_ids[$page][$x]]["string"];
    $type = $object[$g_id]["items"][$qst_ids[$page][$x]]["type"];
    $required = $object[$g_id]["items"][$qst_ids[$page][$x]]["required"];

    $req_str="";
    if((boolean)$required==true){
      $req_str='<span style="color:red;">*</span> ';
    }

    $element .= '
    <div class="col-12 p-2 mb-3 border border-2 rounded-3">
    <p class="fw-bold">' .$req_str. $string . '</p>';
    for ($y = 0; $y < count($labels); $y++) {
      $element .= get_cc($page, $g_id, $qst_ids[$page][$x], $type, $labels[$y], $y, $values[$y],$required);
    }

    $element .= '</div>';
  }

  $element .= '

   <button id="btn-submit" type="submit" hidden></button>
  </form>
</div>';

  return $element;
}


function get_cc($page, $g_id, $qst_id, $type, $string, $index, $value,$required)
{

  $req_str="";
  if((boolean)$required==true){
    $req_str="required";
  }

  if ($type == "radio")
    return '
<div class="form-check mb-2">
<input class="form-check-input" type="radio" name="qst[' . $g_id . '][' . $qst_id . ']" value="' . $value . '" ' . radio($page, $g_id, $qst_id, $value) . ' '.$req_str.'/>
<label class="form-check-label" for="">
' . $string . '
</label>
</div>';

  if ($type == "cbox")
    return '
<div class="form-check">
<input class="form-check-input" type="checkbox" value="1" name="qst[' . $g_id . '][' . $qst_id . '][' . $index . ']" ' . cbox($page, $g_id, $qst_id, $index) . ' '.$req_str.'/>
<label class="form-check-label" for="">
' . $string . '
</label>
</div>';


  if ($type == "text")

    return '
<div class="mt-3 mb-md-0">
<label class="small mb-1" for="">' . $string . '</label>
<input class="form-control mb-3" type="text" placeholder="" value="' . text($page, $g_id, $qst_id, $index) . '" name="qst[' . $g_id . '][' . $qst_id . '][' . $index . ']" '.$req_str.'/>
</div>';
}



function radio($page, $g_id, $qst_id, $value)
{
  if (isset($_SESSION["post_ans"][$page]["qst"][$g_id][$qst_id])) {
    if ($_SESSION["post_ans"][$page]["qst"][$g_id][$qst_id] == $value) {
      return "checked";
    }
  }

  return "";
}

function cbox($page, $g_id, $qst_id, $index)
{
  if (isset($_SESSION["post_ans"][$page]["qst"][$g_id][$qst_id][$index])) {
    if ($_SESSION["post_ans"][$page]["qst"][$g_id][$qst_id][$index] == 1) {
      return "checked";
    }
  }
  return "";
}

function text($page, $g_id, $qst_id, $index)
{
  if (isset($_SESSION["post_ans"][$page]["qst"][$g_id][$qst_id][$index])) {

    return $_SESSION["post_ans"][$page]["qst"][$g_id][$qst_id][$index];
  }
  return "";
}


function btn_forms()
{
  if($GLOBALS['hst_forthisweek']){
    return'';
  }
  $page = $GLOBALS['page'];
  $g_ids = $_SESSION['dec_g_ids'];
  $ans_g_id_count = count($_SESSION["dec_g_ids"]);

  if ($page == 0)
    return '
  <button type="button" class="btn btn-success" onclick="submit_form()";>Next</button>
  ';

  if ($page > 0 && $page < $ans_g_id_count - 1)
    return '
    <form method="post" id="form_' . $g_ids[$page - 1] . '" action="health_status_form.html?gp=' . $g_ids[$page - 1] . '">
    <input type="text" name="page_back" id="" value="1" hidden>
    <button type="submit" class="btn btn-secondary">Back</button>
  <button type="button" class="btn btn-success" onclick="submit_form()";>Next</button>
  </form>
  ';

  if ($page == $ans_g_id_count - 1)
    return '
    <form method="post" id="form_' . $g_ids[$page - 1] . '" action="health_status_form.html?gp=' . $g_ids[$page - 1] . '">
    <input type="text" name="page_back" id="" value="1" hidden>
    <button type="submit" class="btn btn-secondary">Back</button>
  <button type="button" class="btn btn-success" onclick="submit_form()";>Submit</button>
  </form>
  ';

  // <input type="text" name="page_back" id="" value="1" hidden>
}
