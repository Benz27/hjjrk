var obj_elm = [];
var page = 0;

if (get_qst(true) === undefined) {
    get_qst(false);
}
load(page);
btns(page);
function get_qst(async) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            // console.log(this.responseText);
            const obj = JSON.parse(this.responseText);
            obj_elm=[];
            for (o = 0; o < obj.length; o++) {
                obj_elm.push(String(obj[o]));
            }
            return 1;
        };
    }
    xhttp.open("POST", "./php/disp_ht_form_qs.php", async);
    xhttp.send();
}


function get_to_div(act) {
    page += act;
    btns(page);
    load(page);
}


function load(id) {
    document.getElementById("gp_qst").innerHTML = obj_elm[id];
}
function ConvertStringToHTML(str) {
    let parser = new DOMParser();
    let doc = parser.parseFromString(str, 'text/html');
    var body_doc = doc.body;
    return body_doc.childNodes[0];
};

function btns(page) {
    var str;
    if (page == 0) {

        str = `<button type="button" class="btn btn-success" onclick="get_to_div(1);">Next</button>`;
    }else if (page == obj_elm.length-1) {
        str =
            `<button type="submit" class="btn btn-secondary" onclick="get_to_div(-1);">Back</button>`
    } else {
        str =
            `<button type="submit" class="btn btn-secondary" onclick="get_to_div(-1);">Back</button>
        <button type="button" class="btn btn-success" onclick="get_to_div(1);">Next</button>;`
    }

    document.getElementById("nxt").innerHTML = str;



}