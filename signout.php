<?php 
session_start();
require_once "./includes/dbcontroller.php";
$dbcontroller = new DBController();
if(isset($_SESSION["userid"])){
    $uid = $_SESSION["userid"];
    $dbcontroller -> connectDb();
    $cartCust = $dbcontroller -> runQuery("DELETE FROM cart_customization WHERE uid = '$uid'");
    $result = $dbcontroller -> runQuery("DELETE FROM cart WHERE uid = '$uid'");
    if(isset($_SESSION["cartItemsList"])){
        foreach($_SESSION["cartItemsList"] as $key => $value){
            $itemId = $key;
            $qty = $_SESSION["cartItemsList"][$key]["quantity"];
            $cartQuery = $dbcontroller -> runQuery("INSERT INTO cart(uid,itemid,qty) VALUES($uid,'$itemId',$qty)");
            if(isset($_SESSION["cartItemsList"][$key]["cartItemExtras"])){
                $cid = $dbcontroller -> lastId();
                foreach($_SESSION["cartItemsList"][$key]["cartItemExtras"] as $extras){
                    $eid = "'".$extras['eid']."'";
                    $dbcontroller -> runQuery("INSERT INTO cart_customization(cc_cid,cc_eid,cc_itemid,uid) VALUES('$cid',$eid,'$key',$uid)");
                }
            }
        }
    }
}
session_unset();
session_destroy();
header('Location: index.php');
exit();
?>