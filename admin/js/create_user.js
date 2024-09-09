
var imgbase64 = "";
var fnm = "";

const elements = [
    "user_id",
    "fname",
    "lname",
    "mname",
    "addr",
    "email",
    "contno",
    "dte",
    "pass",
    "conpass",
    "city",
    "prov"];
const emps_str=["emp13","emp2","emp3","emp6","emp7","emp8","emp9","emp10","emp11","emp12","emp14","emp15"];
const emps = [];
const obj_elements = [];
const elm_cnt = elements.length;
const emp_cnt = emps_str.length;

for (ob = 0; ob < elements.length; ob++) {
    obj_elements.push(document.getElementById(elements[ob]));
    emps.push(document.getElementById(emps_str[ob]));
}



var vusertype = 0;

var e = document.getElementById("email");
var cn = document.getElementById("contno");
var dte = document.getElementById("dte");
var pass = document.getElementById("pass");
var conpass = document.getElementById("conpass");
var user_id_inp = document.getElementById("user_id");
var rad1 = document.getElementById("rad1");
var rad2 = document.getElementById("rad2");
var rad3 = document.getElementById("rad3");


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
function clear_mod(elm_arr,act) {
    var indexes=[];
    var arr_base=[];
    var itr=0;
    if(elm_arr!=null){
        for(x=0;x<elm_arr.length;x++){
            if(isNaN(elm_arr[x])){
                indexes.push(Number(elements.indexOf(elm_arr[x])));
            }else{
                indexes.push(Number(elm_arr[x]));
            }
        }
    }else{
        clear_all();
        return;
    }
    
    if(act){
        itr=indexes.length;
        arr_base=indexes;
    }else{
        itr=elm_cnt;
        for(x=0;x<itr;x++){
            if(x!=indexes[x]){
                arr_base.push(x);
            }
        }
    }


    for(x=0;x<itr;x++){
        if (elements[x] != "prov") {
            obj_elements[arr_base[x]].setAttribute("style", "border-color:rgba(210,215,223,255);");
            // obj_elements[arr_base[x]].value="";
            emps[arr_base[x]].hidden = true;
        }
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

function clear_all() {

    for (x = 0; x < elm_cnt; x++) {
        if(elements[x]!="prov"){
            obj_elements[x].setAttribute("style", "border-color:rgba(210,215,223,255);");
            // obj_elements[x].value="";
            emps[x].hidden = true;
        }
       
    }
}

function set_err(elm_arr,act){
    var bool=false;
    var indexes=[];
    var arr_base=[];
    var itr=0;

    if(elm_arr!=null){
        for(x=0;x<elm_arr.length;x++){
            if(isNaN(elm_arr[x])){
                indexes.push(Number(elements.indexOf(elm_arr[x])));
            }else{
                indexes.push(Number(elm_arr[x]));
            }
        }
    }
    
    if(act){
        itr=indexes.length;
        arr_base=indexes;
    }else{
        itr=elm_cnt;
        for(x=0;x<itr;x++){
            if(x!=indexes[x]){
                arr_base.push(x);
            }
        }
    }


    for(x=0;x<itr;x++){
        if(obj_elements[arr_base[x]].value == ""){
            obj_elements[arr_base[x]].setAttribute("style", "border-color:red;");
            emps[arr_base[x]].hidden = false;
            bool=true;
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
        if(elements[x]!="prov"){
            obj_elements[x].value="";
            emps[x].hidden = true;
        }
    }

    rad1.checked = true;
    rad2.checked = false;
    rad3.checked = false;
}

function usertype(x,userid_label,user_id_placeholder) {
    vusertype = x;
    document.getElementById("userid_label").innerHTML=userid_label;
    document.getElementById("user_id").setAttribute('placeholder',user_id_placeholder);
    if (x < 2) {
        document.getElementById("user_id").value = "";
    }

}
function save() {
    if (!einterc && !pinterc) {

        alrt2();
        clear_mod();
        alrt1();
        if(set_err(["fname","lname","mname","email","contno","dte","addr",
        "user_id","pass","conpass","city","prov"],true)){
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
                    vusertype = 0;
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
        var formdata = new FormData();
    const columns=[
        ["user_id","password","usertype","email"],
        ["user_id","fname","lname","mname","address","email","phone","bday","city","province"]
    ];
    const types=[                
        ["int","string","int","string"],
        ["int","string","string","string","string","string","string","date","string","string"]
    ];
    const values=[
        [
            obj_elements[0].value, 
            obj_elements[8].value, 
            vusertype,
            obj_elements[5].value
        ],
        [
        obj_elements[0].value, 
        obj_elements[1].value, 
        obj_elements[2].value, 
        obj_elements[3].value,
        obj_elements[4].value, 
        obj_elements[5].value,  
        obj_elements[6].value, 
        obj_elements[7].value,
        obj_elements[10].value,
        obj_elements[11].value
        ]
    ];
    const tables=["user","info"];

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

    xmlhttp.open("GET", "../php/checkuser.php?table=user&q=" + str + "&qu=" + que, true);
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

    xmlhttp.open("GET", "../php/checkuser.php?table=info&q=" + str + "&qu=" + que, true);
    xmlhttp.send();
}

function getuserid() {
    var str = user_id_inp.value;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var z = this.responseText;
            var x;
            var y = false;
            y = Boolean(z);
            console.log(y);
            if (y) {
                pinterc = true;
            } else {
                pinterc = false;
            }
            if (y) {
                user_id_inp.style.border = "2px solid red";
                document.getElementById("emp13").hidden = false;
                document.getElementById("emp13").innerHTML = "This ID was already registered!";
            } else {
                user_id_inp.style.border = "1px solid #ced4da";
                document.getElementById("emp13").hidden = true;
                document.getElementById("emp13").innerHTML = "This field cannot be empty!";
            }
        }
    }

    xmlhttp.open("GET", "./php/check_id.php?id=" + str, true);
    xmlhttp.send();
}


function gen_id() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {

            var z = this.responseText;
            if (isNaN(z)) {
                console.log(z);
                return;
            }
            document.getElementById("user_id").value = Number(z);

        }
    }

    xmlhttp.open("GET", "./php/gen_vuser_id.php", true);
    xmlhttp.send();
}
