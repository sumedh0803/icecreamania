<?php
include("../conn.php");

$eid = $_REQUEST['eid'];
$ename = addslashes($_REQUEST['ename']);
$category1 = $_REQUEST['category1'];
$rate = $_REQUEST['rate'];

$sql = "INSERT INTO extras(eid,ename,category,rate) VALUES('$eid', '$ename', '$category1', $rate)";
$result = mysqli_query($conn, $sql);

if(!$result)
    echo mysqli_error($conn);
else
    echo "1";

?>