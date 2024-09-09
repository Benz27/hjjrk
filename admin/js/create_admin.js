
var imgbase64 = "";
var fnm = "";
const elements = [
    "fname",
    "lname",
    "mname",
    "addr",
    "email",
    "contno",
    "dte",
    "pass",
    "conpass"];
const emps_str = ["emp2", "emp3", "emp4", "emp5", "emp8", "emp9", "emp10", "emp11", "emp12"];
const emps = [];
const obj_elements = [];
const elm_cnt = elements.length;
const emp_cnt = emps_str.length;

for (ob = 0; ob < elements.length; ob++) {
    obj_elements.push(document.getElementById(elements[ob]));
    emps.push(document.getElementById(emps_str[ob]));
}

var e = document.getElementById("email");
var cn = document.getElementById("contno");
var dte = document.getElementById("dte");
var pass = document.getElementById("pass");
var conpass = document.getElementById("conpass");
var un = document.getElementById("uname");

var einterc = false;
var pinterc = false;


function alrt() {
    document.getElementById("alrt").hidden = true;
}

function alrt2() {
    document.getElementById("alrt2").hidden = true;
}
function alrt1() {
    document.getElementById("alrt1").hidden = true;
}
function clear_mod(elm_arr, act) {
    var indexes = [];
    var arr_base = [];
    var itr = 0;
    if (elm_arr != null) {
        for (x = 0; x < elm_arr.length; x++) {
            if (isNaN(elm_arr[x])) {
                indexes.push(Number(elements.indexOf(elm_arr[x])));
            } else {
                indexes.push(Number(elm_arr[x]));
            }
        }
    } else {
        clear_all();
        return;
    }

    if (act) {
        itr = indexes.length;
        arr_base = indexes;
    } else {
        itr = elm_cnt;
        for (x = 0; x < itr; x++) {
            if (x != indexes[x]) {
                arr_base.push(x);
            }
        }
    }


    for (x = 0; x < itr; x++) {
        obj_elements[arr_base[x]].setAttribute("style", "border-color:rgba(210,215,223,255);");
        // obj_elements[arr_base[x]].value="";
        emps[arr_base[x]].hidden = true;
    }

}



function clear_all() {

    for (x = 0; x < elm_cnt; x++) {
        obj_elements[x].setAttribute("style", "border-color:rgba(210,215,223,255);");
        // obj_elements[x].value="";
        emps[x].hidden = true;
    }
}

function set_err(elm_arr, act) {
    var bool = false;
    var indexes = [];
    var arr_base = [];
    var itr = 0;

    if (elm_arr != null) {
        for (x = 0; x < elm_arr.length; x++) {
            if (isNaN(elm_arr[x])) {
                indexes.push(Number(elements.indexOf(elm_arr[x])));
            } else {
                indexes.push(Number(elm_arr[x]));
            }
        }
    }

    if (act) {
        itr = indexes.length;
        arr_base = indexes;
    } else {
        itr = elm_cnt;
        for (x = 0; x < itr; x++) {
            if (x != indexes[x]) {
                arr_base.push(x);
            }
        }
    }


    for (x = 0; x < itr; x++) {
        if (obj_elements[arr_base[x]].value == "") {
            obj_elements[arr_base[x]].setAttribute("style", "border-color:red;");
            emps[arr_base[x]].hidden = false;
            bool = true;
        }
    }
    return bool;

}



function clear_val() {

    // f.value = "";
    // l.value = "";
    // e.value = "";
    // cn.value = "";
    // dte.value = "";
    // user_id_inp.value = "";
    // pass.value = "";
    // conpass.value = "";


    for (x = 0; x < elm_cnt; x++) {

        obj_elements[x].value = "";
        emps[x].hidden = true;
    }

}
function passwordValidate(obj_name){
    const ind=Number(elements.indexOf(obj_name));
    var pass=obj_elements[ind].value;
    var regex=/^(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,12}$/;
    var validate=pass.match(regex);
    console.log(validate);
    if(validate===null){
        obj_elements[ind].setAttribute("style", "border-color:red;");
        emps[ind].innerHTML = "Password must contain atleast one number, one uppercase and lowercase letter and a special character with minimum of 8 and maximum of 12 characters!";
        emps[ind].hidden = false;
        return true;
    }
    obj_elements[ind].setAttribute("style", "border-color:rgba(210,215,223,255);");
    emps[ind].hidden = true;
    return false;
}

function phoneValidate(obj_name){
    const ind=Number(elements.indexOf(obj_name));
    var phone=obj_elements[ind].value;
    var regex=/^(?=.*[0-9])[a-zA-Z0-9!@#$%^&*]{11,11}$/;
    var validate=phone.match(regex);
    console.log(validate);
    if(validate===null){
        obj_elements[ind].setAttribute("style", "border-color:red;");
        emps[ind].innerHTML = "Invalid format!";
        emps[ind].hidden = false;
        return true;
    }
    obj_elements[ind].setAttribute("style", "border-color:rgba(210,215,223,255);");
    emps[ind].hidden = true;
    return false;
}


function save() {
    if (!einterc && !pinterc) {

        alrt2();
        clear_mod();
        alrt1();
        if (set_err(["fname", "lname", "mname", "email", "contno", "dte", "addr", "conpass", "pass"], true)) {
            return;
        }
        if(phoneValidate("contno")){
            return;
        }

        if(passwordValidate("pass")){
            return;
        }

        if (pass.value != conpass.value) {
            document.getElementById("alrt1").hidden = false;
            pass.value = "";
            conpass.value = "";
            return;
        }


        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) {

                if (Number(this.responseText) == 1) {

                    clear_val();
                    clear_mod();
                    document.getElementById("alrt2").setAttribute("class", "alert alert-success");
                    document.getElementById("alrt2").innerHTML = 'Account saved! <span aria-hidden="true" style="float: right;cursor: pointer;" onclick="alrt2();">&times;</span>';
                    document.getElementById("alrt2").hidden = false;
                } else {
                    console.log(this.responseText);
                    document.getElementById("alrt2").setAttribute("class", "alert alert-danger");
                    document.getElementById("alrt2").innerHTML = 'Something went wrong! <span aria-hidden="true" style="float: right;cursor: pointer;" onclick="alrt2();">&times;</span>';
                    document.getElementById("alrt2").hidden = false;
                }

            };

        }

        // "fname", 0
        // "lname", 1
        // "mname", 2
        // "addr", 3 
        // "email", 4
        // "contno", 5 
        // "dte", 6
        // "pass", 7
        // "conpass" 8


        var formdata = new FormData();
        const columns = [
            ["password", "usertype", "email"],
            ["fname", "lname", "mname", "address", "email", "phone", "bday"]
        ];
        const types = [
            ["string", "int", "string"],
            ["string", "string", "string", "string", "string", "string", "date"]
        ];
        const values = [
            [
                obj_elements[7].value,
                1,
                obj_elements[4].value
            ],
            [
                obj_elements[0].value,
                obj_elements[1].value,
                obj_elements[2].value,
                obj_elements[3].value,
                obj_elements[4].value,
                obj_elements[5].value,
                obj_elements[6].value
            ]
        ];
        const tables = ["admin", "admin_info"];

        formdata.append("columns", JSON.stringify(columns));
        formdata.append("types", JSON.stringify(types));
        formdata.append("values", JSON.stringify(values));
        formdata.append("tables", JSON.stringify(tables));

        xhttp.open("POST", "./php/createacc.php", true);
        xhttp.send(formdata);

    }
}




function getuser() {
    var str = e.value;
    var que = "email";

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var z = this.responseText;
            var x;
            var y = 0;
            y = Number(z);

            if (y == 1) {
                einterc = true;
            } else if (y == 0) {
                einterc = false;
            }


            if (y == 1) {
                x = e.value;
                e.style.border = "2px solid red";
                document.getElementById("emp8").hidden = false;
                document.getElementById("emp8").innerHTML = "Email was already taken!";
                // document.getElementById("alertp").innerHTML="Email was already taken!";
                // document.getElementById("alertp").hidden=false;
            } else {
                x = e.value;
                e.style.border = "1px solid #ced4da";
                document.getElementById("emp8").hidden = true;
                document.getElementById("emp8").innerHTML = "This field cannot be empty!";
                // document.getElementById("alertp").hidden=true;
                // document.getElementById("alertp").innerHTML="";
            }

        }
    }

    xmlhttp.open("GET", "../php/checkuser.php?table=admin&q=" + str + "&qu=" + que, true);
    xmlhttp.send();
}

function getphone() {
    var str = cn.value;
    var que = "phone";

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {

            var z = this.responseText;
            var x;
            var y = 0;
            y = Number(z);

            if (y == 1) {
                pinterc = true;
            } else if (y == 0) {
                pinterc = false;
            }


            if (y == 1) {
                x = cn.value;
                cn.style.border = "2px solid red";
                document.getElementById("emp9").hidden = false;
                document.getElementById("emp9").innerHTML = "Phone was already taken!";
                // document.getElementById("alertp2").innerHTML="Phone was already taken!";
                // document.getElementById("alertp2").hidden=false;

            } else {
                x = cn.value;
                cn.style.border = "1px solid #ced4da";
                document.getElementById("emp9").hidden = true;
                document.getElementById("emp9").innerHTML = "This field cannot be empty!";
                // document.getElementById("alertp2").hidden=true;
                // document.getElementById("alertp2").innerHTML="";
            }


        }
    }

    xmlhttp.open("GET", "../php/checkuser.php?table=admin_info&q=" + str + "&qu=" + que, true);
    xmlhttp.send();
}


function getuname() {
    var str = un.value;
    var que = "username";

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var z = this.responseText;
            var x;
            var y = 0;
            y = Number(z);

            if (y == 1) {
                einterc = true;
            } else if (y == 0) {
                einterc = false;
            }

            if (y == 1) {
                un.style.border = "2px solid red";
                document.getElementById("emp1").hidden = false;
                document.getElementById("emp1").innerHTML = "Username was already taken!";
                // document.getElementById("alertp").innerHTML="Email was already taken!";
                // document.getElementById("alertp").hidden=false;
            } else {

                un.style.border = "1px solid #ced4da";
                document.getElementById("emp1").hidden = true;
                document.getElementById("emp1").innerHTML = "This field cannot be empty!";
                // document.getElementById("alertp").hidden=true;
                // document.getElementById("alertp").innerHTML="";
            }

        }
    }

    xmlhttp.open("GET", "../php/checkuser.php?table=admin&q=" + str + "&qu=" + que, true);
    xmlhttp.send();
}

