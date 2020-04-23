<?php 
session_start();
require_once "dbcontroller.php";
$dbcontroller = new DBController();
$dbcontroller -> connectDb();
$email = $_REQUEST['email'];
$pwd = $_REQUEST['pwd'];

$result = $dbcontroller -> runQuery("SELECT * FROM admin WHERE email = '$email' and pwd = '$pwd'");
$rowcount = mysqli_num_rows($result);
if($rowcount > 0)
{
    $row = mysqli_fetch_assoc($result);
    $_SESSION['usertype'] = "admin";
    $_SESSION['userid'] = $row['aid']; //Spelling changed. Removed the camelcase
    $_SESSION["username"] = $row['fname'];
    $data = array();
    array_push($data,"admin",$row['aid'],$row['fname']);
    echo implode(",",$data);
}
else
{
    $pwdHash = md5($pwd);
    $result = $dbcontroller -> runQuery("SELECT * FROM user WHERE email = '$email' and password = '$pwdHash'");
    $rowcount = mysqli_num_rows($result);
    if($rowcount > 0)
    {
        //user exists
        $row = mysqli_fetch_assoc($result);
        $_SESSION['usertype'] = "user";
        $_SESSION["userid"] = $row['uid']; //Spelling changed. Removed the camelcase
        $_SESSION["username"] = $row['fname'];
        
        
        $getCartDetails = $dbcontroller -> runQuery("Select inventory.itemid as itemId,invqty,qty,itemname,rate,imagepath from cart,inventory where inventory.itemid = cart.itemid and uid = '".$row['uid']."'");
        $cartList = array();
        while($row =  mysqli_fetch_assoc($getCartDetails)){
            $cartItemExtras = array();
            $iid = $row['itemId'];
            $getExtras = $dbcontroller -> runQuery("Select cc_eid,cc_itemid,ename,eid,rate from cart_customization,extras where cc_itemid = '$iid' and cc_eid = eid");
            while($extras = mysqli_fetch_assoc($getExtras)){
                $extraDetails = array();
                $extraDetails['eid'] = $extras['eid'];
                $extraDetails['ename'] = $extras['ename'];
                $extraDetails['rate'] = $extras['rate'];
                $extraDetails['qty'] = 1;
                $cartItemExtras[] = $extraDetails;
            }
            $cartItem = array($row["itemId"] => array('itemname' => $row["itemname"], 'rate' => $row["rate"], 'imagepath' => $row["imagepath"], 'quantity' => $row["qty"], 'invqty' => $row["invqty"],'cartItemExtras' => $cartItemExtras));
            $cartList += $cartItem;
        }
        if(!empty($cartList) && count($cartList) > 0){
            $_SESSION["cartItemsList"] = $cartList;
        }

        $data = array();
        array_push($data,"user",$row['uid'],$row['fname']);
        echo implode(",",$data);
    }
    else
    {
        $data = array();
        array_push($data,"error"," "," ");
        echo implode(",",$data);
    }

}

?>