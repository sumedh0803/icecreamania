<?php
include("../conn.php");

$itemname = addslashes($_REQUEST['itemname']);
$invqty = $_REQUEST['invqty'];
$category = $_REQUEST['category'];
$rate = $_REQUEST['rate'];
$description = addslashes($_REQUEST['description']);
$file = $_FILES['file'];
$itemid = $_REQUEST['itemid'];
$special = $_REQUEST['special'];

$target_dir = "../productImages/";
$target_file = $target_dir . $itemid . strstr(basename($_FILES["file"]["name"]),".");
//echo "Filename: ". $itemid . strstr(basename($_FILES["file"]["name"]),"."); 

//echo $itemname, $invqty, $category, $rate, $description,$_FILES["file"]["name"];

$uploadOk = 1;
//$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
//Check if image file is a actual image or fake image
$check = getimagesize($_FILES["file"]["tmp_name"]);
if($check !== false) {
    move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
    $sql = "INSERT INTO inventory(itemname,category,description,invqty,rate,imagepath,itemid,special) VALUES('$itemname', '$category', '$description', $invqty, $rate,'$target_file','$itemid',$special)";
    $result = mysqli_query($conn, $sql);

    if(!$result)
        echo "PHP: ".mysqli_error($conn);
    else
        echo "1";
}
else
{
    echo "0";
    $uploadOk = 0;
}


?>