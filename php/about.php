<?php

$sql = "SELECT * FROM about where id=1";
if($result = mysqli_query($link, $sql)){
  if(mysqli_num_rows($result) > 0){ 
      while($row = mysqli_fetch_array($result)){  
        $about_email= $row['email']  ;
        $about_contno= $row['contact']  ;
        $about_country=  $row['country']  ;
        $ab_street= $row['street'];
        $ab_city= $row['city'];
        $ab_prov= $row['prov'];
        $abt= $row['abt'];

        $abt_name=$row['name'];
        $abt_pabt=$row['pabt'];
        $abt_sabt=$row['sabt'];

        $abt_mis=$row['mission'];
        $abt_vis=$row['vision'];
        $abt_copyright=$row['copyrightname']." &copy; ".$row['copyrightyear']." | ALL RIGHTS RESERVED";
        $abt_admin_footer='<footer class="sticky-footer bg-dark">
        <div class="container my-auto">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
            <div class="copyright text-center mb-3 text-light col-12">
            <a class="link-light text-light" style="text-decoration:none;" href="https://www.facebook.com/profile.php?id=100064251957082"><i class="bi-facebook"></i> Facebook</a>
            <span class="text-white mx-1">&middot;</span>
            <a style="text-decoration:none;" class="link-light text-light"><i class="bi-envelope"></i> stmichaelschoolofmarilao_1985@yahoo.com</a>
            <span class="text-white mx-1">&middot;</span>
        <a style="text-decoration:none;" class="link-light text-light"><i class="bi-phone"></i> +63 927 272 3395</a>
            </div>
            <div class="copyright text-center text-light col-12">
            '.$abt_copyright.'
            </div>
        </div>
    </footer>';
        
        $abt_user_footer=
      '<footer class="bg-dark py-4 mt-auto fixed-bottom">
        <div class="container px-5">
            <div class="row align-items-center justify-content-between flex-column flex-sm-row">
        <div class="col-12 mb-2 d-flex align-items-center justify-content-center">
            <a class="link-light small" style="text-decoration:none;" href="https://www.facebook.com/profile.php?id=100064251957082"><i class="bi-facebook"></i> Facebook</a>
                <span class="text-white mx-1">&middot;</span>
                <a style="text-decoration:none;" class="link-light small">stmichaelschoolofmarilao_1985@yahoo.com</a>
                <span class="text-white mx-1">&middot;</span>
            <a style="text-decoration:none;" class="link-light small">+63 927 272 3395</a>
        </div>
                <div class="col-12">
                    <div class="small m-0 text-white text-center">
                        '.$abt_copyright.'
                    </div>
                </div>
               
            </div>
        </div>
    </footer>';

    $abt_user_footer_notfixed=
    '<footer class="bg-dark py-4 mt-auto">
      <div class="container px-5">
          <div class="row align-items-center justify-content-between flex-column flex-sm-row">
          <div class="col-12 mb-2 d-flex align-items-center justify-content-center">
          <a class="link-light small" style="text-decoration:none;" href="https://www.facebook.com/profile.php?id=100064251957082"><i class="bi-facebook"></i> Facebook</a>
              <span class="text-white mx-1">&middot;</span>
              <a style="text-decoration:none;" class="link-light small"><i class="bi-envelope"></i> stmichaelschoolofmarilao_1985@yahoo.com</a>
              <span class="text-white mx-1">&middot;</span>
          <a style="text-decoration:none;" class="link-light small"><i class="bi-phone"></i> +63 927 272 3395</a>
      </div>
              <div class="col-12">
                  <div class="small m-0 text-white text-center">
                      '.$abt_copyright.'
                  </div>
              </div>
          </div>
      </div>
  </footer>';
        $admin_header_name=
        '<ul class="navbar-nav mr-auto">
        <li class="nav-item dropdown no-arrow d-flex float-left">
            <a class="nav-link dropdown-toggle" href="" id="userDropdown" role="button"
              >
              <img class="img-profile h-75 w-75 rounded-circle" src="../img/logo.png">
                <span class="ml-2 d-none d-lg-inline text-dark font-weight-bold" style="font-family: Times New Roman, Times, serif;">
                    '.$abt_name.'
                </span>

            </a>
            <!-- Dropdown - User Information -->
           
        </li>
    </ul>';

    $abt_user_header='<nav class="navbar navbar-expand-lg navbar-light bg-success fixed-top">
    <div class="container">
        
        <div class="d-flex align-items-center justify-content-center">
            <div class="col-2">
                <img src="../img/logo.png" style="max-width: 90px;max-height: 90px;margin:0;padding:0;" srcset="">
                
            </div>
            <div class="col-10 ms-3">
                <a class="nav-link" href="../"
            style="font-family: Myriad;font-weight: bolder;color: black;font-size: 50px;">
            <h1>
                '.$abt_name.'
            </h1>
            
        </a>
            </div>

        </div>
        
        
        <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button> -->


    </div>
</nav>';
          }
      mysqli_free_result($result);
  } else{
      echo "No records matching your query were found.";
  }
} else{
  echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

$bg_image=`style="background-image: url('../img/sch4.jpg'); height: 100vh;background-repeat: no-repeat;background-size: cover;padding: 0;margin: 0;"`;

