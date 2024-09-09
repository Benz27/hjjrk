
var imgbase64 = "";
var fnm = "";
var interc = [true, true];
const elements = [
    "txtid",
    "txtfname",
    "txtlname",
    "txtmname",
    "txtaddr",
    "txtemail",
    "txtcontno",
    "txtdte",
    "txtpass",
    "txtconpass",
    "txtcity",
    "txtprov"];
const emps_str = ["emp1", "emp2", "emp3", "emp4", "emp5", "emp6", "emp7", "emp8", "emp9", "emp10", "emp11", "emp12"];
const emps = [];
const obj_elements = [];
const elm_cnt = elements.length;
const emp_cnt = emps_str.length;
set_elm();
function set_elm() {
    for (ob = 0; ob < elements.length; ob++) {
        obj_elements.push(document.getElementById(elements[ob]));
        emps.push(document.getElementById(emps_str[ob]));
    }

}

var vusertype = 0;

function alrt() {
    document.getElementById("alrt").hidden = true;
}
function alrt1() {
    document.getElementById("alrt1").hidden = true;
}
function alrt2() {
    document.getElementById("alrt2").hidden = true;
}

function alert_code() {
    document.getElementById("alert_code").hidden = true;
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
            emps[arr_base[x]].innerHTML = "This field cannot be empty!";
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

function usertype(x) {
    vusertype = x;
    if (x < 2) {
        document.getElementById("user_id").value = "";
    }

}

function close_mod() {
    $('#verify_modal').modal('hide');
}
function verify_email() {


    
 
    if (!interc[0] || !interc[1]) {
        return;
    }
    alrt1();
    alrt2();
    clear_mod();

    if (set_err([
        "txtid",
        "txtfname",
        "txtlname",
        "txtaddr",
        "txtemail",
        "txtcontno",
        "txtdte",
        "txtpass",
        "txtconpass",    
        "txtcity",
        "txtprov"], true)) {
        return;
    }
if(phoneValidate("txtcontno")){
    return;
}
if(passwordValidate("txtpass")){
    return;
}  
    if (obj_elements[8].value != obj_elements[9].value) {
        document.getElementById("alrt1").hidden = false;
        return;
    }
    load(2);
    $('#verify_modal').modal({
        backdrop: 'static',
        keyboard: false
    })
    $('#verify_modal').modal('show');
    submit_ver();
}

function code_check() {
    var code = document.getElementById("code");
    var emp = document.getElementById("emp_code");
    var alert_code = document.getElementById("alert_code");
    code.setAttribute("style", "border-color:rgba(210,215,223,255);");
    emp.innerHTML = "This field cannot be empty!";
    alert_code.hidden = true;
    emp.hidden = true;
    if (code.value == "") {
        code.setAttribute("style", "border-color:red");
        emp.hidden = false;
        return false;
    }
    return true;
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

function submit_ver() {

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {

        if (this.readyState == 4 && this.status == 200) {

            if (Number(this.responseText) == 1) {
                load(1);
                return;
            }
            console.log(this.responseText);
            load(3);


        };

    }
    var formdata = new FormData();
    formdata.append("email", document.getElementById("txtemail").value);



    xhttp.open("POST", "../php/contactform/submit_verify.php", true);
    xhttp.send(formdata);
}
function submit_code() {
    if (!code_check()) {
        return;
    }
    var code = document.getElementById("code");
    var emp = document.getElementById("emp_code");
    var alert_code = document.getElementById("alert_code");

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {

        if (this.readyState == 4 && this.status == 200) {

            if (Number(this.responseText) == 1) {
                save();

                return;
            }
            if (Number(this.responseText) == 0) {

                emp.innerHTML = "Invalid or expired code!";
                emp.hidden = false;
                code.setAttribute("style", "border-color:red");
                return;
            }
            console.log(this.responseText);
            alert_code.hidden = false;



        };

    }
    var formdata = new FormData();
    formdata.append("code", document.getElementById("code").value);



    xhttp.open("POST", "../php/send_ver.php", true);
    xhttp.send(formdata);
}

function save() {

    load(2);

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {

        if (this.readyState == 4 && this.status == 200) {

            if (Number(this.responseText) == 1) {
                load(4);
            } else {
                load(3);
                console.log(this.responseText);
                document.getElementById("alrt2").setAttribute("class", "alert alert-danger");
                document.getElementById("alrt2").innerHTML = 'Something went wrong! <span aria-hidden="true" style="float: right;cursor: pointer;" onclick="alrt2();">&times;</span>';
                document.getElementById("alrt2").hidden = false;
            }

        };

    }
    var formdata = new FormData();
    const columns = [
        ["user_id", "password", "usertype", "email"],
        ["user_id", "fname", "lname", "mname", "address", "email", "phone", "bday", "city", "province"]
    ];
    const types = [
        ["int", "string", "int", "string"],
        ["int", "string", "string", "string", "string", "string", "string", "date", "string", "string"]
    ];
    const values = [
        [
            obj_elements[0].value,
            obj_elements[8].value,
            document.getElementById("usertype").value,
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
            obj_elements[11].value,
        ]
    ];
    const tables = ["user", "info"];

    formdata.append("columns", JSON.stringify(columns));
    formdata.append("types", JSON.stringify(types));
    formdata.append("values", JSON.stringify(values));
    formdata.append("tables", JSON.stringify(tables));

    xhttp.open("POST", "../php/createacc.php", true);
    xhttp.send(formdata);


}

function toggle_pass(id, id2) {
    var x = document.getElementById(id2);
    if (x.type === "password") {
        x.type = "text";
        document.getElementById(id).setAttribute("class", "bi-eye-slash-fill");
    } else {
        x.type = "password";
        document.getElementById(id).setAttribute("class", "bi-eye-fill");
    }
}



function chk_elm(elm_id, column, table, err_msg, bool_ind) {
    var ind = Number(elements.indexOf(elm_id));
    var str = obj_elements[ind].value;
    var que = "phone";

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {

            var z = this.responseText;
            var x;
            var y = 0;
            y = Number(z);

            if (y == 1) {
                interc[bool_ind] = false;

            } else if (y == 0) {
                interc[bool_ind] = true;
            }


            if (y == 1) {
                obj_elements[ind].setAttribute("style", "border-color:red;");
                emps[ind].innerHTML = err_msg;
                emps[ind].hidden = false;
            } else {
                obj_elements[ind].setAttribute("style", "border-color:rgba(210,215,223,255);");
                emps[ind].innerHTML = "This field cannot be empty!";
                emps[ind].hidden = true;
            }


        }
    }

    xmlhttp.open("GET", "../php/checkuser.php?table=" + table + "&q=" + str + "&qu=" + column, true);
    xmlhttp.send();
}

function getid() {
    var str = document.getElementById("txtid").value;
    var que = "user_id";

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
                x = document.getElementById("txtid").value;
                document.getElementById("txtid").style.border = "2px solid red";
                document.getElementById("alertp3").innerHTML = "The ID was already registered!";
                document.getElementById("alertp3").hidden = false;
            } else {
                x = document.getElementById("txtid").value;
                document.getElementById("txtid").style.border = "1px solid #ced4da";
                document.getElementById("alertp3").hidden = true;
                document.getElementById("alertp3").innerHTML = "";
            }


        }
    }

    xmlhttp.open("GET", "../php/checkuser.php?table=user&q=" + str + "&qu=" + que, true);
    xmlhttp.send();
}




function ret_opt() {
    document.getElementById("primarylabel").innerHTML = "Register As?";
    document.getElementById("secondlabel").innerHTML = "Select an option below. ";
    document.getElementById("goback").hidden = true;
    var element = `<form id="form" method="post">

<div class="mt-4 mb-0">
<div class="d-grid col-5 m-auto"><button type="button"
    onclick="reg_as(0)" class="btn btn-success btn-block">School
    Employee</button></div>
</div>

<div class="mt-4 mb-0">
<div class="d-grid col-5 m-auto"><button type="button"
    onclick="reg_as(1)"
    class="btn btn-success btn-block">Student</button></div>
</div>

<div class="mt-4 mb-0">
<div class="d-grid col-5 m-auto"><button type="button"
    onclick="reg_as(2)"
    class="btn btn-success btn-block">Visitor</button></div>
</div>

</form>`;
    var doc = new DOMParser().parseFromString(element, "text/html");
    document.getElementById("cbody").innerHTML = "";
    document.getElementById("cbody").appendChild(doc.documentElement);
}

function reg_as(id) {
    document.getElementById("primarylabel").innerHTML = "Sign Up";
    document.getElementById("secondlabel").innerHTML = "Fill out the fields below. ";
    document.getElementById("goback").hidden = false;
    var cbtn = "Register";
    var id_label = "";
    var txtid_readonly = "";
    var gen_bool = false;
    var idgap = "";
    if (id == 0) {
        id_label = "Staff ID";

    } else if (id == 1) {
        id_label = "Student ID";

    } else if (id == 2) {
        id_label = "Visitor ID";

        txtid_readonly = "readonly";
        cbtn = "Confirm";

        gen_bool = true;
        idgap = " ";

    }

    var element = `<form id="form2" method="post">
        <div class="alert alert-danger" style="text-align:center" role="alert" id="alertp3" hidden>

</div>
                                        <div class="alert alert-danger" style="text-align:center" role="alert" id="alrt" hidden>

                                          </div>
                                          <div class="alert alert-danger" style="text-align:center" role="alert" id="alrt2" hidden>

                                        </div>
                                        <div class="alert alert-danger" style="text-align:center" role="alert" id="alert1" hidden>
                                            Password did not match! <span aria-hidden="true" style="float: right;cursor: pointer;" onclick="alrt1();">&times;</span>
                                </div>
                                        <input type="text" id="usertype" value="` + id + `" name="usertype" hidden>

                                        <div class="form-floating mb-3">
                                            <input class="form-control" name="txtid" onchange="getid()" id="txtid" placeholder="XXXXXXXXXXX" value="` + idgap + `" ` + txtid_readonly + ` maxlength="7" required/>
                                            <label for="inputID">`+ id_label + `</label>
                                            <small id="emp1" style="color: red;" hidden>This field cannot be empty!</small>
                                        </div>
                                        <hr>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="txtfname" type="text" name="fname" placeholder="Enter your first name" required/>
                                                    <label for="inputFirstName">First name</label>
                                                    <small id="emp2" style="color: red;" hidden>This field cannot be empty!</small>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating">
                                                    <input class="form-control" id="txtlname" type="text" name="lname" placeholder="Enter your last name"required/>
                                                    <label for="inputLastName">Last name</label>
                                                    <small id="emp3" style="color: red;" hidden>This field cannot be empty!</small>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating">
                                                    <input class="form-control" id="txtmname" type="text" name="mname" placeholder="Enter your middle name"required/>
                                                    <label for="inputLastName">Middle name</label>
                                                    <small id="emp4" style="color: red;" hidden>This field cannot be empty!</small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="txtaddr" type="address" name="addr"  placeholder="Street/Block, City, Province" onchange="" onclick=""required/>
                                            <label for="inputEmail">Address (Street/Block, City, Province)</label>
                                            <small id="emp5" style="color: red;" hidden>This field cannot be empty!</small>

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="txtemail" type="email" name="email"  placeholder="name@example.com" onchange="chk_elm('txtemail','email','user','Email was already taken!',0)" required/>
                                            <label for="inputEmail">Email address</label>
                                            <small id="emp6" style="color: red;" hidden>This field cannot be empty!</small>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="txtcontno" type="tel" name="phone"  placeholder="09XXXXXXXXX" onchange="chk_elm('txtcontno','phone','info','Phone number was already taken!',1)" required/>
                                            <label for="inputPhone">Phone</label>
                                            <small id="emp7" style="color: red;" hidden>This field cannot be empty!</small>

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="txtdte" type="date" name="dte"  placeholder=""required/>
                                            <label for="inputDoB">Date of Birth</label>
                                            <small id="emp8" style="color: red;" hidden>This field cannot be empty!</small>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                  <!--  <input class="form-control" id="txtpass" type="password" name="pass" placeholder="Create a password" required/>
                                                    <label for="inputPassword">Password</label> -->
<div class="input-group">
    <input class="form-control" id="txtpass" type="password" name="pass" placeholder="Create a password" required>

    <span class="input-group-append">
       <!-- <button class="btn ms-n4" type="button" onclick="toggle_pass('tpass','txtpass')">
            <i id="tpass" class="bi-eye-fill"></i>
        </button> -->
    </span>
</div>
<small id="emp9" style="color: red;" hidden>This field cannot be empty!</small>
                 </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <!-- <input class="form-control" id="txtconpass" type="password" name="conpass" placeholder="Confirm password" required/>
                                                    <label for="inputPasswordConfirm">Confirm Password</label> -->


<div class="input-group">
    <input class="form-control" id="txtconpass" type="password" name="conpass" placeholder="Confirm password" required>
    <span class="input-group-append">
        <button class="btn ms-n4" type="button" onclick="toggle_pass('tconpass','txtconpass')">
            <i id="tconpass" class="bi-eye-fill"></i>
        </button>
    </span>
</div>
<small id="emp10" style="color: red;" hidden>This field cannot be empty!</small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-4 mb-0">
                                            
                                            <div class="d-grid"><button type="button" onclick="save()" class="btn btn-success btn-block">`+ cbtn + `</button></div>
                                        </div>
                                    </form>`;
    var doc = new DOMParser().parseFromString(element, "text/html");
    document.getElementById("cbody").innerHTML = "";
    document.getElementById("cbody").appendChild(doc.documentElement);
    set_elm();
    if (gen_bool) {
        id_gen();
    }

}

function id_gen() {
    var gen_id = Math.floor((Math.random() * 9999999) + 1000000);
    var bool = false;

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {

            var z = this.responseText;
            if (isNaN(z)) {
                console.log(z);
                return;
            }
            document.getElementById("txtid").value = z;

        }
    }

    xmlhttp.open("GET", "../php/gen_vuser_id.php", true);
    xmlhttp.send();
}

function load(id) {
    if (id == 1) {
        document.getElementById("mbody").innerHTML = `<div class="form-group">
        <div class="alert alert-danger" style="text-align:center" hidden role="alert"
        id="alert_code">
        Something went wrong! <span aria-hidden="true" style="float: right;cursor: pointer;" onclick="alert_code();">&times;</span>
    </div>
        <p class="font-weight-light mt-4 text-center">A verification code has been sent to your email. Enter the code below 
            to continue your registration. The code will expire within 10 minutes.</p>
   
      <input type="text" class="form-control text-center" id="code">
      <div class="text-center mt-2">
        <span role="button" class="text-success font-weight-bold" onclick="load(2);submit_ver();">Resend Code</span>
    </div>
      <small id="emp_code" style="color: red;" hidden>This field cannot be empty!</small>
      <p class="font-weight-light mt-4 text-center"><i>Note: Check your spam messages if you did not receive the email from the inbox.</i></p>

    </div>`;

        document.getElementById("mfoot").innerHTML = `                
    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="close_mod()">Cancel</button>
    <button type="button" class="btn btn-success" onclick="submit_code();">Continue</button>`;

        return;
    }

    if (id == 2) {
        document.getElementById("mbody").innerHTML = `<div class="d-flex justify-content-center my-5 pb-3">
        <div class="spinner-border" role="status">
          <span class="sr-only"></span>
        </div>
      </div>`;

        document.getElementById("mfoot").innerHTML = ``;

        return;
    }
    if (id == 3) {
        document.getElementById("mbody").innerHTML = `<div class="alert alert-danger text-center" role="alert">
        Something went wrong on sending the email! Try again later.
        </div>`;

        document.getElementById("mfoot").innerHTML = `<button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="close_mod()">Close</button>        `;

        return;
    }
    if (id == 4) {
        document.getElementById("mbody").innerHTML = `<p class="font-weight-light mt-4 text-center"><b>You have been successfully registered!</b></p>`;

        document.getElementById("mfoot").innerHTML = `<a role="button" href="../login/" class="btn btn-success">Log In</a>`;

        return;
    }
}
