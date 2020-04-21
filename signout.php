<?php 
session_start();
require_once "./includes/dbcontroller.php";
$dbcontroller = new DBController();
if(isset($_SESSION["userid"])){
    $uid = $_SESSION["userid"];
    $dbcontroller -> connectDb();
    $result = $dbcontroller -> runQuery("DELETE FROM cart WHERE uid = '$uid'");
    if(isset($_SESSION["cartItemsList"])){
        foreach($_SESSION["cartItemsList"] as $key => $value){
            $itemId = $key;
            $qty = $_SESSION["cartItemsList"][$key]["quantity"];
            $cartQuery = $dbcontroller -> runQuery("INSERT INTO cart(uid,itemid,qty) VALUES($uid,'$itemId',$qty)");
        }
    }
}
session_unset();
session_destroy();
header("Location: index.php"); 
?>