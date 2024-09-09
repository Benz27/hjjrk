
function get_utype() {


    

}
function navs_adm(nav) {



    const navs = {
        "Registered Users": {
            "icon": "fas fa-fw fa-users",
            "hasChildren": false,
            "priv": "all",
            "type": "link",
            "endLine": false,
            "link": "users.html"
        },
        "Admin Accounts": {
            "icon": "fas fa-fw fa-user-cog",
            "hasChildren": false,
            "priv": 0,
            "type": "link",
            "link": "admin_users.html"
        },
        "Records": {
            "icon": "fas fa-fw fa-file",
            "hasChildren": false,
            "priv": "all",
            "type": "link",
            "endLine": false,
            "link": "record_list.html"
        },
        "Archives": {
            "icon": "fas fa-fw fa-archive",
            "hasChildren": false,
            "priv": "all",
            "type": "link",
            "endLine": false,
            "link": "record_list_arc.html"
        },
        "Health Status Form": {
            "icon": "fas fa-fw fa-file-medical",
            "hasChildren": false,
            "priv": 1,
            "type": "link",
            "endLine": false,
            "link": "health_status_form.html"
        },
        "Announcements": {
            "icon": "fas fa-fw fa-newspaper",
            "hasChildren": false,
            "priv": "all",
            "type": "link",
            "endLine": false,
            "link": "announcements.html"
        },
        "Health Tips": {
            "icon": "fas fa-fw fa-medkit",
            "hasChildren": false,
            "priv": 1,
            "type": "link",
            "endLine": false,
            "link": "health_tips.html"
        },
        "Manage Account": {
            "icon": "fas fa-fw fa-cog",
            "hasChildren": false,
            "priv": "all",
            "type": "link",
            "endLine": false,
            "link": "update_info.html"
        }
        // "People": {
        //     "icon": "fas fa-fw fa-user",
        //     "hasChildren": true,
        //     "childNavs": {
        //         "Health Status Records": {
        //             "priv":"all",
        //             "type": "link",
        //             "link": ""
        //         },
        //         "Arrival Records": {
        //             "type": "link",
        //             "link": "fas fa-fw fa-users"
        //         }
        //     }
        // }
    };

    const navs_list = ["Registered Users",
        "Admin Accounts",
        "Records",
        "Archives",
        "Health Status Form",
        "Announcements",
        "Health Tips",
        "Manage Account"];

    // return $tab." ".$form;
    {/* <li class="nav-item">
<a class="nav-link" href="charts.html">
<i class="fas fa-fw fa-chart-area"></i>
<span>Charts</span></a>
</li>  */}

    var nav_str = ``;

    var tab = navs_list.indexOf(nav);
    if (tab < 0) {
        return;
    }


    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            //    console.log(this.responseText);

            if (!isNaN(this.responseText)) {
                var utype_js = Number(this.responseText);
                for (x = 0; x < navs_list.length; x++) {
                    set_nav = true;
                    if (navs[String(navs_list[x])]["priv"] != "all") {
                        if(navs[String(navs_list[x])]["priv"]!=utype_js){
                            set_nav=false;
                            
                        }
                    }
                    if (set_nav) {
                        var active = ``;
                        if (x == tab) {
                            active = ` active`;
                        }
                        nav_str +=
                            `<li class="nav-item` + active + `">
                <a class="nav-link" href="`+ navs[String(navs_list[x])]["link"] + `">
                    <i class="`+ navs[String(navs_list[x])]["icon"] + `"></i>
                    <span>`+ navs_list[x] + `</span></a>
            </li>`
            
                        if (navs[String(navs_list[x])]["endLine"]) {
                            nav_str += `<hr class="sidebar-divider my-0"></hr>`;
                        }
                    }
                }
            }

            //console.log(this.responseText);

        };

    }


    xhttp.open("GET", "./php/call_functions.php?x=get_admin_type", false);
    xhttp.send();
    


    return nav_str;

}