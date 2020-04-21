<?php 
    session_start();
    require_once "dbcontroller.php";
    #$data = Array();
    #$data['userid'] = $_REQUEST['userid'];
    #$data['itemid'] = $_REQUEST['itemid'];
    #$data['qty'] = $_REQUEST['qty'];
    #$data['extras'] = $_REQUEST['extras'];

    #var_dump($data);
    $dbcontroller = new DBController();
    $dbcontroller -> connectDb();
    $getProductDetails = $dbcontroller -> runQuery("Select * from inventory where itemid = '". $_REQUEST['itemid'] ."'");
    $productDetailsResult = mysqli_fetch_assoc($getProductDetails);
    $cartItem = array();
    $cartItem[$productDetailsResult["itemid"]] = array('itemname' => $productDetailsResult["itemname"], 'rate' => $productDetailsResult["rate"], 'imagepath' => $productDetailsResult["imagepath"], 'quantity' => $_REQUEST['qty'], 'invqty' => $productDetailsResult["invqty"]);
    if(isset($_SESSION["cartItemsList"])){
        if(in_array($productDetailsResult["itemid"],array_keys($_SESSION["cartItemsList"]))){
            foreach($_SESSION["cartItemsList"] as $key => $value){
                if($productDetailsResult["itemid"] == $key){
                    if(empty($_SESSION["cartItemsList"][$key]["quantity"])){
                        $_SESSION["cartItemsList"][$key]["quantity"] = 0;
                    }
                    $_SESSION["cartItemsList"][$key]["quantity"] += $_REQUEST['qty'];
                }
            }
        }
        else{
            $_SESSION["cartItemsList"] += $cartItem;
        }
    }
    else{
        $_SESSION["cartItemsList"] = $cartItem;
    }
    $dbcontroller -> close();
?>