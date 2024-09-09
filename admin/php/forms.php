<?php

function get_user_info()
{
  $link = $GLOBALS['link'];
  $user_id = $_SESSION["admin_user_id"];
  $array = array();
  $sql = "SELECT admin_info.*, admin.usertype FROM admin_info, admin where admin.user_id=$user_id and admin_info.user_id=$user_id";
  if ($result = mysqli_query($link, $sql)) {
    if (mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_array($result);

      $fname = $row['fname'];
      $lname = $row['lname'];


      if ($row['pfp'] != "") {
        $pfp = './img/pfp/' . $user_id . '/' . $row['pfp'];
      } else {
        $pfp = '../img/empty.png';
      }

      // $pfp = '../img/empty.png';
      array_push($array, $fname, $lname, $pfp);
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
  $navs = array(
    "Registered Users",
    "Admin Accounts",
    "Records",
    "Archived Records",
    "Health Status Form",
    "Announcements",
    "Health Tips",
    "Manage Account"
  );
  $nav_links = array(
    "users.html",
    "admin_users.html",
    "record_list.html",
    "record_list_arc.html",
    "health_status_form.html",
    "announcements.html",
    "health_tips.html",
    "manage_account.html"
  );

  if ($GLOBALS['usertype'] == 0) {
    $nav_priv = array(1, 1, 1, 1, 0, 1, 0, 1);
  } else if ($GLOBALS['usertype'] == 1) {
    $nav_priv = array(1, 0, 1, 1, 1, 1, 1, 1);
  }

  $navs_cnt = count($navs);
  $form_i = array_search($form, $navs);


  $user_info = json_decode(get_user_info());


  $fullname = $user_info[0] . ' ' . $user_info[1];
  $pfp = $user_info[2];


  $side_nav = '<div class="card-body text-center"> 
      <img class="img-account-profile rounded-circle mb-2" src="' . $pfp . '" alt="" height="100px" id="my_img" width="100px"/>
 
      <div class="small font-italic mb-4">' . $fullname . '</div> 
  </div>
  <ul class="nav nav-pills flex-column mb-auto">';

  for ($x = 0; $x < $navs_cnt; $x++) {
    if ($nav_priv[$x] == 1) {

      $opt = "link-dark";
      if ($x == $form_i) {
        $opt = "bg-success text-light";
      }

      $side_nav .= '<li class="nav-item">
    <a href="' . $nav_links[$x] . '" class="nav-link ' . $opt . ' mb-2 border border-3 border-success text-center rounded">
      <!-- <svg class="bi me-2" width="16" height="16">
        <use xlink:href="#home" />
      </svg> -->
      ' . $navs[$x] . '
    </a>
  </li>';
    }
  }
  $side_nav .= '</ul>';
  return $side_nav;
}
