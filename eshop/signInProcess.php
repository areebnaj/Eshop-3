<?php

session_start();
require "connection.php";

$e = $_POST["e"];
$p = $_POST["p"];
$rm = $_POST["rm"];

if(empty($e)){
    echo("Please type your Email !!");
}else if(strlen($e) > 100){
    echo("Email must have less than 100 characters");
}else if(!filter_var($e,FILTER_VALIDATE_EMAIL)){
    echo("Invalid Email !!");

}else if(empty($p)){
    echo("Please type your Password !!");
}else if(strlen($p) < 5 || strlen($p) > 20 ){
    echo("Password Must have between 5 - 20 characters");
}else{

    $rs = database::search("SELECT * FROM `user` WHERE `email`='".$e."' AND `password`='".$p."' ");
    $n = $rs->num_rows;

    if($n == 1){

        echo("Success");
        $d = $rs->fetch_assoc();
        $_SESSION["u"] = $d;

        if($rm == "true"){

            setcookie("email",$e,time()+ (60*60*24*365));
            setcookie("password",$p,time()+ (60*60*24*365));
        }else{
            setcookie("email","",-1);
            setcookie("password","",-1);
        }
        
    }else{
        echo("Invalid Email or Password !!");
    }

}

?>
