<?php
include("../conn.php");

$cname = $_REQUEST['cname'];
$amtoff = $_REQUEST['amtoff'];
$dateadded = $_REQUEST['dateadded'];
$duedate = $_REQUEST['duedate'];
$lmt = $_REQUEST['lmt'];

$sql = "INSERT INTO coupons(cname,amtoff,dateadded,duedate,lmt) VALUES('$cname', $amtoff, '$dateadded', '$duedate', $lmt)";
$result = mysqli_query($conn, $sql);

if(!$result)
    echo mysqli_error($conn);
else
    echo "1";

?>