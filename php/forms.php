<?php

function get_user_info()
{
  $link = $GLOBALS['link'];
  $user_id = $_SESSION["user_id"];
  $array=array();
  $sql = "SELECT info.*, user.usertype FROM info, user where user.user_id=$user_id and info.user_id=$user_id";
  if ($result = mysqli_query($link, $sql)) {
    if (mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_array($result);

      $fname = $row['fname'];
      $lname = $row['lname'];


      if ($row['pfp'] != "") {
        $pfp = '../img/pfp/' . $user_id . '/' . $row['pfp'];
      } else {
        $pfp = '../img/empty.png';
      }
      array_push($array,$fname,$lname,$pfp);
      // return $fname . ' ' . $lname;
      return json_encode($array);


      mysqli_free_result($result);
    } else {
      echo "No records matching your query were found.";
    }
  } else {
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
  }
}


function navs($form)
{
  $user_info=json_decode(get_user_info());
  $nav_opt1 = "link-dark";
  $nav_opt2 = "link-dark";
  $nav_opt3 = "link-dark";
  $nav_opt4 = "link-dark";
  $nav_opt5 = "link-dark";

  $fullname=$user_info[0].' '.$user_info[1];
  $pfp=$user_info[2];
  if ($form == 0) {
    $nav_opt1 = "bg-success text-light";
  } else if ($form == 1) {
    $nav_opt2 = "bg-success text-light";
  } else if ($form == 2) {
    $nav_opt3 = "bg-success text-light";
  } else if ($form == 3) {
    $nav_opt4 = "bg-success text-light";
  } else if ($form == 4) {
    $nav_opt5 = "bg-success text-light";
  }

  return '
    <div class="card-body text-center"> 
    <!-- Profile picture image-->
        <img class="img-account-profile rounded-circle mb-2" src="' . $pfp . '" alt="" height="100px" id="my_img" width="100px"/>
   
    <!-- Profile picture help block-->
        <div class="small font-italic mb-4">' . $fullname . '</div> 
    </div>
    <ul class="nav nav-pills flex-column mb-auto">

    <li class="nav-item">
    <a href="announcements.html" class="nav-link ' . $nav_opt1 . ' mb-2 border border-3 border-success text-center rounded" aria-current="page">
      <!-- <svg class="bi me-2" width="16" height="16">
        <use xlink:href="#home" />
      </svg> -->
      Announcements
    </a>
  </li>
  <li>
    <a href="../php/hst_direct.php" class="nav-link ' . $nav_opt2 . ' mb-2 border border-3 border-success rounded text-center">
      <!-- <svg class="bi me-2" width="16" height="16">
        <use xlink:href="#speedometer2" />
      </svg> -->
      Health Status Form
    </a>
  </li>
<!--
  <li>
    <a href="arrival_form.html" class="nav-link ' . $nav_opt3 . ' mb-2 border border-3 border-success rounded text-center">
       <svg class="bi me-2" width="16" height="16">
        <use xlink:href="#table" />
      </svg> 
      Arrival Form
    </a>
  </li>
-->
  <li>
    <a href="health_tips.html" class="nav-link ' . $nav_opt4 . ' mb-2 border border-3 border-success rounded text-center">
      <!-- <svg class="bi me-2" width="16" height="16">
        <use xlink:href="#grid" />
      </svg> -->
      Health Tips
    </a>
  </li>
  <li>
    <a href="manage_account.html" class="nav-link ' . $nav_opt5 . ' mb-2 border border-3 border-success rounded text-center">
      <!-- <svg class="bi me-2" width="16" height="16">
        <use xlink:href="#people-circle" />
      </svg> -->
      Manage Account
    </a>
  </li>
    </ul>';
}
