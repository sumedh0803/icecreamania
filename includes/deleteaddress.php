<?php
require_once("dbcontroller.php");
$db = new dbcontroller();
$db -> connectDb();

$id = $_REQUEST['id'];
$addr21 = $_REQUEST["addr21"];
$addr22 = $_REQUEST["addr22"];
$zip2 = $_REQUEST["zip2"];
$city2 = $_REQUEST["city2"];

$sql = "DELETE FROM user_address WHERE addr1 = '$addr21' AND addr2 = '$addr22' AND zip = $zip2 AND city = '$city2'";
$result = $db->runQuery($sql);
if(!$result)
{
    echo "PHP: ".mysqli_error($conn);
}
else
{
    echo "1";
}

?>