<?php
require_once("dbcontroller.php");
$db = new dbcontroller();
$db -> connectDb();

$id = $_REQUEST['id'];
$sql = "SELECT * FROM inventory WHERE itemid = '$id'";
$result = $db->runQuery($sql);
$rowcount = mysqli_num_rows($result);
if($rowcount > 0)
{
    $data = array();
    $row = mysqli_fetch_assoc($result);
    array_push($data,$row);
    echo json_encode($data);  
}
else
{
    echo mysqli_error($db->$conn);
}

?>