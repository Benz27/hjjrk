<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/config.php';

session_start();
$user_email = $_POST['email'];
include("../send_otp.php");


// Everything seems OK, time to send the email.




if (create_session_otp($user_email, $otp_id)) {
    $otp_pass = $_SESSION['otp_pass'];
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
        $mail->Subject = "Password Reset Code";
        $mail->Body    = <<<EOT
Hi $user_fullname,
    
    Your reset code is $otp_pass.
    
    Please note that this code will expire 30 minutes from the time it was sent.
    
    
    ----- This message was sent to $user_email.

EOT;

        $mail->send();
        echo 1;
    } catch (Exception $e) {
        echo ("An error occurred while trying to send your message: " . $mail->ErrorInfo);
    }
}
