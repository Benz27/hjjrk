<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/config.php';

include("../send_ver.php");
$send = true;

try {
    $arrv_data = json_decode(get_arrv($_POST['a_id']), true);
    $user_email = $arrv_data[1];
    $dte = $arrv_data[0];
    $user_fullname = set_name($user_email);
} catch (Exception $e) {
    $send = false;
    echo 'Error';
}



if ($send) {


    $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

    $resp = $_POST['resp'];
    $dte_obj = new DateTime($dte);
    $dte=date_format($dte_obj, "M j, Y").' at '.date_format($dte_obj, "g:i A");
    if ($resp == 1) {
        $status = "You are now able to visit the school at $dte.";
    } else {
        $status = "You are not able to visit the school at $dte due to some health concerns.";
    }



    $message=hsf_arv_summary($_POST['a_id'],$user_fullname,$user_email,$status);







    try {
        //Server settings

        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = CONTACTFORM_SMTP_HOSTNAME;
        $mail->SMTPAuth = true;
        $mail->Username = CONTACTFORM_SMTP_USERNAME;
        $mail->Password = CONTACTFORM_SMTP_PASSWORD;
        $mail->SMTPSecure = CONTACTFORM_SMTP_ENCRYPTION;
        $mail->Port = CONTACTFORM_SMTP_PORT;
        $mail->IsHTML(true);
        // Recipients
        $mail->setFrom(CONTACTFORM_FROM_ADDRESS, CONTACTFORM_FROM_NAME);
        $mail->addAddress($user_email, $user_fullname);
        // $mail->addReplyTo(CONTACTFORM_FROM_ADDRESS, CONTACTFORM_FROM_NAME);

        // Content
        $mail->Subject = "Health Status and Arrival Form";
        $mail->AddEmbeddedImage('../../img/logo.png', 'logo_sch');
        $mail->Body    = $message;
        $mail->send();

        echo 1;
    } catch (Exception $e) {
        echo ("An error occurred while trying to send your message: " . $mail->ErrorInfo);
    }
}
