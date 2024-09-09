var selected = "";
var rows = 0;
        eneble_btn();
        $('#dataTable').dataTable();
        var table = $('#dataTable').DataTable();
        get_users();
        $('#modal').on('show.bs.modal', function (e) {
            clear();
        })
        
        $('#modal').on('hide.bs.modal', function (e) {
            set();
        })
        function get_users() {
            $('#dataTable').DataTable().clear().draw();
            rows = 0;
            selected = "";
            eneble_btn();
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    //console.log(this.responseText);{ scrollY: '250px',scrollCollapse: true}


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

            xhttp.open("GET", "./php/call_functions.php?x=get_admins", true);
            xhttp.send();
        }


        function setselected(id){
            selected=id;
            console.log(selected);
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
            console.log(row);
        });
        
        
        // $('#del').on('click', function () {
        //   table.row(row).remove().draw();
        // });
        
        
        function eneble_btn() {
        
            if (selected != "") {
                document.getElementById("updt").disabled = false;
                document.getElementById("chpass").disabled = false;
                document.getElementById("del").disabled = false;
        
            } else {
                document.getElementById("updt").disabled = true;
                document.getElementById("chpass").disabled = true;
                document.getElementById("del").disabled = true;
            }
        
        }
        
        function chnge_link(to) {
            window.location.href = to;
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
        
        
            xhttp.open("POST", "./php/edtacc.php?fun=delacc&user_type=admin", true);
            xhttp.send(formdata);
        
        
        }
        
        function set() {
            document.getElementById("ld").innerHTML =
                `<div class="modal-body" id="mdbody">
        <p>This account will be permanently deleted. Proceed anyway?</p>
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
        <button type="button" class="btn btn-danger" id="mdyes" onclick="delacc();">Yes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="mdno">No</button>
        </div>`;
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