<?php
require_once("dbcontroller.php");
$db = new dbcontroller();
$db -> connectDb();

$userid = $_REQUEST['userid'];
// $sql = "SELECT t.t_uid, t.tid, t.time as 'Timestamp', i.itemname as 'Item', i.category as 'Category',
//         o.quantity as 'Qty', a.ename as 'Extras', t.price as 'Total' FROM inventory as i, transaction as t,
//         orders as o LEFT JOIN (SELECT oc.oc_oid, e.eid, e.ename FROM order_customization as oc INNER JOIN
//          extras as e ON e.eid = oc.oc_eid) as a ON o.oid = a.oc_oid WHERE o_itemid = i.itemid and t.t_uid = $userid";

$sql = "SELECT tid, t_uid, time, price FROM transaction WHERE t_uid = $userid";
$result = $db->runQuery($sql);
$transactions = array();
while ($row = $result->fetch_assoc())
{
    $data = array();
    $data['tid'] = $row['tid'];
    $data['t_uid'] = $row['t_uid'];
    $data['time'] = $row['time'];
    $data['price'] = $row['price'];

    $tid = $row['tid'];
    $sql1 = "SELECT i.itemname, i.category, o.oid, o.price, o.quantity, o.o_itemid FROM orders as o, inventory as i WHERE o.o_itemid = i.itemid 
             AND tid = $tid";
    $result1 = $db->runQuery($sql1);
    $order_temp = array();
    while ($row1 = $result1->fetch_assoc())
    {
        $orders = array();
        $orders['oid'] = $row1['oid'];
        $orders['itemname'] = $row1['itemname'];
        $orders['category'] = $row1['category'];
        $orders['quantity'] = $row1['quantity'];
        $orders['price'] = $row1['price'];
        $orders['o_itemid'] = $row1['o_itemid'];
       
        $oid = $orders['oid'];
        $sql2 = "SELECT e.eid as eid, oc.oc_oid as ocoid, e.ename as ename FROM order_customization as oc, extras as e WHERE oc.oc_eid = e.eid AND oc.oc_oid = $oid";
        $result2 = $db->runQuery($sql2);

        $ename = "";
        while ($row2 = $result2->fetch_assoc())
        {
            $ename .= $row2['ename'].",";
        }
        $ename = substr($ename, 0, strlen($ename) - 1);

        $orders['extras'] = $ename;

        array_push($order_temp, $orders);
    }
    $data['orders'] = $order_temp;

    array_push($transactions, $data);
}
 echo json_encode($transactions); 

?>