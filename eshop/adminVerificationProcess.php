<?php

require "connection.php";

require "SMTP.php";
require "PHPMailer.php";
require "Exception.php";

use PHPMailer\PHPMailer\PHPMailer;

if (isset($_POST["em"])) {

    $email = $_POST["em"];
    $admin_rs = database::search("SELECT * FROM `admin` WHERE `email`='" . $email . "'");
    $admin_num = $admin_rs->num_rows;

    if ($admin_num > 0) {

        $code = uniqid();
        database::iud("UPDATE `admin` SET `verification_code`='" . $code . "' WHERE `email`='" . $email . "'");

        $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'rimasmumthasofficial@gmail.com';
        $mail->Password = 'gvjmihctmfkodnjl';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->setFrom('rimasmumthasofficial@gmail.com', 'Admin Verification');
        $mail->addReplyTo('rimasmumthasofficial@gmail.com', 'Admin Verification');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'eShop Admin Verification Code';
        $bodyContent = '<h1 style="color:blue"> Your Verification Code Is ' . $code . '</h1>';
        $mail->Body    = $bodyContent;

        if (!$mail->send()) {
            echo 'Verification Code sending failed!!';
        } else {
            echo 'success';
        }
    } else {
        echo ("You are not an Admin");
    }
}else {
    echo ("Email field should not be empty.");
}

?>
