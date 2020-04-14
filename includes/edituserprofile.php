<?php
require_once("dbcontroller.php");
$db = new dbcontroller();
$db -> connectDb();

$userid = $_REQUEST['userid'];
$sql = "SELECT u.fname, u.lname, ua.addr1, ua.addr2, ua.zip, ua.city FROM user AS u, user_address AS ua WHERE u.uid = $userid AND u.uid = ua.uid";
$result = $db->runQuery($sql);
$data = array();
while ($row = $result->fetch_assoc())
{
    array_push($data,$row);
}
echo json_encode($data); 
?>