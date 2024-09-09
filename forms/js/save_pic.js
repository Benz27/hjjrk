document.getElementById("sidenav").innerHTML = navs_adm("Manage Account");
var imgbase64 = "";
var fnm = "";
const ifile = document.getElementById("ifile");
const img = document.getElementById("pfp");
const btn_save = document.getElementById("btn_save");
var ifile_name = "";
ifile.addEventListener('change', function (event) {

const uploadedFile = document.querySelector('#ifile').files[0];
toBase64(uploadedFile)
.then(res => {
imgbase64 = res;
btn_save.disabled = false;
})
.catch(err => {
imgbase64 = "";
btn_save.disabled = true;
console.log(err);
})

});

const toBase64 = file => new Promise((resolve, reject) => {
const reader = new FileReader();
reader.addEventListener('load', function () {

img.setAttribute('src', reader.result);
ifile_name = ifile.value.match(/[\/\\]([\w\d\s\.\-\(\)]+)$/)[1];

});

reader.readAsDataURL(file);
reader.onload = () => resolve(reader.result);
reader.onerror = error => reject(error);
});

function alertdclose() {
document.getElementById("alrtd").hidden = true;
}
function save_pfp() {

alertdclose();
var xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function () {

if (this.readyState == 4 && this.status == 200) {
console.log(this.responseText);
const objs=JSON.parse(this.responseText);
if (Number(objs[0]) == 1) {
    document.getElementById("alrtd").setAttribute("class", "alert alert-success");
    document.getElementById("alrtd").innerHTML = 'Update success! <span aria-hidden="true" style="float: right;cursor: pointer;" onclick="alertdclose();">&times;</span>';
    document.getElementById("alrtd").hidden = false;
    if(objs[1]==""){
        document.getElementById("img").setAttribute("src", "../img/empty.png");
    }else{
        document.getElementById("img").setAttribute("src", objs[1]);
    }
    ifile_name = "";
    imgbase64 = "";
    btn_save.disabled = true;
    return;
}

document.getElementById("alrtd").setAttribute("class", "alert alert-danger");
document.getElementById("alrtd").innerHTML = 'Something went wrong! <span aria-hidden="true" style="float: right;cursor: pointer;" onclick="alertdclose();">&times;</span>';
document.getElementById("alrtd").hidden = false;
};

}
var formdata = new FormData();
const columns = ["pic"];
const types = ["string"];
const values = [imgbase64];
const tables = ["info"];

formdata.append("fle_name", ifile_name);
formdata.append("columns", JSON.stringify(columns));
formdata.append("types", JSON.stringify(types));
formdata.append("values", JSON.stringify(values));
formdata.append("tables", JSON.stringify(tables));



xhttp.open("POST", "../php/edt_acc.php?fun=updt_pfp", true);
xhttp.send(formdata);
}

function clear_pic() {

ifile_name = "";
imgbase64 = "";

img.setAttribute("src", "../img/empty.png");
btn_save.disabled = false;
}