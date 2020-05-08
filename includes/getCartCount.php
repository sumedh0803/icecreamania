<?php 
session_start();
require_once "dbcontroller.php";
$dbcontroller = new DBController();
$dbcontroller -> connectDb();
if(isset($_SESSION["cartItemsList"])){
    
    $totalQuantity = 0;
    foreach($_SESSION["cartItemsList"] as $key => $value){
        $totalQuantity += $_SESSION["cartItemsList"][$key]["quantity"];
    }
    echo $totalQuantity;
}
else{
    echo 0;
}



?>