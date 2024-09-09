<?php


session_start();
include("conn.php");

$sql = "SELECT * FROM q_sheets where q_id=1111111";
$result = mysqli_query($link, $sql);
if ($result && mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_array($result);

  $dec_g_ids = json_decode($row['g_ids']);
  $dec_qst_ids = json_decode($row['qst_ids']);
  $dec_object = json_decode($row['object_str'], true);
}
// var_dump($dec_object);
get_qst();
// echo json_encode(get_qst());

function get_qst()
{

  $g_ids = $GLOBALS['dec_g_ids'];
  $qst_ids = $GLOBALS['dec_qst_ids'];
  $object = $GLOBALS['dec_object'];
  $arr_obj = array();

  for ($obj_id = 0; $obj_id < count($g_ids); $obj_id++) {

    $page = $obj_id;
    $page_num=$obj_id+1;
    $g_id = $g_ids[$page];


    $action = array();

    for ($i = 1; $i < count($g_ids); $i++) {
      array_push($action, 'health_status_form.html?gp=' . $g_ids[$i]);
    }
    array_push($action, "arrival_form.html");





    // $element = json_encode($GLOBALS['dec_object']);
    $element = '<div class="card-header">
  <h3 class="text-start font-weight-light">' . $object[$g_id]["name"] . ' <span class="small text-muted">(Page - '.$page_num.')</span></h3>
</div>
<div class="card-body">
  <input type="text" name="gp_id" value="' . $g_id . '" hidden>
    <div class="scroll p-3">';
    for ($x = 0; $x < count($qst_ids[$page]); $x++) {
      $labels = $object[$g_id]["items"][$qst_ids[$page][$x]]["labels"];
      $values = $object[$g_id]["items"][$qst_ids[$page][$x]]["values"];
      $string = $object[$g_id]["items"][$qst_ids[$page][$x]]["string"];
      $type = $object[$g_id]["items"][$qst_ids[$page][$x]]["type"];
      $required = $object[$g_id]["items"][$qst_ids[$page][$x]]["required"];

      $req_str = "";
      if ($required == true) {
        $req_str = '<span style="color:red;">*</span> ';
      }


      $element .= '
    <div class="col-12 p-2 mb-3 border border-2 rounded-3">
    <p class="fw-bold">' . $req_str . $string . '</p>';
      for ($y = 0; $y < count($labels); $y++) {
        $element .= get_cc($g_id, $qst_ids[$page][$x], $type, $labels[$y], $y, $values[$y], $required);
      }

      $element .= '</div>';
    }

    $element .= '
   </div>
</div>';
    array_push($arr_obj, $element);
    

  }

  // return $arr_obj;
  echo json_encode($arr_obj);
}


function get_cc($g_id, $qst_id, $type, $string, $index, $value, $required)
{
  $req_str = "";
  if ($required == true) {
    $req_str = "required";
  }


  if ($type == "radio")
    return '
<div class="form-check mb-2">
<input class="form-check-input" type="radio" name="qst[' . $g_id . '][' . $qst_id . ']" value="' . $value . '" ' . $req_str . '/>
<label class="form-check-label" for="">
' . $string . '
</label>
</div>';

  if ($type == "cbox")
    return '
<div class="form-check">
<input class="form-check-input" type="checkbox" value="1" name="qst[' . $g_id . '][' . $qst_id . '][' . $index . ']" ' . $req_str . '/>
<label class="form-check-label" for="">
' . $string . '
</label>
</div>';


  if ($type == "text")

    return '
<div class="mt-3 mb-md-0">
<label class="small mb-1" for="">' . $string . '</label>
<input class="form-control mb-3" type="text" placeholder="" value="" name="qst[' . $g_id . '][' . $qst_id . '][' . $index . ']" ' . $req_str . '/>
</div>';
}
