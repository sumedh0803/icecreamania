<?php
    require_once("dbcontroller.php");
    $db = new dbcontroller();
    $db -> connectDb();

    $userid = $_REQUEST["userid"];
    $active = $_REQUEST["active"];
    $fname = $_REQUEST["fname"];
    $lname = $_REQUEST["lname"];
    $addr11 = $_REQUEST["addr11"];
    $addr12 = $_REQUEST["addr12"];
    $zip = $_REQUEST["zip"];
    $city = $_REQUEST["city"];
    $addr21 = $_REQUEST["addr21"];
    $addr22 = $_REQUEST["addr22"];
    $zip2 = $_REQUEST["zip2"];
    $city2 = $_REQUEST["city2"];

    if($active == 0)
    {
        $sql1 = "UPDATE user SET fname = '$fname', lname = '$lname' WHERE uid = $userid";
        $sql2 = "UPDATE user_address SET addr1 = '$addr11', addr2 = '$addr12', zip = $zip, city = '$city' WHERE uid = $userid";
         $result1 = $db->runQuery($sql1);
         $result2 = $db->runQuery($sql2);
        if(!$result1 && !$result2)
            echo "PHP: ".mysqli_error($conn);
        else
            echo "1";
    }
    else{
        $sql1 = "UPDATE user SET fname = '$fname', lname = '$lname' WHERE uid = $userid";
        $sql2 = "UPDATE user_address SET addr1 = '$addr11', addr2 = '$addr12', zip = $zip, city = '$city' WHERE uid = $userid";
        $sql3 = "INSERT INTO user_address (uid, addr1, addr2, zip, city) VALUES ($userid, '$addr21', '$addr22', $zip2, '$city2')";
        $result1 = $db->runQuery($sql1);
        $result2 = $db->runQuery($sql2);
        $result3 = $db->runQuery($sql3);
        if(!$result1 && !$result2 && !$result3)
            echo "PHP: ".mysqli_error($conn);
        else
            echo "1";
     }

?>