<?php 
    require_once("dbcontroller.php");
    $db = new dbcontroller();

    $db -> connectDb();

    $sql = "SELECT * FROM inventory";
    $result = $db->runQuery($sql);
    $rowcount = mysqli_num_rows($result);
    if($rowcount > 0)
    {
        $data = array();
        while($row = mysqli_fetch_assoc($result))
        {
            array_push($data,$row);
        }
        echo json_encode($data);
    }
    else
    {
        echo mysqli_error($conn);
    }


?>