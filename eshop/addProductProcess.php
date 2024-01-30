<?php

session_start();
require "connection.php";

$email = $_SESSION["u"]["email"];

$category = $_POST["ct"];
$brand = $_POST["bd"];
$model = $_POST["md"];
$title = $_POST["tit"];
$condition = $_POST["con"];
$colour = $_POST["clr"];
$colour_in = $_POST["clr_in"];
$quantity = $_POST["qty"];
$cost = $_POST["cost"];
$dwc = $_POST["dwc"];
$doc = $_POST["doc"];
$description = $_POST["desc"];

if($category == "0"){
    echo("please select a category");
}else if($brand == "0"){
    echo("please select a brand");
}else if($model == "0"){
    echo("please select a model");
}else if(empty($title)){
    echo("please enter a title");
}else if(strlen($title <= 100)){
    echo("Title should have lower than 100 characters");
}else if($colour == "0"){
        echo("Please select a colour");
}else if(empty($quantity)){
    echo("Please enter a quantity");
}else if($quantity == "0" | $quantity == "e" | $quantity < 0){
    echo("Invalid input for quantity");
}else if(empty($cost)){
    echo("Please enter a price");
}else if(!is_numeric($cost)){
    echo("Invalid input for cost");
}else if(empty($dwc)){
    echo("Please Enter the delivery fee for Colombo");
}else if(!is_numeric($dwc)){
    echo("Invalid input for delivery fee inside Colombo");   
}else if(empty($doc)){
    echo("Please Enter the delivery fee for Out of Colombo");
}else if(!is_numeric($doc)){
    echo("Invalid input for delivery fee outside Colombo");   
}else if(empty($description)){
    echo("Please enter a description");
}else{
    
    $bhm_rs = database::search("SELECT * FROM `brand_has_model` where `brand_id`='".$brand."' AND `model_id`='".$model."'");

    $brand_has_model_id;

    if($bhm_rs->num_rows == 1){

        $bhm_data = $bhm_rs->fetch_assoc();
        $brand_has_model_id = $bhm_data["id"];

    }else{

        database::iud("INSERT INTO `brand_has_model`(`brand_id`,`model_id` ) VALUES ('".$brand."','".$model."')");
        $brand_has_model_id = database::$connection->insert_id;

    }

    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $d->setTimezone($tz);
    $date = $d->format("Y-m-d H:i:s");

    $status = 1;

    database::iud("INSERT INTO `product`
    (`category_id`,`brand_has_model_id`,`colour_id`,`price`,`qty`,`description`,`title`,`condition_id`,`status_id`,
    `user_email`,`datetime_added`,`delivery_fee_colombo`,`delivery_fee_other`) VALUE ('".$category."','".$brand_has_model_id."',
    '".$colour."','".$cost."','".$quantity."','".$description."','".$title."','".$condition."','".$status."','".$email."','".$date."',
    '".$dwc."','".$doc."')");

    echo("Product Saved Successfully.");

    $product_id = database::$connection->insert_id;

    $length = sizeof($_FILES);

    if($length <= 3 && $length > 0){

        $allowed_image_extentions = array("image/jpg","image/jpeg","image/png","image/svg+xml");

        for($x=0; $x < $length; $x++){

            if(isset($_FILES["image".$x])){

                $img_file = $_FILES["image".$x];
                $file_extention = $img_file["type"];

                if(in_array($file_extention,$allowed_image_extentions)){

                    $new_image_extention;

                    if($file_extention == "image/jpg"){
                        $new_image_extention = ".jpg";
                    }else if($file_extention == "image/jpeg"){
                        $new_image_extention = ".jpeg";
                    }else if($file_extention == "image/png"){
                        $new_image_extention = ".png";
                    }else if($file_extention == "image/svg+xml"){
                        $new_image_extention = ".svg";
                    }

                    $file_name = "resource//mobile_images//".$title."_".$x."_".uniqid().$new_image_extention;
                    move_uploaded_file($img_file["tmp_name"],$file_name);

                    database::iud("INSERT INTO `images`(`code`,`product_id`) VALUES ('".$file_name."','".$product_id."')");

                }else{
                    echo("Invalid Image type");
                }

            }

        }

        echo("Product image saved Successfully.");

    }else{
        echo("Invalid image count");
    }

}

?>