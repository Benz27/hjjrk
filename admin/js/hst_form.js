
        
const gp_label = document.getElementById("gp_label");
const qs_label = document.getElementById("qs_label");
const gp_name = document.getElementById("gp_name");
const qs_docs = [document.getElementById("qs_title"),
document.getElementById("qs_opt"),
document.getElementById("qs_cc")];
const gp_save = document.getElementById("gp_save");
const qs_save = document.getElementById("qs_save");
const del_btn = document.getElementById("del_btn");
const del_label = document.getElementById("del_label");
const del_p = document.getElementById("del_p");

const gp_id = []; //single
const qst_id = []; //double

var qst_obj = {};

var ids = 0;
const id = [];


const elements = [
    "gp_name",
    "qs_title",
    "qs_cc"];
const emps_str = ["emp1", "emp2", "emp3"];
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


function alertclose() {
    document.getElementById("alert").hidden = true;
}


get_ids();
function get_ids() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            // console.log(this.responseText);
            const obj = JSON.parse(this.responseText);
            const gp_id_loc = JSON.parse(obj[1]);
            const qst_id_loc = JSON.parse(obj[2]);

            var has_content = false;
            for (x = 0; x < gp_id_loc.length; x++) {
                has_content = true;
                gp_id.push(gp_id_loc[x]);
                qst_id.push([]);
                for (y = 0; y < qst_id_loc[x].length; y++) {
                    qst_id[x].push(qst_id_loc[x][y]);


                }

            }

            if (has_content) {
                qst_obj = JSON.parse(obj[3]);

                obj_to_div();
            }



        };
    }
    xhttp.open("GET", "./php/call_functions.php?x=get_q_sheet_ids", true);
    xhttp.send();
}

function obj_to_div() {
    for (var z = 0; z < gp_id.length; z++) {
        create_gp(gp_id[z], qst_obj[gp_id[z]]["name"], qst_id[z]);
    }
}




function create_gp(id, name, qst_arr) {
    var qsts = ``;
    var element = `<div class="card mb-4" style="background-color: rgb(189, 185, 185);" id="gp_id[` + id + `]">
                                    <!-- start of card content-->
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-md-5">
                                                        <label class="form-check-label" id="gp_name[` + id + `]">` + name + `</label>
                                            </div>
                                            <div class="col-md-2">
        <button class="form-control border-0" data-toggle="modal"
            data-target="#modal_qs" onclick="modal_qs(0,` + id + `)">Add <i
                class="fas fa-fw fa-plus"></i></button>
    </div>
    <div class="col-md-2">
        <button class="form-control border-0"
            data-toggle="modal" data-target="#modal_gp" onclick="modal_gp(` + id + `)">Edit <i
                class="fas fa-fw fa-edit"></i></button>
    </div>
    <div class="col-md-2">

        <button class="form-control border-0" data-toggle="modal"
            data-target="#modal_del" onclick="del_modal(` + id + `,0)">Delete <i
                class="fas fa-fw fa-trash"></i></button>
    </div>








    <div class="col-md-1 nav-item dropdown no-arrow">
    <button class="form-control border-0 nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-list fa-sm fa-fw mr-2 text-dark-400"></i>
    </button>

    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
        <button class="dropdown-item" onclick="move_gp(` + id + `, 1)">
            <i class="fas fa-arrow-up fa-sm fa-fw mr-2 text-gray-400"></i>
            Move Up
        </button>
        <button class="dropdown-item" onclick="move_gp(` + id + `, -1)">
            <i class="fas fa-arrow-down fa-sm fa-fw mr-2 text-gray-400"></i>
            Move Down
        </button>
    </div>

</div>




                                        </div>
                                    </div>
                                    <div class="card-body" id="gp_body[` + id + `]">`;

    for (var xy = 0; xy < qst_arr.length; xy++) {
        element += set_qs(id, qst_arr[xy]);

    }
    element += `</div>
                                    <!-- end of card content-->
                                </div>`;
    document.getElementById("primary").appendChild(ConvertStringToHTML(element));

}

function ConvertStringToHTML(str) {
    let parser = new DOMParser();
    let doc = parser.parseFromString(str, 'text/html');
    var body_doc = doc.body;
    return body_doc.childNodes[0];
};




function qs_type(type, label, name) {
    if (type == "text") {
        return `<div class="form-check mb-2">
                  <label class="small mb-1" for="">`+ label + `</label>
                  <input class="form-control" id="" type="text" placeholder="" value="" name="`+ name + `"/>
              </div>`;
    } if (type == "cbox") {
        return `<div class="form-check">
                   <input class="form-check-input" type="checkbox" value=""
                      id="" name="`+ name + `"/>
                   <label class="form-check-label" for="">
                                                            `+ label + `
                                                        </label>
                                                    </div>`;
    } else if (type == "radio") {
        return `<div class="form-check mb-2">
<input class="form-check-input" type="radio" name="`+ name + `" id="" />
<label class="form-check-label" for="">
`+ label + `
</label>
</div>`;
    }
}

function set_qs(gp_id, qst_id) {
    var labels = qst_obj[gp_id]["items"][qst_id]["labels"];
    var string = qst_obj[gp_id]["items"][qst_id]["string"];
    var type = qst_obj[gp_id]["items"][qst_id]["type"];
    var req_str = ``;
    if (qst_obj[gp_id]["items"][qst_id]["required"]) {
        req_str = `<span class="text-danger">*</span> `;
    }

    var name = gp_id + "_" + qst_id;
    var element = `<div class="card mb-4" id="qst_id[` + gp_id + `][` + qst_id + `]">
                                            <div class="card-header">

                                                <div class="row">

                                                    <div class="col-md-6">
                                                        <button class="form-control border-0" data-toggle="modal"
                                                            data-target="#modal_qs" onclick="modal_qs(` + qst_id + `,` + gp_id + `)">Edit <i
                                                                class="fas fa-fw fa-edit"></i></button>
                                                    </div>
                                                    <div class="col-md-5">

                                                        <button class="form-control border-0"data-toggle="modal"
            data-target="#modal_del" onclick="del_modal(` + gp_id + `,` + qst_id + `)">Delete <i
                                                                class="fas fa-fw fa-trash"></i></button>
                                                    </div>

                                                    <div class="col-md-1 nav-item dropdown no-arrow">
                                                    <button class="form-control border-0 nav-link dropdown-toggle" id="userDropdown" role="button"
                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-list fa-sm fa-fw mr-2 text-dark-400"></i>
                                                    </button>
                                            
                                                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                                        <button class="dropdown-item" onclick="move_qst(` + gp_id + `, ` + qst_id + `, 1)">
                                                            <i class="fas fa-arrow-up fa-sm fa-fw mr-2 text-gray-400"></i>
                                                            Move Up
                                                        </button>
                                                        <button class="dropdown-item" onclick="move_qst(` + gp_id + `, ` + qst_id + `, -1)">
                                                            <i class="fas fa-arrow-down fa-sm fa-fw mr-2 text-gray-400"></i>
                                                            Move Down
                                                        </button>
                                                    </div>
                                            
                                                </div>


                                                </div>
                                            </div>
                                            <div class="card-body" id="qst_body[`+ gp_id + `][` + qst_id + `]">
                                                <div class="col-12 m-3">

                                                        <p class="fw-bold">`+ req_str + string + `
                                                        </p>`;

    for (var x = 0; x < labels.length; x++) {
        element += qs_type(type, labels[x], name);
    }


    element += `</div>
                                            </div>
                                        </div>`;

    return element;

}

function mod_curr_gp(id, name) {
    document.getElementById("gp_name[" + id + "]").innerHTML = name;
}
function mod_curr_qst(gp_id, qst_id) {

    document.getElementById("gp_body[" + gp_id + "]").replaceChild(ConvertStringToHTML(set_qs(gp_id, qst_id))
        , document.getElementById("qst_id[" + gp_id + "][" + qst_id + "]"));
}
function gen_gp_id() {
    var id = Math.floor((Math.random() * 9000000) + 1000000);
    for (var g = 0; g < gp_id.length; g++) {

        if (id == gp_id[g]) {
            id = Math.floor((Math.random() * 9000000) + 1000000);
            g = 0;
        }
    }
    return id;
}

function mod_gp(id, name) {
    qst_obj[id]["name"] = name;
    mod_curr_gp(id, name);
}

function mod_qst(qst_id, gp_id, type, string, labels, req) {
    qst_obj[gp_id]["items"][qst_id] = {
        "type": type,
        "string": string,
        "labels": labels,
        "values": qst_values(type, labels),
        "ans": [],
        "required": req
    }

    mod_curr_qst(gp_id, qst_id);
}


function add_gp(name) {
    var id = gen_gp_id();
    qst_obj[id] = {
        "name": name,
        "items": {}
    }
    gp_id.push(id);
    qst_id.push([]);
    create_gp(id, name, []);
}

// function add_qst(gp_id, type, string, labels) {
//     var id = gen_gp_id();
//     qst_obj[gp_id]["items"][id] = {
//         "type": type,
//         "string": string,
//         "labels": labels,
//         "values": qst_values(type, labels),
//         "ans": []
//     }

//     document.getElementById("gp_body[" + gp_id + "]").appendChild(ConvertStringToHTML(set_qs(gp_id, id)));
// }

function add_qst(gp_id_loc, type, string, labels, req) {
    var id = gen_gp_id();
    qst_obj[gp_id_loc]["items"][id] = {
        "type": type,
        "string": string,
        "labels": labels,
        "values": qst_values(type, labels),
        "ans": [],
        "required": req
    }
    const index = gp_id.indexOf(gp_id_loc);
    qst_id[index].push(id);
    document.getElementById("gp_body[" + gp_id_loc + "]").appendChild(ConvertStringToHTML(set_qs(gp_id_loc, id)));
}


function qst_values(type, labels) {
    const values = [];
    for (var t = 0; t < labels.length; t++) {
        if (type == "text") {
            values.push("");
        } else if (type == "cbox") {
            values.push(t);
        } else if (type == "radio") {
            values.push(t);
        }
    }

    return values;
}


function modal_gp(x) {
    clear_all();
    gp_name.value = "";
    var label = "Add Group", onclick = "save_gp()";
    if (x != 0) {
        label = "Modify Group", onclick = "save_mod_gp(" + x + ")";
        gp_name.value = document.getElementById("gp_name[" + x + "]").innerHTML;
    }
    gp_label.innerHTML = label;
    gp_save.setAttribute("onclick", onclick);

}

function get_type(type) {
    if (type == "radio")
        return 0
    if (type == "cbox")
        return 1
    if (type == "text")
        return 2
}
function modal_qs(x, y) {
    //x=qst_id
    //y=gp_id
    clear_all();
    qs_docs[0].value = "";
    qs_docs[2].value = "";
    qs_docs[1].selectedIndex = 0;
    var label = "Add Item", onclick = "save_item(" + y + ")";

    if (x != 0) {
        label = "Modify Item", onclick = "save_mod_item(" + x + "," + y + ")";
        qs_docs[0].value = qst_obj[y]["items"][x]["string"];
        qs_docs[2].value = qst_obj[y]["items"][x]["labels"].join("\n");
        qs_docs[1].selectedIndex = get_type(qst_obj[y]["items"][x]["type"]);

        if (qst_obj[y]["items"][x]["required"]) {
            document.getElementById("qs_req").checked=true;

        }else{
            document.getElementById("qs_req").checked=false;
        }


    }
    qs_label.innerHTML = label;
    qs_save.setAttribute("onclick", onclick);

}

function delete_gp(gp_id_loc) {
    delete qst_obj[gp_id_loc];
    const index = gp_id.indexOf(gp_id_loc);
    gp_id.splice(index, 1);
    qst_id.splice(index, 1);


    document.getElementById("gp_id[" + gp_id_loc + "]").remove();
    $('#modal_del').modal('hide');
    // log();
}
function delete_qst(gp_id_loc, qst_id_loc) {
    delete qst_obj[gp_id_loc]["items"][qst_id_loc];
    const gp_index = gp_id.indexOf(gp_id_loc);
    const qst_index = qst_id[gp_index].indexOf(qst_id_loc);
    qst_id[gp_index].splice(qst_index, 1);

    document.getElementById("qst_id[" + gp_id_loc + "][" + qst_id_loc + "]").remove();
    $('#modal_del').modal('hide');
    // log();
}


function del_modal(gp_id, qst_id) {


    var label = "Delete Group", p = 'Are you sure you want to delete "' + qst_obj[gp_id]["name"] + '" group?', onclick = "delete_gp(" + gp_id + ")";
    if (qst_id != 0) {
        label = "Delete Item", p = 'Are you sure you want to delete "' + qst_obj[gp_id]["items"][qst_id]["string"] + '" item?', onclick = "delete_qst(" + gp_id + "," + qst_id + ")";
    }
    del_btn.setAttribute("onclick", onclick);
    del_label.innerHTML = label;
    del_p.innerHTML = p;
}
function save_item(id) {
    if (set_err(["qs_title", "qs_cc"], true)) {
        return;
    }
    var req = false;
    if (document.getElementById("qs_req").checked) {
        req = true;
    }

    var labels = qs_docs[2].value.split("\n");
    add_qst(id, qs_docs[1].value, qs_docs[0].value, labels, req);
    $('#modal_qs').modal('hide');
    // log();
}

function save_mod_item(qst_id, gp_id) {
    if (set_err(["qs_title", "qs_cc"], true)) {
        return;
    }
    var req = false;
    if (document.getElementById("qs_req").checked) {
        req = true;
    }
    var labels = qs_docs[2].value.split("\n");
    mod_qst(qst_id, gp_id, qs_docs[1].value, qs_docs[0].value, labels, req);
    $('#modal_qs').modal('hide');
    // log();
}


function save_gp() {
    if (set_err(["gp_name"], true)) {
        return;
    }
    add_gp(gp_name.value);
    $('#modal_gp').modal('hide');
    // log();
}

function save_mod_gp(id) {
    if (set_err(["gp_name"], true)) {
        return;
    }
    mod_gp(id, gp_name.value);
    $('#modal_gp').modal('hide');

    // log();
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

function clear_all() {

    for (var x = 0; x < elm_cnt; x++) {
        obj_elements[x].setAttribute("style", "border-color:rgba(210,215,223,255);");
        // obj_elements[x].value="";
        emps[x].hidden = true;
    }
}

function log() {

    console.log(gp_id);
    console.log(qst_id);
    console.log("----------------");
    console.log(qst_obj);
}

function save_q_sheet() {
    alertclose();
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var z = this.responseText;
            if (!isNaN(z)) {
                document.getElementById("alert").setAttribute("class", "mt-3 ml-auto w-25 alert alert-success text-center");
                document.getElementById("alert").innerHTML = 'Successfully saved!<span aria-hidden="true" style="float: right;cursor: pointer;" onclick="alertclose();">&times;</span>';
                document.getElementById("alert").hidden = false;
                return;
            }
            console.log(this.responseText);
            document.getElementById("alert").setAttribute("class", "mt-3 ml-auto alert alert-danger text-center");
            document.getElementById("alert").innerHTML = 'Something went wrong! <span aria-hidden="true" style="float: right;cursor: pointer;" onclick="alertclose();">&times;</span>';
            document.getElementById("alert").hidden = false;
        }
    }


    var formdata = new FormData();
    formdata.append("object_str", JSON.stringify(qst_obj));
    formdata.append("gp_ids", JSON.stringify(gp_id));
    formdata.append("qst_ids", JSON.stringify(qst_id));
    formdata.append("q_id", 1111111);



    xmlhttp.open("POST", "./php/call_functions.php?x=save_q_sheet", true);
    xmlhttp.send(formdata);
}



function move_qst(gp_id_loc, qst_id_loc, direction) {

    const gp_index = gp_id.indexOf(gp_id_loc);
    const qst_index = qst_id[gp_index].indexOf(qst_id_loc);
    var id_rep, id_rep_with = qst_id_loc;

    //1 = up, -1 = down
    if (direction == 1) {
        if (qst_index == 0) {
            return;
        }
        id_rep=qst_id[gp_index][qst_index-1];
        qst_id[gp_index][qst_index-1]=id_rep_with;

    } else if (direction == -1) {
        if (qst_index == qst_id[gp_index].length - 1) {
            return;
        }
        id_rep=qst_id[gp_index][qst_index+1];
        qst_id[gp_index][qst_index+1]=id_rep_with;
    }
    qst_id[gp_index][qst_index]=id_rep;
    const element = document.getElementById("gp_body["+gp_id_loc+"]");
    const node_rep = document.getElementById("qst_id["+gp_id_loc+"]["+id_rep+"]");
    const node_rep_with = document.getElementById("qst_id["+gp_id_loc+"]["+id_rep_with+"]");
    const ind_rep = Array.from(element.children).indexOf(node_rep);
    const ind_rep_with = Array.from(element.children).indexOf(node_rep_with);
    const node_1_clone = document.getElementById("qst_id["+gp_id_loc+"]["+id_rep+"]").cloneNode(true);
    const node_2_clone = document.getElementById("qst_id["+gp_id_loc+"]["+id_rep_with+"]").cloneNode(true);


    //rep node_rep with node_rep_with
    element.replaceChild(node_2_clone, element.children[ind_rep]);

    //rep node_rep_with with node_rep
    element.replaceChild(node_1_clone, element.children[ind_rep_with]);
    element.children[ind_rep].scrollIntoView();
}

function move_gp(gp_id_loc, direction) {

    const gp_index = gp_id.indexOf(gp_id_loc);
    var qst_ind_temp;
    var id_rep, id_rep_with = gp_id_loc;

    //1 = up, -1 = down
    if (direction == 1) {
        if (gp_index == 0) {
            return;
        }
        id_rep=gp_id[gp_index-1];
        gp_id[gp_index-1]=id_rep_with;
        qst_ind_temp=qst_id[gp_index-1];
        qst_id[gp_index-1]=qst_id[gp_index];

    } else if (direction == -1) {
        if (gp_index == gp_id.length - 1) {
            return;
        }
        id_rep=gp_id[gp_index+1];
        gp_id[gp_index+1]=id_rep_with;
        qst_ind_temp=qst_id[gp_index+1];
        qst_id[gp_index+1]=qst_id[gp_index];

    }
    qst_id[gp_index]=qst_ind_temp;
    gp_id[gp_index]=id_rep;




    const element = document.getElementById("primary");
    const node_rep = document.getElementById("gp_id["+id_rep+"]");
    const node_rep_with = document.getElementById("gp_id["+id_rep_with+"]");
    const ind_rep = Array.from(element.children).indexOf(node_rep);
    const ind_rep_with = Array.from(element.children).indexOf(node_rep_with);
    const node_1_clone = document.getElementById("gp_id["+id_rep+"]").cloneNode(true);
    const node_2_clone = document.getElementById("gp_id["+id_rep_with+"]").cloneNode(true);


    //rep node_rep with node_rep_with
    element.replaceChild(node_2_clone, element.children[ind_rep]);

    //rep node_rep with node_rep_with
    element.replaceChild(node_1_clone, element.children[ind_rep_with]);

    element.children[ind_rep].scrollIntoView();
}


