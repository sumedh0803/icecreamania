<?php
include("../conn.php");

$itemname = $_REQUEST['itemname'];
$invqty = $_REQUEST['invqty'];
$category = $_REQUEST['category'];
$rate = $_REQUEST['rate'];
$description = $_REQUEST['description'];

// echo $itemname, $invqty, $category, $rate, $description;


$sql = "INSERT INTO inventory(itemname,category,description,invqty,rate) VALUES('$itemname', '$category', '$description', $invqty, $rate)";
$result = mysqli_query($conn, $sql);

if(!$result)
    echo mysqli_error($conn);
else
    echo "1";

?>