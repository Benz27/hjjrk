<?php

include("./php/conn.php"); 


$a_id=$_GET['a_id'];

$str=hsf_arv_summary($a_id);

function hsf_arv_summary($a_id)
{
    $link=$GLOBALS['link'];

    $sql = "SELECT * FROM arrivals where a_id = $a_id";
    $result = mysqli_query($link, $sql);

    if ($result && mysqli_num_rows($result) > 0) {

        $row = mysqli_fetch_array($result);

        $dte = new DateTime($row['dte']);
        $subm = new DateTime($row['submitted']);
        $arv='<p style="margin: 0;">Department to visit: ' . $row['dept'] . '<br>
        Date of visit: ' . date_format($dte, "M j, Y") . '<br>
        Date submitted: ' . date_format($subm, "M j, Y") . '<br>
        Reason for visit: ' . $row['reason'] . '</p>';
    }


    if(isset($arv)){

    

    $sql = "SELECT * FROM ans_sheets  where ans_id = $a_id";
    $result = mysqli_query($link, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        $g_ids = json_decode($row['g_ids']);
        $qst_ids = json_decode($row['qst_ids']);
        $obj = json_decode($row['object_str'], true);
        $hst='';
        for ($x = 0; $x < count($g_ids); $x++) {

            $hst .= '<h4 style="margin: 0;"><u>' . $obj[$g_ids[$x]]["name"] . ':</u></h4>';
            for ($y = 0; $y < count($qst_ids[$x]); $y++) {
                $type = $obj[$g_ids[$x]]["items"][$qst_ids[$x][$y]]["type"];
                $labels = $obj[$g_ids[$x]]["items"][$qst_ids[$x][$y]]["labels"];
                $ans = $obj[$g_ids[$x]]["items"][$qst_ids[$x][$y]]["ans"];



                if ($type == "radio") {
                    if ((int)$ans[0] == -1) {
                        $rad_ans = '<i>No answer</i>';
                    } else {
                        $rad_ans = $labels[(int)$ans[0]];
                    }

                    $hst .= '<p style="margin: 0;"><i>' . $obj[$g_ids[$x]]["items"][$qst_ids[$x][$y]]["string"] . '</i><br>
                                                Response: ' . $rad_ans . '</p>
                                                <br>';

                    // class="thead-dark"


                }




                if ($type == "cbox") {
                    $hst .= '<p style="margin: 0;"><i>' . $obj[$g_ids[$x]]["items"][$qst_ids[$x][$y]]["string"] . ':</i><br>';
                    $cbox_ans_array = array();
                    $cbox_ans='';
                    for ($z = 0; $z < count($labels); $z++) {
                        if ($ans[$z] == 1) {

                            array_push($cbox_ans_array, $obj[$g_ids[$x]]["items"][$qst_ids[$x][$y]]["labels"][$z]);

                        }
                    }

                    for ($za = 0; $za < count($cbox_ans_array); $za++) {
                        if($za==count($cbox_ans_array)-1){
                            $cbox_ans.=$cbox_ans_array[$za];
                        }else{
                            $cbox_ans.=$cbox_ans_array[$za].', ';
                        }
                    }
                    if(count($cbox_ans_array)==0){
                        $cbox_ans='No to all';
                    }


                    $hst.='Repsonse: '.$cbox_ans.'</p>
                    <br>';
                }



                if ($type == "text") {

                    $hst .= '<p style="margin: 0;"><i>' . $obj[$g_ids[$x]]["items"][$qst_ids[$x][$y]]["string"] . ':</i></p>';


                    for ($z = 0; $z < count($labels); $z++) {


                        $hst .= '
                                                    <p style="margin: 0;">' . $obj[$g_ids[$x]]["items"][$qst_ids[$x][$y]]["labels"][$z] . '<br>
                                                    Response: ' . $obj[$g_ids[$x]]["items"][$qst_ids[$x][$y]]["ans"][$z] . '</p>
                                                    <br>';
                    }
                }
            }

            $hst .= '<br>';
        }


        $st=<<<EOT
     
        <!DOCTYPE html>
        <html>
        
        <head>
            <title></title>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta http-equiv="X-UA-Compatible" content="IE=edge" />
            <style type="text/css">
                @media screen {
                    @font-face {
                        font-family: 'Lato';
                        font-style: normal;
                        font-weight: 400;
                        src: local('Lato Regular'), local('Lato-Regular'), url(https://fonts.gstatic.com/s/lato/v11/qIIYRU-oROkIk8vfvxw6QvesZW2xOQ-xsNqO47m55DA.woff) format('woff');
                    }
        
                    @font-face {
                        font-family: 'Lato';
                        font-style: normal;
                        font-weight: 700;
                        src: local('Lato Bold'), local('Lato-Bold'), url(https://fonts.gstatic.com/s/lato/v11/qdgUG4U09HnJwhYI-uK18wLUuEpTyoUstqEm5AMlJo4.woff) format('woff');
                    }
        
                    @font-face {
                        font-family: 'Lato';
                        font-style: italic;
                        font-weight: 400;
                        src: local('Lato Italic'), local('Lato-Italic'), url(https://fonts.gstatic.com/s/lato/v11/RYyZNoeFgb0l7W3Vu1aSWOvvDin1pK8aKteLpeZ5c0A.woff) format('woff');
                    }
        
                    @font-face {
                        font-family: 'Lato';
                        font-style: italic;
                        font-weight: 700;
                        src: local('Lato Bold Italic'), local('Lato-BoldItalic'), url(https://fonts.gstatic.com/s/lato/v11/HkF_qI1x_noxlxhrhMQYELO3LdcAZYWl9Si6vvxL-qU.woff) format('woff');
                    }
                }
        
                /* CLIENT-SPECIFIC STYLES */
                body,
                table,
                td,
                a {
                    -webkit-text-size-adjust: 100%;
                    -ms-text-size-adjust: 100%;
                }
        
                table,
                td {
                    mso-table-lspace: 0pt;
                    mso-table-rspace: 0pt;
                }
        
                img {
                    -ms-interpolation-mode: bicubic;
                }
        
                /* RESET STYLES */
                img {
                    border: 0;
                    height: auto;
                    line-height: 100%;
                    outline: none;
                    text-decoration: none;
                }
        
                table {
                    border-collapse: collapse !important;
                }
        
                body {
                    height: 100% !important;
                    margin: 0 !important;
                    padding: 0 !important;
                    width: 100% !important;
                }
        
                /* iOS BLUE LINKS */
                a[x-apple-data-detectors] {
                    color: inherit !important;
                    text-decoration: none !important;
                    font-size: inherit !important;
                    font-family: inherit !important;
                    font-weight: inherit !important;
                    line-height: inherit !important;
                }
        
                /* MOBILE STYLES */
                @media screen and (max-width:600px) {
                    h1 {
                        font-size: 32px !important;
                        line-height: 32px !important;
                    }
                }
        
                /* ANDROID CENTER FIX */
                div[style*="margin: 16px 0;"] {
                    margin: 0 !important;
                }
            </style>
        </head>
        
        <body style="background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;">
            <!-- HIDDEN PREHEADER TEXT -->
            <div style="display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: 'Lato', Helvetica, Arial, sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;"> We're thrilled to have you here! Get ready to dive into your new account.
            </div>
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <!-- LOGO -->
                <tr>
                    <td bgcolor="#198754" align="center">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                            <tr>
                                <td align="center" valign="top" style="padding: 40px 10px 40px 10px;"> </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#198754" align="center" style="padding: 0px 10px 0px 10px;">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                            <tr>
                                <td bgcolor="#ffffff" align="center" valign="top" style="padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;">
                                    <h1 style="font-size: 30px; font-weight: 400; margin: 2;">Response.</h1>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#e0fbff" align="center" style="padding: 0px 10px 0px 10px;">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                            <tr>
                                <td bgcolor="#ffffff" align="left" style="padding: 20px 30px 40px 30px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                                    <p style="margin: 0;">Below is your health status and arrival form summary.</p>
                                    <hr>
                                </td>
                            </tr>
        
                            <tr>
                                <td bgcolor="#ffffff" align="left" style="padding: 0px 30px 0px 30px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                                    <p style="margin: 0;"><b><i>ARRIVAL:</b></i></p><br>
                                    $arv
                                    <hr>
                                </td>
                            </tr> <!-- COPY -->
                            <tr>
                                <td bgcolor="#ffffff" align="left" style="padding: 20px 30px 20px 30px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                                    <p style="margin: 0;"><b><i>HEALTH STATUS FORM:</b></i></p><br>
                                    $hst
                                    <hr>
                                </td>
                            </tr>
                            <tr>
                                <td bgcolor="#ffffff" align="left" style="padding: 0px 30px 0px 30px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                                    <p style="margin: 0;"><b><i>This message was sent to samson.benz231@gmail.com</b></i></p>
                                </td>
                            </tr> <!-- COPY -->
                        </table>
                    </td>
                </tr>
            </table>
        </body>
        
        </html>
        
        EOT;
    }
}
    return $st;
}

echo $str;