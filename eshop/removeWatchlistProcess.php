<?php

require "connection.php";

if(isset($_GET["id"])){

    $wid = $_GET["id"];

    $watch_rs = database::search("SELECT * FROM `watchlist` WHERE `id`='".$wid."'");
    $watch_num = $watch_rs->num_rows;
    $watch_data = $watch_rs->fetch_assoc();

    if($watch_num == 0){
        echo("Semothing went wrong. Please try again later");
    }else{
        database::iud("INSERT INTO `recent`(`product_id`,`user_email`) VALUES 
        ('".$watch_data["product_id"]."','".$watch_data["user_email"]."')");

        database::iud("DELETE FROM `watchlist` WHERE `id`='".$wid."'");

        echo("success");
    }

}else{
    echo("Please select a product");
}

?>
