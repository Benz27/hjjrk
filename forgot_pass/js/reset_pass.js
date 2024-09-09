
const elements = [
    "email"];
const emps_str = ["emp1"];
const emps = [];
const obj_elements = [];
const elm_cnt = elements.length;
const emp_cnt = emps_str.length;

for (ob = 0; ob < elements.length; ob++) {
    obj_elements.push(document.getElementById(elements[ob]));
    emps.push(document.getElementById(emps_str[ob]));
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
        emps[x].innerHTML = "This field cannot be empty!";
        emps[x].hidden = true;
    }
}



function alertdclose() {
    document.getElementById("alrtd").hidden = true;
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

function resend() {
    load(3);
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {

        if (this.readyState == 4 && this.status == 200) {

            if (Number(this.responseText) == 1) {
                load(2);
                return;
            }
            console.log(this.responseText);
            load(4);
        };

    }
    var formdata = new FormData();
    formdata.append("email", global_email);



    xhttp.open("POST", "../php/contactform/submit.php", true);
    xhttp.send(formdata);
}



function submit() {

    load(0);
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {

        if (this.readyState == 4 && this.status == 200) {

            if (Number(this.responseText) == 1) {
                load(2);
                return;
            }
            console.log(this.responseText);
            document.getElementById("alrtd").setAttribute("class", "alert alert-danger");
            document.getElementById("alrtd").innerHTML = 'Something went wrong! <span aria-hidden="true" style="float: right;cursor: pointer;" onclick="alertdclose();">&times;</span>';
            document.getElementById("alrtd").hidden = false;
            load(1);
        };

    }
    var formdata = new FormData();
    const values = obj_elements[0].value;
    formdata.append("email", values);



    xhttp.open("POST", "../php/contactform/submit.php", true);
    xhttp.send(formdata);
}

function chk_elm() {
    clear_mod();
    if (set_err(["email"], true)) {
        return;
    }


    var ind = Number(elements.indexOf("email"));
    var str = obj_elements[ind].value;
    global_email = obj_elements[ind].value;
    var column = "email";
    var table = "user";
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {

            var z = this.responseText;
            var y;
            y = Number(z);
            if (y == 0) {
                obj_elements[ind].setAttribute("style", "border-color:red;");
                emps[ind].innerHTML = "Email not found!";
                emps[ind].hidden = false;

            } else {
                obj_elements[ind].setAttribute("style", "border-color:rgba(210,215,223,255);");
                emps[ind].innerHTML = "This field cannot be empty!";
                emps[ind].hidden = true;

                submit();
            }


        }
    }

    xmlhttp.open("GET", "../php/checkuser.php?table=" + table + "&q=" + str + "&qu=" + column, true);
    xmlhttp.send();
}




function chk_code(id) {
    var code = document.getElementById("code");
    var emp = document.getElementById("emp1");
    code.setAttribute("style", "border-color:rgba(210,215,223,255);");
    emp.innerHTML = "This field cannot be empty!";
    emp.hidden = true;
    if (id == 0) {

        if (code.value == "") {
            code.setAttribute("style", "border-color:red;");
            emp.hidden = false;
            return false;
        }

        return true;
    }
        var hold=code.value;
        load(2);
        var code = document.getElementById("code");
        var emp = document.getElementById("emp1");
        code.setAttribute("style", "border-color:rgba(210,215,223,255);");
        emp.innerHTML = "This field cannot be empty!";
        emp.hidden = true;
        code.value=hold;
        emp.innerHTML = "Invalid code!";
        code.setAttribute("style", "border-color:red;");
        emp.hidden = false;

        return;
           
}


function reset_pass() {
    if (!chk_code(0)) {
        return;
    }
    load(6);
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {

        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            if (Number(this.responseText) > 0) {
                window.location.href = "../reset_pass/?s="+Number(this.responseText);
                return;
            }

            if (Number(this.responseText) == 0) {
                chk_code(1);
                console.log("Wrong");
                return;
            }
 
            if (Number(this.responseText) == -1) {
                load(5);
                return;
            }
            
            load(7);
        };

    }
  
    const values = document.getElementById("code").value;


    xhttp.open("GET", "../php/reset_pass.php?pass="+values, true);
    xhttp.send();




}
function load(id) {
    var str;
    if (id == 0) {
        str = `<div class="d-flex justify-content-center py-5">
<div class="spinner-border" role="status">
  <span class="sr-only"></span>
</div>
</div>`;
        document.getElementById("email").readOnly = true;
        document.getElementById("btns").innerHTML = str;
    }
    else if (id == 2) {
        str = `<div class="card-header">
        <h3 class="font-weight-light mt-4 text-center" id="primarylabel">Code Sent</h3>
        <p class="font-weight-light mt-4 text-center">A code has been sent to your email. Enter the code below 
        to reset your password. The code will expire within 30 minutes.</p>
        <div class="form-floating mb-3">
        <input class="form-control text-center" id="code" type="text"
            placeholder="XXXXXXX" name="code" />
        <label for="inputEmail">Enter the code here</label>
        <small id="emp1" style="color: red;" hidden>This field cannot be
            empty!</small>

    </div>

        <p class="font-weight-light mt-4 text-center"><i>Note: Check your spam messages if you did not receive the email from the inbox.</i></p>
    </div>
    <div id="btns">
   
    <div class="d-flex align-items-center justify-content-center mt-2 mb-3">
    <button class="btn btn-success" onclick="reset_pass();"
        type="button">Continue</button>
</div>
    <div class="card-footer text-center py-1">
        <div class="Strong"><span role="button" class="text-success font-weight-bold" onclick="resend()">Resend</span></div>
    </div>    
    <div class="card-footer text-center py-3">
    <div class="small"><a href="../login/">Go back.</a></div>
    </div>
    </div>
`;
        document.getElementById("main").innerHTML = str;
    } else if (id == 3) {
        str = `<div class="card-header">
          <h3 class="font-weight-light mt-4 text-center" id="primarylabel">Resending Code</h3>
          <p class="font-weight-light mt-4 text-center">Please wait...</p>
          <p class="font-weight-light mt-4 text-center"><i>Note: Check your spam messages if you did not receive the email from the inbox.</i></p>
      </div>
      <div class="d-flex justify-content-center py-5">
      <div class="spinner-border" role="status">
        <span class="sr-only"></span>
      </div>
      </div>`;
        document.getElementById("main").innerHTML = str;
    }
    else if (id == 4) {
        str = `<div class="card-header">
          <h3 class="font-weight-light mt-4 text-center" id="primarylabel">Something went wrong!</h3>
          <p class="font-weight-light mt-4 text-center">Something went wrong on resending the code.</p>
      </div>
      <div class="card-footer text-center py-1">
      <div class="Strong"><span role="button" class="text-success font-weight-bold" onclick="resend()">Resend</span></div>
  </div>    
  <div class="card-footer text-center py-3">
  <div class="small"><a href="../login/">Go back.</a></div>
  </div>`;
        document.getElementById("main").innerHTML = str;
    }
    else if (id == 5) {
        str = `<div class="card-header">
          <h3 class="font-weight-light mt-4 text-center" id="primarylabel">Something went wrong!</h3>
          <p class="font-weight-light mt-4 text-center">Something went wrong on resending the code.</p>
      </div>
      <div class="card-footer text-center py-1">
      <div class="Strong"><span role="button" class="text-success font-weight-bold" onclick="resend()">Resend</span></div>
  </div>    
  <div class="card-footer text-center py-3">
  <div class="small"><a href="../login/">Go back.</a></div>
  </div>`;
        document.getElementById("main").innerHTML = str;
    }
    else if (id == 6) {
        str = `<div class="d-flex justify-content-center py-5">
        <div class="spinner-border" role="status">
          <span class="sr-only"></span>
        </div>
        </div>`;
        document.getElementById("btns").innerHTML = str;
    }
    else if (id == 7) {
        str = ` <div class="d-flex align-items-center justify-content-center mt-2 mb-3">
        <button class="btn btn-success" onclick="reset_pass();"
            type="button">Continue</button>
    </div>
        <div class="card-footer text-center py-1">
            <div class="Strong"><span role="button" class="text-success font-weight-bold" onclick="resend()">Resend</span></div>
        </div>    
        <div class="card-footer text-center py-3">
        <div class="small"><a href="../login/">Go back.</a></div>
        </div>`;
        document.getElementById("btns").innerHTML = str;
    }
    else {
        str = `<div class="d-flex align-items-center justify-content-center mt-2 mb-3">
        <button class="btn btn-success" onclick="chk_elm();"
            type="button">Send</button>
    </div>
    <div class="card-footer text-center py-3">
        <div class="small"><a href="../login/">Go back.</a></div>
    </div>`;
        document.getElementById("email").readOnly = false;
        document.getElementById("btns").innerHTML = str;
    }



}

