<?php

require "connection.php";

if (isset($_POST["t"]) && isset($_POST["n"]) && isset($_POST["e"])) {

    $vcode = $_POST["t"];
    $cname = $_POST["n"];
    $umail = $_POST["e"];

    $admin_rs = database::search("SELECT * FROM `admin` WHERE `email`='" . $umail . "'");
    $admin_num = $admin_rs->num_rows;

    if ($admin_num > 0) {

        $admin_data = $admin_rs->fetch_assoc();
        if ($admin_data["verification_code"] == $vcode) {

            database::iud("INSERT INTO `category`(`name`) VALUES ('" . $cname . "')");
            echo ("success");
        } else {
            echo ("Invalid Verification Code");
        }
    } else {
        echo ("Invalid User!");
    }
}

?>
