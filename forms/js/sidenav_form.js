function navs_adm(nav) {

    const navs = {
        "Announcements": {
            "icon": "fas fa-fw fa-newspaper",
            "hasChildren": false,
            "priv": "all",
            "type": "link",
            "endLine": true,
            "link": "announcements.html"
        },
        "Health Status Form": {
            "icon": "fas fa-fw fa-file-medical",
            "hasChildren": false,
            "priv": "all",
            "type": "link",
            "link": "../php/hst_direct.php"
        },
        "Health Tips": {
            "icon": "fas fa-fw fa-medkit",
            "hasChildren": false,
            "priv": "all",
            "type": "link",
            "endLine": false,
            "link": "health_tips.html"
        },
        "Manage Account": {
            "icon": "fas fa-fw fa-user",
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

    const navs_list = ["Announcements", "Health Status Form", "Health Tips", "Manage Account"];
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

    for (x = 0; x < navs_list.length; x++) {
        var active=``;
        if(x==tab){
            active=` active`;
        }
        nav_str+=
        `<li class="nav-item`+active+`">
            <a class="nav-link" href="`+navs[String(navs_list[x])]["link"]+`">
                <i class="`+navs[String(navs_list[x])]["icon"]+`"></i>
                <span>`+navs_list[x]+`</span></a>
        </li>`

        if(navs[String(navs_list[x])]["endLine"]){
            nav_str+=`<hr class="sidebar-divider my-0"></hr>`;
        }
    }

    return nav_str;
   
}

