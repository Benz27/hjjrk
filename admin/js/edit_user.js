
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
    "city",
    "prov"];
const emps_str = ["emp2", "emp3", "emp4", "emp5", "emp8", "emp9", "emp10", "emp13", "emp14"];
const emps = [];
const obj_elements = [];
const elm_cnt = elements.length;
const emp_cnt = emps_str.length;

for (ob = 0; ob < elements.length; ob++) {
    obj_elements.push(document.getElementById(elements[ob]));
    emps.push(document.getElementById(emps_str[ob]));
}

const ifile = document.getElementById("ifile");
const img = document.querySelector('#my_img');
const inp = document.querySelector('#pic');


var e = document.getElementById("email");
var cn = document.getElementById("contno");

var pass = document.getElementById("pass");
var conpass = document.getElementById("conpass");

var einterc = false;
var pinterc = false;


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
        if (elements[x] != "prov") {
            obj_elements[arr_base[x]].setAttribute("style", "border-color:rgba(210,215,223,255);");
            // obj_elements[arr_base[x]].value="";
            emps[arr_base[x]].hidden = true;
        }
    }

}



function clear_all() {

    for (x = 0; x < elm_cnt; x++) {
        if (elements[x] != "prov") {
            obj_elements[x].setAttribute("style", "border-color:rgba(210,215,223,255);");
            // obj_elements[x].value="";
            emps[x].hidden = true;
        }
    }
}

function clear_val() {

    f.value = "";
    l.value = "";
    e.value = "";
    cn.value = "";
    dte.value = "";


}



function alertclose() {
    document.getElementById("alrt").hidden = true;

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

function get_usertype() {
    if (document.getElementById("rad1").checked) {
        return 0;
    }
    if (document.getElementById("rad2").checked) {
        return 1;
    }
}


function phoneValidate(obj_name) {
    const ind = Number(elements.indexOf(obj_name));
    var phone = obj_elements[ind].value;
    var regex = /^(?=.*[0-9])[a-zA-Z0-9!@#$%^&*]{11,11}$/;
    var validate = phone.match(regex);
    console.log(validate);
    if (validate === null) {
        obj_elements[ind].setAttribute("style", "border-color:red;");
        emps[ind].innerHTML = "Invalid format!";
        emps[ind].hidden = false;
        return true;
    }
    obj_elements[ind].setAttribute("style", "border-color:rgba(210,215,223,255);");
    emps[ind].hidden = true;
    return false;
}


function passwordValidate(obj_name, emp) {
    const element = document.getElementById(obj_name);
    const emps = document.getElementById(emp);

    var pass = element.value;
    var regex = /^(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,12}$/;
    var validate = pass.match(regex);
    console.log(validate);
    if (validate === null) {
        element.setAttribute("style", "border-color:red;");
        emps.innerHTML = "Password must contain atleast one number, one uppercase and lowercase letter and a special character with minimum of 8 and maximum of 12 characters!";
        emps.hidden = false;
        return true;
    }
    element.setAttribute("style", "border-color:rgba(210,215,223,255);");
    emps.hidden = true;
    return false;
}

function save(id) {
    if (!einterc && !pinterc) {
        clear_mod();

        if (set_err(["fname", "lname", "mname", "email", "contno", "dte", "addr", "city",
            "prov"], true)) {
            return;
        }
        if (phoneValidate("contno")) {
            return;
        }


        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) {

                clear_mod();

                if (Number(this.responseText) == 1) {
                    document.getElementById("alrtd").setAttribute("class", "alert alert-success");
                    document.getElementById("alrtd").innerHTML = 'Update success! <span aria-hidden="true" style="float: right;cursor: pointer;" onclick="alertdclose();">&times;</span>';
                    document.getElementById("alrtd").hidden = false;
                } else {
                    console.log(this.responseText);
                    document.getElementById("alrtd").setAttribute("class", "alert alert-danger");
                    document.getElementById("alrtd").innerHTML = 'Something went wrong! <span aria-hidden="true" style="float: right;cursor: pointer;" onclick="alertdclose();">&times;</span>';
                    document.getElementById("alrtd").hidden = false;
                }

            };

        }
        var formdata = new FormData();


        const columns = ["fname", "lname", "mname", "address", "email", "phone", "bday", "city", "province","usertype"];
        const types = ["string", "string", "string", "string", "string", "string", "date", "string", "string","int"];
        const values = [obj_elements[0].value,
        obj_elements[1].value,
        obj_elements[2].value,
        obj_elements[3].value,
        obj_elements[4].value,
        obj_elements[5].value,
        obj_elements[6].value,
        obj_elements[7].value,
        obj_elements[8].value,
        get_usertype()
        ];
        const tables = ["user", "info"];

        formdata.append("columns", JSON.stringify(columns));
        formdata.append("types", JSON.stringify(types));
        formdata.append("values", JSON.stringify(values));
        formdata.append("tables", JSON.stringify(tables));
        formdata.append("id", id);


        xhttp.open("POST", "./php/edtacc.php?fun=updt", true);
        xhttp.send(formdata);

    }
}

function saveinfo(id) {


    pass.setAttribute("style", "border-color:rgba(210,215,223,255);");
    conpass.setAttribute("style", "border-color:rgba(210,215,223,255);");

    for (x = 11; x < 13; x++) {
        document.getElementById("emp" + x).hidden = true;
    }
    document.getElementById("alrt").setAttribute("class", "");
    document.getElementById("alrt").innerHTML = "";
    document.getElementById("alrt").hidden = true;
    if (pass.value == "" || conpass.value == "") {

        if (pass.value == "") {
            pass.setAttribute("style", "border-color:red;");
            document.getElementById("emp11").innerHTML = "This field cannot be empty!";
            document.getElementById("emp11").hidden = false;
        }
        if (conpass.value == "") {
            conpass.setAttribute("style", "border-color:red;");
            document.getElementById("emp12").hidden = false;
        }
        return;

    }
    if (passwordValidate("pass", "emp11")) {
        return;
    }

    if (pass.value != conpass.value) {
        document.getElementById("alrt").setAttribute("class", "alert alert-warning");
        document.getElementById("alrt").innerHTML = 'Password did not match! <span aria-hidden="true" style="float: right;cursor: pointer;" onclick="alertclose();">&times;</span>';
        document.getElementById("alrt").hidden = false;
        pass.value = "";
        conpass.value = "";
        return;
    }


    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {

        if (this.readyState == 4 && this.status == 200) {

            if (Number(this.responseText) == 1) {
                pass.value = "";
                conpass.value = "";
                document.getElementById("alrt").setAttribute("class", "alert alert-success");
                document.getElementById("alrt").innerHTML = 'Password changed! <span aria-hidden="true" style="float: right;cursor: pointer;" onclick="alertclose();">&times;</span>';
                document.getElementById("alrt").hidden = false;
            } else {
                console.log(this.responseText);
                pass.value = "";
                conpass.value = "";
                document.getElementById("alrt").setAttribute("class", "alert alert-danger");
                document.getElementById("alrt").innerHTML = 'Something went wrong! <span aria-hidden="true" style="float: right;cursor: pointer;" onclick="alertclose();">&times;</span>';
                document.getElementById("alrt").hidden = false;
            }

        };

    }
    var formdata = new FormData();
    formdata.append("pass", pass.value);
    formdata.append("id", id);
    xhttp.open("POST", "./php/edtacc.php?fun=chngpass", true);
    xhttp.send(formdata);


}

function delacc(id) {

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {

        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            if (Number(this.responseText) == 1) {
                window.location.href = "users.html";
            }

        };

    }
    var formdata = new FormData();
    formdata.append("id", id);


    xhttp.open("POST", "./php/edtacc.php?fun=delacc", true);
    xhttp.send(formdata);


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









ifile.addEventListener('change', function (event) {

    const uploadedFile = document.querySelector('#ifile').files[0];
    toBase64(uploadedFile)
        .then(res => {
            imgbase64 = res;
            inp.value = imgbase64;
        })
        .catch(err => {
            imgbase64 = err;
            console.log(err);
        })

});

const toBase64 = file => new Promise((resolve, reject) => {
    const reader = new FileReader();
    reader.addEventListener('load', function () {

        img.setAttribute('src', reader.result);
        fnm = ifile.value.match(/[\/\\]([\w\d\s\.\-\(\)]+)$/)[1];

    });

    reader.readAsDataURL(file);
    reader.onload = () => resolve(reader.result);
    reader.onerror = error => reject(error);
});

