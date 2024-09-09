<?php


session_start();
include("conn.php");

$x = $_GET['fun'];
// $object[$g_id]["items"][$qst_ids[$page][$x]]["labels"];
switch ($x) {
    case "img_obj":
        img_obj();
        break;
    case "get_ht":
        get_ht();
        break;
    case "get_anc":
        get_anc();
        break;
    case "save_anc":
        save_anc();
        break;
    case "mod_anc":
        mod_anc($_GET['anc_id']);
        break;
    case "del_anc":
        del_anc($_GET['anc_id']);
        break;
}




function img_obj()
{
    $link = $GLOBALS['link'];
    $img_obj = json_decode($_POST['img_obj'], true);
    $img_ids = json_decode($_POST['img_ids'], true);
    $title = $_POST['title'];
    $content = $_POST['content'];
    for ($x = 0; $x < count($img_ids); $x++) {
        $fle_name = $img_ids[$x];
        if ($img_obj[(string)$img_ids[$x]]['img'] != "" && (bool)$img_obj[(string)$img_ids[$x]]['isbase64']) {


            $structure = '../../img/ht/';
            if (!file_exists($structure)) {
                mkdir($structure, 0777, true);
            }

            $data = $img_obj[(string)$img_ids[$x]]['img'];

            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);

            $ext = str_replace("data:image/", ".", $type);
            $destdir = $structure . $fle_name . $ext;
            $files = glob($structure);
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                }
            }

            if (file_put_contents($destdir, $data)) {
                $img_obj[(string)$img_ids[$x]]['img'] = $fle_name . $ext;
                $img_obj[(string)$img_ids[$x]]['isbase64'] = false;
            };
        }
    }
    $enc_ids = json_encode($img_ids);
    if ($img_obj == NULL) {
        $enc_obj = '{}';
    } else {
        $enc_obj = json_encode($img_obj);
    }

    $sql = "UPDATE doc_form SET name='$title', ids='$enc_ids', obj='$enc_obj',content='$content' WHERE d_id=1111111";
    if ($link->query($sql) === TRUE) {
        echo 1;
    } else {
        echo "Error updating record: " . $link->error;
    }
}
function get_ht()
{
    $link = $GLOBALS['link'];
    $arr = array();
    $sql = "SELECT * FROM doc_form where d_id=1111111";
    if ($result = mysqli_query($link, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);

            array_push($arr, $row['name'], $row['ids'], $row['obj'], $row['content'], $row['name']);


            echo json_encode($arr);
        }

        mysqli_free_result($result);
    }
}
function get_anc()
{
    $link = $GLOBALS['link'];
    $str = `<div id="announcements">`;
    $sql = "SELECT * FROM announcements ORDER BY dte DESC";
    if ($result = mysqli_query($link, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $created = new DateTime($row['dte']);
                $str.=' 
<div class="col-lg-4 mb-4" id="' . $row['anc_id'] . '">
<div class="card shadow mb-4">
<div
class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
<h6 class="m-0 font-weight-bold text-primary">' . date_format($created, "M j, Y") . ' at ' . date_format($created, "g:i A") . '</h6>
<div class="dropdown no-arrow">
    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
        aria-labelledby="dropdownMenuLink">
        <a class="dropdown-item" href="announcement.html?id=' . $row['anc_id'] . '" >View</a>
        <a class="dropdown-item" href="" data-toggle="modal" data-target="#modal_anc" onclick="edit_anc(' . $row['anc_id'] . ')">Edit</a>
        <a class="dropdown-item" href="" data-toggle="modal" data-target="#modal_del" onclick="del_set_anc(' . $row['anc_id'] . ')">Delete</a>

    </div>
</div>
</div>
<a href="announcement.html?id=' . $row['anc_id'] . '"  style="color:black;text-decoration:none;">
    <div class="card-body" id="body-' . $row['anc_id'] . '">
    ';
                if ($row['img'] != "") {
                    $str .= '
                    <div class="text-center">
                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;"
                    id="img-' . $row['anc_id'] . '" src="../img/anc/' . $row['img'] . '"  alt="...">
                       
                    </div>';
                }
                $str .= '

       

            <div class="anc-text" id="anc_content-' . $row['anc_id'] . '">
            ' . $row['content'] . '
            </div>
            <textarea id="anc_content_txt-' . $row['anc_id'] . '" cols="30" rows="10" hidden>' . $row['content'] . '</textarea>


    </div>
    </a>
</div>

</div>
</div>';

               
            }
        }

        mysqli_free_result($result);
    }

    $str .= `</div>`;
    echo $str;
}


function get_anc_bckup()
{
    $link = $GLOBALS['link'];
    $str = `<div id="announcements">`;
    $sql = "SELECT * FROM announcements ORDER BY dte DESC";
    if ($result = mysqli_query($link, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $created = new DateTime($row['dte']);
                $str .= '
        <div class="card shadow my-3" id="' . $row['anc_id'] . '">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-md-8">
                        <h6 class="m-0 form-control border-0 outline-0 font-weight-bold text-primary">' . date_format($created, "M j, Y") . ' at ' . date_format($created, "g:i A") . '</h6>
                    </div>
                    <div class="col-md-2">
                        <button class="form-control border-0"
                            data-toggle="modal" data-target="#modal_anc" onclick="edit_anc(' . $row['anc_id'] . ')">Edit <i
                                class="fas fa-fw fa-edit"></i></button>
                    </div>
                    <div class="col-md-2">
                        <button class="form-control border-0"
                            data-toggle="modal" data-target="#modal_del" onclick="del_set_anc(' . $row['anc_id'] . ')">Delete <i
                                class="fas fa-fw fa-trash"></i></button>
                    </div>
                </div>
            </div>
            <div class="card-body"  id="body-' . $row['anc_id'] . '">

                <div class="p-3 mb-3">
                    <span style="white-space: pre-line" id="anc_content-' . $row['anc_id'] . '">
                        ' . $row['content'] . '
                    </span>
                    <textarea id="anc_content_txt-' . $row['anc_id'] . '" cols="30" rows="10" hidden>' . $row['content'] . '</textarea>
                </div>
                ';
                if ($row['img'] != "") {
                    $str .= '
                    <div class="row mb-3 d-flex justify-content-center">
                        <img style="max-width:560px;max-height:560px;" id="img-' . $row['anc_id'] . '" src="../img/anc/' . $row['img'] . '" />
                    </div>';
                }
                $str .= '
            </div>
        </div>';
            }
        }

        mysqli_free_result($result);
    }

    $str .= `</div>`;
    echo $str;
}

function save_anc()
{
    $link = $GLOBALS['link'];
    $img = $_POST['img'];
    $content = $_POST['content'];
    $fle_name = $_POST['filename'];
    $bool = true;
    $anc_id = gen_id();
    $arr=array();
    if ($img != "") {

        $structure = '../../img/anc/';
        if (!file_exists($structure)) {
            mkdir($structure, 0777, true);
        }

        $data = $img;

        list($type, $data) = explode(';', $data);
        list(, $data)      = explode(',', $data);
        $data = base64_decode($data);

        $ext = str_replace("data:image/", ".", $type);
        $fle_name = $anc_id . $ext;
        $destdir = $structure . $fle_name;
        $files = glob($structure);
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }

        if (file_put_contents($destdir, $data)) {
            // $sql = "UPDATE announcements SET img='$fle_name' WHERE anc_id=1111111";
            // if ($link->query($sql) === TRUE) {

            // } else {

            //     echo "Error updating record (img): " . $link->error;
            // }
        } else {
            $bool = false;
        };
    }
    if ($bool) {
        $sql = "INSERT INTO `announcements`(`anc_id`, `img`, `content`, `dte`, `dte_upd`) VALUES 
                        ($anc_id,'$fle_name','$content',CURRENT_TIMESTAMP(),'')";
        if ($link->query($sql) === TRUE) {

            array_push($arr,$anc_id);
            echo json_encode($arr);
        } else {
            array_push($arr,"Error updating record (content): " . $link->error);
            echo json_encode($arr);
        }
    }
}

function mod_anc($anc_id)
{
    $link = $GLOBALS['link'];
    $img = $_POST['img'];
    $content = $_POST['content'];
    $fle_name = $_POST['filename'];
    $arr = array();
    $bool = true;
    if ($img != "") {

        $structure = '../../img/anc/';
        if (!file_exists($structure)) {
            mkdir($structure, 0777, true);
        }

        $data = $img;

        list($type, $data) = explode(';', $data);
        list(, $data)      = explode(',', $data);
        $data = base64_decode($data);

        $ext = str_replace("data:image/", ".", $type);
        $fle_name = $anc_id . $ext;
        $destdir = $structure . $fle_name;
        $files = glob($structure);
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }

        if (file_put_contents($destdir, $data)) {
            // $sql = "UPDATE announcements SET img='$fle_name' WHERE anc_id=1111111";
            // if ($link->query($sql) === TRUE) {

            // } else {

            //     echo "Error updating record (img): " . $link->error;
            // }
        } else {
            $bool = false;
        };
    }

    if ($bool) {
        $sql = "UPDATE announcements SET content='$content',img='$fle_name' WHERE anc_id=$anc_id";
        if ($link->query($sql) === TRUE) {
            $str='';
            if ($fle_name!= "") {
                $str .= '
                <div class="text-center">
                <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;"
                id="img-' . $anc_id . '" src="../img/anc/' . $fle_name  . '"  alt="...">
                   
                </div>';
            }
            $str .= '

   

        <div class="anc-text" id="anc_content-' . $anc_id  . '">
        ' . $content. '
        </div>
        <textarea id="anc_content_txt-' . $anc_id . '" cols="30" rows="10" hidden>' . $content . '</textarea>';

        
    //         $str='<div class="p-3 mb-3">
    //         <span style="white-space: pre-line" id="anc_content-' . $anc_id . '">
    //             ' . $content . '
    //         </span>
    //         <textarea id="anc_content_txt-' . $anc_id . '" cols="30" rows="10" hidden>' . $content . '</textarea>
    //     </div>
    //     ';
    //     if ($fle_name != "") {
    //         $str .= '
    //         <div class="row mb-3 d-flex justify-content-center">
    //             <img style="max-width:560px;max-height:560px;" id="img-' . $anc_id . '" src="../img/anc/' . $fle_name . '" />
    //         </div>';
    //     }
    //     $str .= '
    // </div>';
            array_push($arr,1,$str);
            echo json_encode($arr);
        } else {
            array_push($arr,"Error updating record (content): " . $link->error);
            echo json_encode($arr);
        }
    }
}

function gen_id()
{
    $link = $GLOBALS['link'];
    $id = mt_rand(1000000, 9999999);
    $sql = "SELECT anc_id FROM announcements where anc_id=$id";
    $result = mysqli_query($link, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        while ($id ==  $row['user_id']) {
            $id = mt_rand(1000000, 9999999);
        }
    }

    return $id;
}

function del_anc($anc_id)
{
    $link = $GLOBALS['link'];

    $sql = "DELETE FROM announcements WHERE anc_id=$anc_id";
    if ($link->query($sql) === TRUE) {
        echo 1;
    } else {
        echo 'delete error: ' . $link->error;
    }
}


function disp_anc()
{
    $link = $GLOBALS['link'];
    $str = `<div id="announcements">`;
    $sql = "SELECT * FROM announcements ORDER BY dte DESC";
    if ($result = mysqli_query($link, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $created = new DateTime($row['dte']);
                $str .= '
        <div class="card shadow my-3" id="' . $row['anc_id'] . '">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-md-12">
                        <h6 class="m-0 form-control border-0 outline-0 font-weight-bold text-primary">' . date_format($created, "M j, Y") . ' at ' . date_format($created, "g:i A") . '</h6>
                    </div>
                </div>
            </div>
            <div class="card-body"  id="body-' . $row['anc_id'] . '">

                <div class="p-3 mb-3">
                    <span style="white-space: pre-line" id="anc_content-' . $row['anc_id'] . '">
                        ' . $row['content'] . '
                    </span>
                    <textarea id="anc_content_txt-' . $row['anc_id'] . '" cols="30" rows="10" hidden>' . $row['content'] . '</textarea>
                </div>
                ';
                if ($row['img'] != "") {
                    $str .= '
                    <div class="row mb-3 d-flex justify-content-center">
                        <img style="max-width:560px;max-height:560px;" id="img-' . $row['anc_id'] . '" src="../img/anc/' . $row['img'] . '" />
                    </div>';
                }
                $str .= '
            </div>
        </div>';
            }
        }

        mysqli_free_result($result);
    }

    $str .= `</div>`;
    return $str;
}