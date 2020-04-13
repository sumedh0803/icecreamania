<?php

require_once("dbcontroller.php");
$db = new dbcontroller();
$db -> connectDb();

$itemname = addslashes($_REQUEST['itemname']);
$invqty = $_REQUEST['invqty'];
$category = $_REQUEST['category'];
$rate = $_REQUEST['rate'];
$description = addslashes($_REQUEST['description']);
$itemid = $_REQUEST['itemid'];
$special = $_REQUEST['special'];
$delete = $_REQUEST['delete'];
if(isset($_FILES['file']))
{
    $file = $_FILES['file'];
    $target_dir = "../productImages/";
    $target_file = $target_dir . $itemid . strstr(basename($_FILES["file"]["name"]),".");

    //Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["file"]["tmp_name"]);
    if($check !== false) {
        move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);

        $sql = "UPDATE inventory SET itemname = '$itemname', invqty = $invqty, category = '$category', 
        description = '$description', rate = $rate, imagepath = '$target_file', special = $special,
        deleteitem = $delete WHERE itemid = '$itemid'";

            
        $result = $db->runQuery($sql);
        if(!$result)
            echo "PHP: ".mysqli_error($conn);
        else
            echo "1";
    }
    else
    {
        echo "0";
    }
        }
else
{
    $sql = "UPDATE inventory SET itemname = '$itemname', invqty = $invqty, category = '$category', 
        description = '$description', rate = $rate, special = $special,
        deleteitem = $delete WHERE itemid = '$itemid'";
        $result = $db->runQuery($sql);
        if(!$result)
            echo "PHP: ".mysqli_error($conn);
        else
            echo "1";
    }

?>