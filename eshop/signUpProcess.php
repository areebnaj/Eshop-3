<?php

require "connection.php";

$f = $_POST["f"];
$l = $_POST["l"];
$e = $_POST["e"];
$p = $_POST["p"];
$m = $_POST["m"];
$g = $_POST["g"];

if(empty($f)){
    echo("Please enter your First Name !!!");
}else if(strlen($f) > 50){
    echo("First Name must have less than 50 characters");
}else if(empty($l)){
    echo("Please enter your Last Name !!!");
}else if(strlen($l) > 50){
    echo("Last Name must have less than 50 characters");
}else if(empty($e)){
    echo("Please enter your Email !!!");
}else if(strlen($e) >= 100){
    echo("Email must have less than 100 characters");
}else if(!filter_var($e,FILTER_VALIDATE_EMAIL)){
    echo("Invalid Email !!!");
}else if(empty($p)){
    echo("Please enter your Password!!!");
}else if(strlen($p) < 5 || strlen($p) > 20){
    echo("Password must be between 5-20 characters !!!");
}else if(empty($m)){
    echo("Please enter your Mobile !!!");
}else if(strlen($m) != 10){
    echo("Mobile must have 10 characters !!!");
}else if(!preg_match("/07[0,1,2,4,5,6,7,8][0-9]/",$m)){
    echo("Invalid Mobile !!!");
}else{
    
    $rs = database::search("SELECT*FROM `user` WHERE `email`= '".$e."' OR `mobile`= '".$m."' ");
    $n = $rs->num_rows;

    if($n > 0){
        echo("User with the same Email or Mobile already exists ");
    }else{
        $d = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $d->setTimezone($tz);
        $date = $d->format("Y-m-d H:i:s");

        database::iud("INSERT INTO `user`
        (`fname`,`lname`,`email`,`mobile`,`password`,`gender_id`,`joined_date`,`status`) VALUES
        ('".$f."','".$l."','".$e."','".$m."','".$p."','".$g."','".$date."','1' )");

        echo("success");

    }

}

?>