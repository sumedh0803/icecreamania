<?php
require_once("dbcontroller.php");
$db = new dbcontroller();
$db -> connectDb();

$userid = $_REQUEST['userid'];
$sql = "SELECT t.t_uid, t.tid, t.time as 'Timestamp', i.itemname as 'Item', i.category as 'Category',
        o.quantity as 'Qty', a.ename as 'Extras', t.price as 'Total' FROM inventory as i, transaction as t,
        orders as o LEFT JOIN (SELECT oc.oc_oid, e.eid, e.ename FROM order_customization as oc INNER JOIN
         extras as e ON e.eid = oc.oc_eid) as a ON o.oid = a.oc_oid WHERE o_itemid = i.itemid and t.t_uid = $userid";
$result = $db->runQuery($sql);
$data = array();
while ($row = $result->fetch_assoc())
{
    array_push($data,$row);
}
echo json_encode($data); 
?>