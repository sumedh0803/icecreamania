<?php 
    require_once("dbcontroller.php");
    $db = new dbcontroller();
    $db -> connectDb();
    
    $usertype = $_REQUEST['usertype'];
    $searchQuery = strtolower($_REQUEST['searchQuery']);

    if($usertype == "admin")
    {
        $sql = "SELECT itemname FROM inventory WHERE lower(itemname) LIKE '%$searchQuery%' LIMIT 10";
    }
    else
    {
        $sql = "SELECT itemname FROM inventory WHERE deleteitem = 0 AND lower(itemname) LIKE '%$searchQuery%' LIMIT 10";
    }
    $result = $db->runQuery($sql);
    $rowcount = mysqli_num_rows($result);
    if($rowcount > 0)
    {
        $data = array();
        while($row = mysqli_fetch_assoc($result))
        {
            array_push($data,$row['itemname']);
        }
        
        echo implode(",",$data);
    }
    



?>