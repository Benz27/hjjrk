<?php
$user_id = $_SESSION["user_id"];

$sql = "SELECT info.*, user.usertype FROM info, user where user.user_id=$user_id and info.user_id=$user_id";
if ($result = mysqli_query($link, $sql)) {
  if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) {

      $email = $row['email'];
      $contno = $row['phone'];
      $usertype = $row['usertype'];

      $fname = $row['fname'];
      $lname = $row['lname'];
      $mname = $row['mname'];
      $addr = $row['address'];
      $bday = $row['bday'];
      $prov = $row['province'];
      $city = $row['city'];
      
      if ($row['pfp'] != "") {
        $pfp = '../img/pfp/' . $user_id . '/' . $row['pfp'];
      } else {
        $pfp = '../img/empty.png';
      }
    }
    mysqli_free_result($result);
  } else {
    echo "No records matching your query were found.";
  }
} else {
  echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

if ($usertype == 0) {
  $id_type = "School Employee ID";
} else if ($usertype == 1) {
  $id_type = "Student ID";
} else {
  $id_type = "Visitor ID";
}






