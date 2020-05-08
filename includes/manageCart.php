<?php
session_start();
require_once "dbcontroller.php";
$dbcontroller = new DBController();
if(isset($_REQUEST['action'])){
    switch ($_REQUEST['action']) {
        case "remove":
            if(isset($_GET["productId"]) and isset($_SESSION["cartItemsList"])){
                foreach($_SESSION["cartItemsList"] as $key => $value){
                    if($key == $_GET["productId"]){
                        unset($_SESSION["cartItemsList"][$key]);
                        if(empty($_SESSION["cartItemsList"])){
                            unset($_SESSION["cartItemsList"]);
                        }
                    }
                }
            }
            displayCart();
        break;
        case "add":
            if(isset($_GET["productId"]) and isset($_SESSION["cartItemsList"])){
                foreach($_SESSION["cartItemsList"] as $key => $value){
                    if($key == $_GET["productId"]){
                        if($_SESSION["cartItemsList"][$key]["quantity"] < $_SESSION["cartItemsList"][$key]["invqty"])
                            $_SESSION["cartItemsList"][$key]["quantity"] += 1;
                    }
                }
            }
            displayCart();
        break;
        case "subtract":
            if(isset($_GET["productId"]) and isset($_SESSION["cartItemsList"])){
                foreach($_SESSION["cartItemsList"] as $key => $value){
                    if($key == $_GET["productId"]){
                        $_SESSION["cartItemsList"][$key]["quantity"] -= 1;
                        if($_SESSION["cartItemsList"][$key]["quantity"] == 0)
                            unset($_SESSION["cartItemsList"][$key]);
                        if(empty($_SESSION["cartItemsList"])){
                            unset($_SESSION["cartItemsList"]);
                        }
                    }
                }
            }
            displayCart();
        break;
        case "checkout":
            if(isset($_SESSION['userid'])){
                $dbcontroller -> connectDb();
                $getProductDetails = $dbcontroller -> runQuery("Select * from user_address where uid = '". $_SESSION['userid'] ."'");
                if(!$getProductDetails){
                    printf("Cannot execute query due to following reason : %s \n",mysqli_error($connection));
                    exit();
                }
                else{
                    $addresses = array();
                    while($row = mysqli_fetch_assoc($getProductDetails)){
                        $results = [];
                        $results['addr1'] = $row['addr1'];
                        $results['addr2'] = $row['addr2'];
                        $results['zip'] = $row['zip'];
                        $results['city'] = $row['city'];
                        $results['uaid'] = $row['uaid'];
                        $addresses[] = $results;
                    }

                    echo json_encode($addresses);
                }
                
                $dbcontroller -> close();
            }
            else{
                echo 1;
            }
        break;
        case "placeOrder":
            if(isset($_SESSION['userid'])){
                $qty = $_SESSION["totalQuantity"];
                $total = $_SESSION["totalPrice"];
                $uid = $_SESSION['userid'];
                $uaid = $_REQUEST['uaid'];
                $dbcontroller -> connectDb();

                if(isset($_SESSION['couponApplied']) && $_SESSION['couponMessage'] && $_SESSION['couponId']){
                    $total = floatval($total - floatval($total * $_SESSION['couponMessage'] / 100.0));
                    $couponId = $_SESSION['couponId'];
                    $orderQuery = "INSERT into transaction(price,t_uid,t_uaid,t_couponId) VALUES($total,$uid,$uaid,$couponId)";
                    
                }
                else{
                    $orderQuery = "INSERT into transaction(price,t_uid,t_uaid) VALUES($total,$uid,$uaid)";
                }
                
                $dbcontroller -> runQuery($orderQuery);
                $orderId = $dbcontroller -> lastId();

                $sql = "UPDATE user set points = points + ".floor($total)." where uid = $uid";
                $dbcontroller -> runQuery($sql);


                foreach($_SESSION["cartItemsList"] as $key => $value){
                    $itemRate = $_SESSION["cartItemsList"][$key]["rate"];
                    $itemQuantity = $_SESSION["cartItemsList"][$key]["quantity"];
                    $itemid = "'".$key."'";
                    
                    $orderItemsQuery = "INSERT into orders(quantity,price,tid,o_itemid) VALUES($itemQuantity,$itemRate,$orderId,$itemid)";
                    $dbcontroller -> runQuery($orderItemsQuery);

                    $updateInventoryQuery = "UPDATE inventory SET invqty = invqty - $itemQuantity WHERE itemid = $itemid";
                    $dbcontroller -> runQuery($updateInventoryQuery);

                    if(isset($_SESSION["cartItemsList"][$key]["cartItemExtras"])){
                        $oid = $dbcontroller -> lastId();
                        foreach($_SESSION["cartItemsList"][$key]["cartItemExtras"] as $extras){
                            $eid = "'".$extras['eid']."'";
                            $dbcontroller -> runQuery("INSERT INTO order_customization(oc_oid,oc_eid,oc_itemid) VALUES($oid,$eid,$itemid)");
                        }
                    }
                }
                $dbcontroller -> close();
                unset($_SESSION["cartItemsList"]);
                unset($_SESSION['couponApplied']);
                unset($_SESSION['couponMessage']);
                unset($_SESSION['couponId']);
                echo $orderId;
            }
        break;
        case "applyCoupon":
            if(isset($_REQUEST['coupon'])){
                $_SESSION['couponApplied'] = TRUE;
                $_SESSION['couponCode'] = $_REQUEST['coupon'];
                $dbcontroller -> connectDb();
                $orderQuery = "Select duedate,dateadded,amtoff,lmt,couponid from coupons where cname = '". $_REQUEST['coupon'] ."'";
                $result = $dbcontroller -> runQuery($orderQuery);
                $num = mysqli_num_rows($result);
                if($num > 0){
                    $today = date("Y-m-d");
                    $couponDetails = [];
                    while($row = mysqli_fetch_assoc($result)){
                        $couponDetails['duedate'] = $row['duedate'];
                        $couponDetails['dateadded'] = $row['dateadded'];
                        $couponDetails['amtoff'] = $row['amtoff'];
                        $couponDetails['lmt'] = $row['lmt'];
                        $couponDetails['couponId'] = $row['couponid'];
                    }
                    if(isset($_SESSION["cartItemsList"])){
                        $totalPrice = 0;
                        foreach($_SESSION["cartItemsList"] as $key => $value){
                            $rate = $_SESSION["cartItemsList"][$key]["rate"];
                            $qty = $_SESSION["cartItemsList"][$key]["quantity"];
                            $totalPrice += ($rate * $qty);                    
                            if(isset($_SESSION["cartItemsList"][$key]["cartItemExtras"])){
                                foreach($_SESSION["cartItemsList"][$key]["cartItemExtras"] as $extras){
                                    $totalPrice += ($extras['rate'] * $qty);
                                }
                            }
                        }
                    }
                    else
                    {
                        $totalPrice = 0;
                    }
                    if($totalPrice >= $couponDetails['lmt'])
                    {
                        if($couponDetails['dateadded'] <= $today and $today <= $couponDetails['duedate']){
                            $_SESSION['couponMessage'] = $couponDetails['amtoff'];
                            $_SESSION['couponId'] = $couponDetails['couponId'];
                        }
                        else{
                            $_SESSION['couponMessage'] = "expired";
                            unset($_SESSION['couponId'] );
                        }
                    }
                    else
                    {
                        $_SESSION['couponMessage'] = "valid for total above $".$couponDetails['lmt'] ;
                        unset($_SESSION['couponId'] );
                    }

                    
                }
                else{
                    $_SESSION['couponMessage'] = "invalid";
                    unset($_SESSION['couponId'] );
                }
                $dbcontroller -> close();
                displayCart();
            }
        break;
        case "removeCoupon" : 
            $_SESSION['couponApplied'] = FALSE;
            $_SESSION['couponMessage'] = "";
            displayCart();
        break;
    }
}
else{
    displayCart();
}

function displayCart() {
    $data = array();
    if(isset($_SESSION["couponApplied"])){
        $couponApplied = TRUE;
    }
    else{
        $couponApplied = FALSE;
    }
    if(isset($_SESSION["couponCode"])){
        $couponCode = $_SESSION["couponCode"];
    }
    else{
        $couponCode = "";
    }
    if(isset($_SESSION["couponMessage"])){
        $couponMessage = $_SESSION["couponMessage"];
    }
    else{
        $couponMessage = "";
    }
    if(isset($_SESSION["cartItemsList"])){
        $totalPrice = 0;
        $totalQuantity = 0;
        foreach($_SESSION["cartItemsList"] as $key => $value){
            $rate = $_SESSION["cartItemsList"][$key]["rate"];
            $qty = $_SESSION["cartItemsList"][$key]["quantity"];
            $totalPrice += ($rate * $qty);
            $totalQuantity += $qty;
    
            $product = array();
            $product["rate"] = $rate;
            $product["quantity"] = $qty;
            $product["itemname"] = $_SESSION["cartItemsList"][$key]["itemname"];
            if(isset($_SESSION["cartItemsList"][$key]["cartItemExtras"])){
                $product["cartItemExtras"] = $_SESSION["cartItemsList"][$key]["cartItemExtras"];
                foreach($_SESSION["cartItemsList"][$key]["cartItemExtras"] as $extras){
                    $totalPrice += ($extras['rate'] * $qty);
                }
            }
            $product["imagepath"] = $_SESSION["cartItemsList"][$key]["imagepath"];
            $product["invqty"] = $_SESSION["cartItemsList"][$key]["invqty"];
            $product["productId"] = $key;
            $product["couponApplied"] = $couponApplied;
            $product["couponCode"] = $couponCode;
            $product["couponMessage"] = $couponMessage;
            $data[] = $product;
        }
        $_SESSION["totalQuantity"] = $totalQuantity;
        $_SESSION["totalPrice"] = round(($totalPrice * 1.1) + 2.5 , 2);
    }
    else{
        $_SESSION["totalQuantity"] = 0;
        $_SESSION["totalPrice"] = 0;
    }
    echo json_encode($data);
}
?>  