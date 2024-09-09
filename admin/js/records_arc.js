$('#dataTable').dataTable();
get_hsf(0,'School Employee ID','col_id');

function get_hsf(ut,str,col_id) {
    document.getElementById(col_id).innerHTML=str;
    $('#dataTable').DataTable().clear().draw();
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
         
            if (this.responseText != "") {

                const tr = $(this.responseText);
                for (x = 0; x < tr.length; x++) {
                    $('#dataTable').DataTable().row.add(tr[x]).draw();
                }

                // document.getElementById("tbody").innerHTML=this.responseText;
            }

            $('#dataTable').DataTable().order([[0, "desc"]]).draw();

        };

    }


    xhttp.open("GET", "./php/call_functions.php?x=get_hsf&arc=true&ut=" + ut, true);
    xhttp.send();
}