<?php

class database{

    public static $connection;

    public static function setUpConnection (){

        if(!isset (database::$connection)){
            database::$connection = new mysqli("localhost","root","Hareeb8542","eshop","3306"); 
        }
    }

    public static function iud ($q){

        database::setUpConnection();
        database::$connection->query($q);
    }

    public static function search ($q){

        database::setUpConnection();
        $resultset = database::$connection->query($q);
        return $resultset;
    }

}

?>