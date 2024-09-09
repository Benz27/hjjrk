<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/config.php';

include("../send_ver.php");
$user_email = $_POST['email'];



if (create_session_verf()) {
    $verf_code = $_SESSION['ver_code'];
    $user_fullname=set_name($user_email);
    $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

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

        // Recipients
        $mail->setFrom(CONTACTFORM_FROM_ADDRESS, CONTACTFORM_FROM_NAME);
        $mail->addAddress($user_email, $user_fullname);
        // $mail->addReplyTo(CONTACTFORM_FROM_ADDRESS, CONTACTFORM_FROM_NAME);

        // Content
        $mail->Subject = "Verification Code";
        $mail->Body    = <<<EOT
    Your verification code is $verf_code.
    
    Please note that this code will expire 10 minutes from the time it was sent.
    
    
    ----- This message was sent to $user_email.

EOT;

        $mail->send();
        echo 1;
    } catch (Exception $e) {
        echo ("An error occurred while trying to send your message: " . $mail->ErrorInfo);
    }
}
