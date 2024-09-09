
    var pass = document.getElementById("pass");
    var conpass = document.getElementById("conpass");
    var emp1 = document.getElementById("emp1");
    var emp2 = document.getElementById("emp2");
    var alert_elm = document.getElementById("alert");

function chk_pass() {

    alert_elm.hidden=true;
    conpass.setAttribute("style", "border-color:rgba(210,215,223,255);");
    emp2.hidden = true;
    pass.setAttribute("style", "border-color:rgba(210,215,223,255);");
    emp1.hidden = true;
    if (pass.value == "" || conpass.value == "") {
        if (conpass.value == "") {
            conpass.setAttribute("style", "border-color:red;");
            emp2.hidden = false;
        }

        if (pass.value == "") {
            pass.setAttribute("style", "border-color:red;");
            emp1.hidden = false;
        }

        return false;
    }


    if (pass.value != conpass.value) {
        alert_elm.innerHTML = 'Password did not match! <span aria-hidden="true" style="float: right;cursor: pointer;" onclick="alertdclose();">&times;</span>';
        alert_elm.setAttribute("class", "alert alert-warning");
        conpass.setAttribute("style", "border-color:red;");
        pass.setAttribute("style", "border-color:red;");
        alert_elm.hidden=false;
        return false;
    }

    return true;

}

function submit() {

    if(!chk_pass()){
        return;
    }
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {

        if (this.readyState == 4 && this.status == 200) {

            if (Number(this.responseText) == 1) {
                window.location.href = "reset_done.html";
                return;
            }
            console.log(this.responseText);
            alert_elm.setAttribute("class", "alert alert-danger");
            alert_elm.innerHTML = 'Something went wrong! <span aria-hidden="true" style="float: right;cursor: pointer;" onclick="alertdclose();">&times;</span>';
            alert_elm.hidden = false;
        };

    }
    var formdata = new FormData();
    formdata.append("pass", pass.value);

    xhttp.open("POST", "../php/reset_pass.php", true);
    xhttp.send(formdata);
}