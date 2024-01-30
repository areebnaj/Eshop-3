<?php

require "connection.php";

$email = $_POST["e"];
$np = $_POST["n"];
$rnp = $_POST["r"];
$vcode = $_POST["v"];

if(empty($email)){
    echo("Missing Email !!");

}else if(empty($np)){
    echo("Please insert a new password");
}else if(strlen($np) < 5 || strlen($np) > 20){
    echo("Invalid Password !!");

}else if(empty($rnp)){
    echo("Please Re-type ypur New Password");
}else if($np != $rnp){
    echo("Password does not match");

}else if(empty($vcode)){
    echo("Please enter your Verification Code");
}else{

    $rs = database::search("SELECT * FROM `user` WHERE `email`='".$email."' AND `verification_code`='".$vcode."' ");
    $n = $rs->num_rows;

    if($n == 1){

        database::iud("UPDATE `user` SET `password`='".$np."' WHERE `email`='".$email."' ");
        echo("success");

    }else{
        echo("Invalid Email or Verification Code");
    }


}

?>