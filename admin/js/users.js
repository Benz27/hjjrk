
        var selected = "";
        var selected_td_userid = "";
        var prev_selected_td_userid = "";
        var user_id_val="";
        var rows = 0;
        eneble_btn();
        $('#dataTable').dataTable();
        var table = $('#dataTable').DataTable();
        get_users(0, 'School Employee ID', 'col_id');
        $('#modal').on('show.bs.modal', function (e) {
            set();
        })



        $('#modal_id').on('show.bs.modal', function (e) {
            set_id();
        })
        function get_users(ut, str, col_id) {
            document.getElementById(col_id).innerHTML = str;
            $('#dataTable').DataTable().clear().draw();
            rows = 0;
            selected = "";
            eneble_btn();
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    console.log(this.responseText);


                    if (this.responseText != "") {


                        const tr = $(this.responseText);
                        for (x = 0; x < tr.length; x++) {
                            $('#dataTable').DataTable().row.add(tr[x]).draw();
                            rows += 1;
                        }
                        selected = "";
                        eneble_btn();

                        //$('#dataTable').DataTable().row.add(tr).draw();
                        // document.getElementById("tbody").innerHTML=this.responseText;
                    }

                    $('#dataTable').DataTable().order([[0, "desc"]]).draw();



                };

            }


            xhttp.open("GET", "./php/call_functions.php?x=get_users&ut=" + ut, true);
            xhttp.send();
        }

        function print_users_today() {

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    console.log(this.responseText);


                };

            }


            xhttp.open("GET", "../php/dompdf-2.0.1/convert.php?x=print_users_today", true);
            xhttp.send();
        }

        // $('#dataTable tbody').on('click', 'tr', function () {
        //     if (rows > 0) {
        //         if ($(this).hasClass('selected')) {
        //             $(this).removeClass('selected');
        //             selected = "";
        //             console.log(rows);
        //         } else {
        //             table.$('tr.selected').removeClass('selected');
        //             $(this).addClass('selected');
        //             selected = $(this).attr('id');
        //             console.log(rows);
        //         }
        //         eneble_btn();
        //     }
        // });

        $('#dataTable').on('click', 'tbody tr', function () {

            row = this;

        });

        // $('#del').on('click', function () {
        //   table.row(row).remove().draw();
        // });
        $("#main-container").click(function (e) {
            var tag = e.target.tagName;
            var name = e.target.getAttribute("name");
            if (name == null || name == undefined) {
                name = "NOT_TD_SAVE"
            }
            if (name.localeCompare("td_save") == 0) {
                if (tag.localeCompare("TD") == 0) {
                    var id = e.target.id;
                    var user_id = e.target.id.split("td[user_id]:").pop();
                    if (selected_td_userid != "" && selected_td_userid != Number(user_id)) {
                        str = selected_td_userid;
                        const element = document.getElementById("td[user_id]:" + selected_td_userid);
                        element.innerHTML = str;
                    }
                    user_id_val=Number(user_id);
                    selected_td_userid = Number(user_id);
                    str = `<input class="form-control" maxlength="7" onkeydown="KeyEnter(` + user_id + `,event)" id="inp[` + user_id + `]" name="td_save" type="text" value="` + user_id + `"/>`;
                    const element2 = document.getElementById(id);
                    element2.innerHTML = str;
                    document.getElementById(`inp[` + user_id + `]`).focus();
                }
            } else {
                if (selected_td_userid != "") {
                    str = selected_td_userid;
                    const element = document.getElementById("td[user_id]:" + selected_td_userid);
                    element.innerHTML = str;
                    selected_td_userid = "";
                }
            }

        });

        function KeyEnter(id,event) {
            if (event.key === "Enter") {
                    var newid=document.getElementById("inp["+id+"]").value;
                    uid_updt(id,newid);
                
            };

            if(event.key === "Escape"){
                str = id;
                const element = document.getElementById("td[user_id]:" + id);
                element.innerHTML = str;
                selected_td_userid = "";
            }
        }

        function eneble_btn() {

            if (selected != "") {
                document.getElementById("updt").disabled = false;
                document.getElementById("chpass").disabled = false;
                document.getElementById("del").disabled = false;
                document.getElementById("uid").disabled = false;
            } else {
                document.getElementById("updt").disabled = true;
                document.getElementById("chpass").disabled = true;
                document.getElementById("del").disabled = true;
                document.getElementById("uid").disabled = true;
            }

        }

        function chnge_link(to) {
            window.location.href = to;
        }

        function setselected(id) {
            selected = id;
        }
        function delacc() {
            del_display(0);
            var id = selected;
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {

                if (this.readyState == 4 && this.status == 200) {
                    console.log(this.responseText);
                    if (Number(this.responseText) == 1) {
                        rows -= 1;
                        table.row(row).remove().draw();
                        selected = "";
                        eneble_btn();
                        del_display(1);
                        return;
                    }
                    del_display(2);
                };

            }
            var formdata = new FormData();
            formdata.append("id", id);


            xhttp.open("POST", "./php/edtacc.php?fun=delacc", true);
            xhttp.send(formdata);


        }

        function uid_updt(id,newid) {
            if(newid==""){
                alerts(-2);
                return;
            }
            if(String(newid).length < 7){
                alerts(-3);
                return;
            }
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {

                if (this.readyState == 4 && this.status == 200) {
                    console.log(this.responseText);
                    if (Number(this.responseText) == 1) {
                        chnge_row_cont(id, newid,true);
                        alerts(1);
                        return;
                    }
                    if (Number(this.responseText) == 0) {
                        alerts(0);
                        return;
                    }
                    chnge_row_cont(id, newid,false);
                    alerts(-1);
                };

            }
            var formdata = new FormData();
            formdata.append("id", id);
            formdata.append("newid", newid);

            xhttp.open("POST", "./php/edtacc.php?fun=uidupdt", true);
            xhttp.send(formdata);


        }


        function set() {
            document.getElementById("ld").innerHTML =
                `<div class="modal-body" id="mdbody">
    <p>This account will be moved to archive. Proceed anyway?</p>
</div>
<div class="input-group row m-2">
<div class="col-10">
<input class="form-control" id="pass" type="password" name="pass"
  placeholder="Enter your password to continue" value="" required>
<small id="emp1" style="color: red;" hidden>This field cannot be empty!</small>
</div>
<div class="col-2">
<span class="input-group-append">
  <button class="btn ms-n4" type="button" onclick="toggle_pass('tpass','pass')">
    <i id="tpass" class="bi-eye-fill"></i>
  </button>
</span>
</div>
</div>
<div class="modal-footer" id="mdfooter">
<button type="button" class="btn btn-danger" id="mdyes" onclick="chk_pass();">Yes</button>
<button type="button" class="btn btn-secondary" data-dismiss="modal" id="mdno">No</button>
</div>`;
        }

        function set_id() {
            document.getElementById("ld_id").innerHTML =
                `<div class="modal-body" id="mdbody_id">
        <p>Set a new ID for this user.</p>
    </div>
    <div class="input-group row m-2">
      <div class="col-12">
        <input class="form-control" id="txtid" type="text"
          placeholder="Enter a new ID" value="">
        <small id="emp2" style="color: red;" hidden>This field cannot be empty!</small>
      </div>

    </div>
    <div class="modal-footer" id="mdfooter">
        <button type="button" class="btn btn-success" onclick="chng_uid();" id="mdidyes">Change</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="mdidno">No</button>
    </div>`;
        }

        function id_display(id) {
            const element = document.getElementById("ld_id");
            if (id == 0) {
                element.innerHTML = `<div class="modal-body" id="mdbody_id">
        <div class="text-center">
          <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
          Changing user Id...
        </div>
      </div>
      <div class="modal-footer">
        </div>`;
                return;
            }
            if (id == 1) {
                element.innerHTML = `<div class="modal-body" id="mdbody_id">
        <p>User Id changed successfully.</p>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal" id="mdidno">Close</button>

        </div>`;
                return;
            }

            if (id == 2) {
                element.innerHTML = `<div class="modal-body" id="mdbody_id">
        <p>Something went wrong!</p>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal" id="mdidno">Close</button>

        </div>`;
                return;
            }


        }
        function chng_uid() {
            var txtid = document.getElementById("txtid");
            var emp2 = document.getElementById("emp2");
            if (txtid.value == "") {

                emp2.innerHTML = "This field cannot be empty!";
                emp2.hidden = false;
                txtid.setAttribute("style", "border-color:red;");
                return;
            }
            uid_updt();
        }

        function del_display(id) {
            const element = document.getElementById("ld");
            if (id == 0) {
                element.innerHTML = `<div class="modal-body" id="mdbody">
        <div class="text-center">
          <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
          Deleting user...
        </div>
      </div>
      <div class="modal-footer" id="mdfooter">
        </div>`;
                return;
            }
            if (id == 1) {
                element.innerHTML = `<div class="modal-body" id="mdbody">
        <p>User has been deleted.</p>
      </div>
      <div class="modal-footer" id="mdfooter">
      <button type="button" class="btn btn-secondary" data-dismiss="modal" id="mdno">Close</button>

        </div>`;
                return;
            }

            if (id == 2) {
                element.innerHTML = `<div class="modal-body" id="mdbody">
        <p>Something went wrong!</p>
      </div>
      <div class="modal-footer" id="mdfooter">
      <button type="button" class="btn btn-secondary" data-dismiss="modal" id="mdno">Close</button>

        </div>`;
                return;
            }


        }

        function clear() {
            var pass = document.getElementById("pass");
            var emp1 = document.getElementById("emp1");
            pass.setAttribute("style", "border-color:rgba(210,215,223,255);");
            emp1.hidden = true;
            pass.value = "";
        }


        function chk_pass() {
            var pass = document.getElementById("pass");
            var emp1 = document.getElementById("emp1");
            pass.setAttribute("style", "border-color:rgba(210,215,223,255);");
            emp1.hidden = true;
            if (pass.value == "") {
                emp1.innerHTML = "This field cannot be empty!";
                emp1.hidden = false;
                pass.setAttribute("style", "border-color:red;");
                return;
            }
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    var z = Number(this.responseText);
                    console.log(z);
                    if (z == 1) {
                        delacc();
                    } else {
                        emp1.innerHTML = "Wrong password!";
                        pass.setAttribute("style", "border-color:red;");
                        emp1.hidden = false;
                    }
                }
            }
            xmlhttp.open("GET", "./php/check_pass.php?pass=" + document.getElementById("pass").value, true);
            xmlhttp.send();
        }


        function chnge_row_cont(Id, newId,change) {
            var row = document.getElementById(Id);
            var col = row.cells;
            if(change){
            col[0].innerHTML = newId;
            col[0].id = "td[user_id]:"+newId;
            row.id = newId;
            selected_td_userid = "";
            return;
            }
            col[0].innerHTML = Id;
            selected_td_userid = "";
            return;
        }

        function alerts(id){
            var class_name="alert-success";
            var str="ID changed successfully";
            if(id==-1){
                class_name="alert-danger";
                str="Something went wrong!";
            }else if(id==0){
                class_name="alert-danger";
                str="ID already exist!";
            }
            else if(id==-2){
                class_name="alert-danger";
                str="ID cannot be empty!";
            }else if(id==-3){
                class_name="alert-danger";
                str="ID should be at seven digits!";
            }
            var alert=
            `<div class="text-center alert `+class_name+` alert-dismissible fade show" role="alert">
                `+str+`
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>`;


              document.getElementById("alerts").innerHTML=alert;
        }