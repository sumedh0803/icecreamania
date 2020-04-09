<?php 
    require_once("dbcontroller.php");
    $db = new dbcontroller();
    $db -> connectDb();
    
    $searchQuery = strtolower($_REQUEST['searchQuery']);
    $sql = "SELECT itemname FROM inventory WHERE lower(itemname) LIKE '%$searchQuery%' LIMIT 10";
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