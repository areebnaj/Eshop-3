<?php

session_start();
require "connection.php";

require "SMTP.php";
require "PHPMailer.php";
require "Exception.php";

use PHPMailer\PHPMailer\PHPMailer;

if (!empty($_POST["email"]) && !empty($_POST["name"])) {

    if ($_SESSION["au"]["email"] == $_POST["email"]) {
        $cname = $_POST["name"];
        $umail = $_POST["email"];

        $category_rs = database::search("SELECT * FROM `category` WHERE `name` LIKE '%" . $cname . "%'");
        $category_num = $category_rs->num_rows;

        if ($category_num == 0) {

            $code = uniqid();
            database::iud("UPDATE `admin` SET `verification_code`='" . $code . "' WHERE `email`='" . $umail . "'");

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
            $mail->addAddress($umail);
            $mail->isHTML(true);
            $mail->Subject = 'eShop Admin Verification Code for Add new category';
            $bodyContent = '<h1 style="color:blue"> Your Verification Code Is ' . $code . '</h1>';
            $mail->Body    = $bodyContent;

            if (!$mail->send()) {
                echo 'Verification Code sending failed!!';
            } else {
                echo 'success';
            }
            //email code

        } else {
            echo ("This category already exists!");
        }
    } else {
        echo ("Invalid User");
    }
} else{
    echo ("Something Missing!");
}
?>