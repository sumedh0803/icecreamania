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
    $category = $row["category"];
    
    //$dataJSON = json_encode($data);
    $sql1 = "SELECT * FROM extras WHERE category = '$category'";
    $result1 = $db->runQuery($sql1);
    $extras = array();
    while($row1 = mysqli_fetch_assoc($result1))
    {
        array_push($extras,$row1);
    }
    //$extraJSON = json_encode($extras);
    $data[] = $extras;
   // $dataJSON['extras'] = $extraJSON;
    echo json_encode($data);
    
}
else
{
    echo mysqli_error($db->$conn);
}
?>