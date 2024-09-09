var nav_cnt = 0;
var navs_tab_cnt = 0;
var link_ind=0;
// var usertype = "<?php echo $GLOBALS['usertype']?>";
// var usertype=0;

const arr1 = [];
const arr2 = [];

function link_inc(leap,utype){
    var inc=1;

    if (utype > 0) {
        inc += leap;
    } 

    var link_ind_loc = link_ind;
    link_ind +=inc;
    return link_ind_loc;
}

function get_side_navs(li, a) {

   
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            //    console.log(this.responseText);

            if(!isNaN(this.responseText)){
                var res = Number(this.responseText);
                navs_adm(li, a, res);
                return;
            }
            
            console.log(this.responseText);

        };

    }


    xhttp.open("GET", "./php/call_functions.php?x=get_admin_type", true);
    xhttp.send();
    
}


function navs_inc(res,utype) {
    var nav_cnt_loc = nav_cnt;
    nav_cnt += 1;
    if (res == 2) {
        if (utype > 0) {
            nav_cnt = 0;
        }
    }


    if (res == 1) {
        nav_cnt = 0;
    }
    arr2.push(nav_cnt_loc);

    return nav_cnt_loc;
}

function navs_tab_inc(inc,utype) {
    var l_inc = inc;
    if (inc == 2) {
        if (utype == 0) {
            l_inc = 0;
        } else {
            l_inc = 1;
        }
    }
    var navs_tab_cnt_loc = navs_tab_cnt;
    navs_tab_cnt += l_inc;
    arr1.push(l_inc);
    return navs_tab_cnt_loc;
}

function nav_tab_active(tab, tab_part) {
    var f_class = ["", "collapsed", ""];
    var f_class_active = ["active", "", "show"];
    if (navs_tab_cnt == tab) {


        return f_class_active[tab_part];
    }
    return f_class[tab_part];
}

function alone_nav_tab_active(tab) {
    var nav_tabs_cnt_loc = navs_tab_cnt;
    navs_tab_cnt += 1;
    arr1.push(navs_tab_cnt);
    if (nav_tabs_cnt_loc == tab) {

        return "active";
    }

    return "";
}


function navs_adm(li, a,utype) {

    const parent = ["Account", "Records", "People", "School Updates","Health Status Form", "Health Tips", "Archived Records"];
    const child = [
        [
            "Profile",
            "Log-Out"
        ],
        [
            "Health Status Records",
            "Arrival Records"
        ],
        [
            "Registered Users",
            "Add User",
            "Administrators",
            "Add Admin"
        ],
        [],
        [],
        [],
        [
            "Health Status Records",
            "Arrival Records"
        ],
    ];


    var nav_tabs = [];
    for (x = 0; x < parent.length; x++) {
        nav_tabs.push([]);
        for (y = 0; y < child[x].length; y++) {
            nav_tabs[x].push("");
        }
    }


    const link=[
        "profile.html",
        "health_status_form.html",
        "arrivals.html",
        "users.html",
        "create_user.html",
        "acclist.html",
        "create_admin.html",
        "school_updates.html",
        "hst_form.html",
        "health_tips.html",
        "arc_health_status_form.html",
        "arc_arrivals.html"
    ];



    var tab = parent.indexOf(li);
    if (tab < 0) {
        return;
    }

    var form = child[tab].indexOf(a);
    if (form == -1 && a != "") {
        return;
    }


    // return $tab." ".$form;

    for (x = 0; x < nav_tabs.length; x++) {
        for (y = 0; y < nav_tabs[x].length; y++) {
            if (y == form && x == tab) {
                nav_tabs[x][y] = "active";
            }
        }
    }
   
    
    var nav_str = `
    <li class="nav-item `+ nav_tab_active(tab, 0) + `">
    <a class="nav-link `+ nav_tab_active(tab, 1) + `" href="#" data-toggle="collapse" data-target="#collapseTwo"
        aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-fw fa-user"></i>
        <span>Account</span>
    </a>
    <div id="collapseTwo" class="collapse `+ nav_tab_active(tab, 2) + `" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <!-- <h6 class="collapse-header">Custom Components:</h6> -->
            <a class="collapse-item `+ nav_tabs[navs_tab_inc(0,utype)][navs_inc(0,utype)] + `" href="`+link[link_inc(0,utype)]+`">Profile</a>
            <a class="collapse-item `+ nav_tabs[navs_tab_inc(1,utype)][navs_inc(1,utype)] + `" style="cursor: pointer;" data-toggle="modal"
                data-target="#logoutModal">Log-Out</a>
        </div>
    </div>
</li>

<li class="nav-item `+ nav_tab_active(tab, 0) + `">
    <a class="nav-link `+ nav_tab_active(tab, 1) + `" href="#" data-toggle="collapse" data-target="#collapseRec"
        aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-fw fa-file"></i>
        <span>Records</span>
    </a>
    <div id="collapseRec" class="collapse `+ nav_tab_active(tab, 2) + `" aria-labelledby="headingRec" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <!-- <h6 class="collapse-header">Custom Components:</h6> -->
            <a class="collapse-item `+ nav_tabs[navs_tab_inc(0,utype)][navs_inc(0,utype)] + `" href="`+link[link_inc(0,utype)]+`">Health Status Records</a>
            <a class="collapse-item `+ nav_tabs[navs_tab_inc(1,utype)][navs_inc(1,utype)] + `" href="`+link[link_inc(0,utype)]+`">Arrival Records</a>
        </div>
    </div>
</li>

<li class="nav-item `+ nav_tab_active(tab, 0) + `">
<a class="nav-link `+ nav_tab_active(tab, 1) + `" href="#" data-toggle="collapse" data-target="#collapseAcc"
    aria-expanded="true" aria-controls="collapseAcc">
    <i class="fas fa-fw fa-users"></i>
    <span>People</span>
</a>
<div id="collapseAcc" class="collapse `+ nav_tab_active(tab, 2) + `" aria-labelledby="headingAcc" data-parent="#accordionSidebar">
    <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item `+ nav_tabs[navs_tab_inc(0,utype)][navs_inc(0,utype)] + `" href="`+link[link_inc(0,utype)]+`">Registered Users</a>
        <a class="collapse-item `+ nav_tabs[navs_tab_inc(2,utype)][navs_inc(2,utype)] + `" href="`+link[link_inc(2,utype)]+`">Add User</a>
        `;
  if (utype == 0) {
    nav_str += `
            <a class="collapse-item `+ nav_tabs[navs_tab_inc(0,utype)][navs_inc(0,utype)] + `" href="`+link[link_inc(0,utype)]+`">Administrators</a>
            <a class="collapse-item `+ nav_tabs[navs_tab_inc(1,utype)][navs_inc(1,utype)] + `" href="`+link[link_inc(0,utype)]+`">Add Admin</a>
            `;
  }

  nav_str += `</div>
</div>
</li>
<li class="nav-item `+ alone_nav_tab_active(tab) + `">
<a class="nav-link collapsed" href="`+link[link_inc(0,utype)]+`" aria-expanded="true" aria-controls="collapseCustomer">
    <i class="fas fa-fw fa-newspaper"></i>
    <span>School Updates</span>
</a>
</li>
<li class="nav-item `+ alone_nav_tab_active(tab) + `">
<a class="nav-link collapsed" href="`+link[link_inc(0,utype)]+`" aria-expanded="true" aria-controls="collapseCustomer">
    <i class="fas fa-fw fa-file-medical"></i>
    <span>Health Status Form</span>
</a>
</li>

<li class="nav-item `+ alone_nav_tab_active(tab) + `">
                <a class="nav-link collapsed" href="`+link[link_inc(0,utype)]+`" aria-expanded="true" aria-controls="collapseCustomer">
                    <i class="fas fa-fw fa-medkit"></i>
                    <span>Health Tips</span>
                </a>
</li>
<li class="nav-item `+ nav_tab_active(tab, 0) + `">
    <a class="nav-link `+ nav_tab_active(tab, 1) + `" href="#" data-toggle="collapse" data-target="#collapseArcRec"
        aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-fw fa-archive"></i>
        <span>Archived Records</span>
    </a>
    <div id="collapseArcRec" class="collapse `+ nav_tab_active(tab, 2) + `" aria-labelledby="headingArcRec" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <!-- <h6 class="collapse-header">Custom Components:</h6> -->
            <a class="collapse-item `+ nav_tabs[navs_tab_inc(0,utype)][navs_inc(0,utype)] + `" href="`+link[link_inc(0,utype)]+`">Health Status Records</a>
            <a class="collapse-item `+ nav_tabs[navs_tab_inc(1,utype)][navs_inc(1,utype)] + `" href="`+link[link_inc(0,utype)]+`">Arrival Records</a>
        </div>
    </div>
</li>`;

    // return nav_str;

document.getElementById("sidenav").innerHTML=nav_str;
}

