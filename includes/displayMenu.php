<?php 
    require_once("dbcontroller.php");
    $db = new dbcontroller();
    $db -> connectDb();

    $usertype = $_REQUEST['usertype'];
    if(isset($_REQUEST['getCount']))
    {
        if($usertype == "user")
        {
            $sql1 = "SELECT * FROM inventory WHERE deleteitem = 0";
            $result1 = $db->runQuery($sql1);
            $rowcount = mysqli_num_rows($result1);
            echo $rowcount;
        }
        else
        {
            $sql1 = "SELECT * FROM inventory";
            $result1 = $db->runQuery($sql1);
            $rowcount = mysqli_num_rows($result1);
            echo $rowcount;
        }
    }
    else
    {
        $start = $_REQUEST['start'];
        $end = $_REQUEST['end'];
        $searchQuery = $_REQUEST['searchQuery'];
        $category = $_REQUEST['category'];
        $special = $_REQUEST['special'];

        if($special == "1")
        {
            if($usertype == "user")
            {
                $sql = "SELECT * FROM inventory WHERE special = 1 AND deleteitem = 0";
            }
            else
            {
                $sql = "SELECT * FROM inventory WHERE special = 1";
            }
        }
        else if($category != "" && ($start != "" && $end != ""))
        {
            if($usertype == "user")
            {
                $sql = "SELECT * FROM inventory WHERE deleteitem = 0 AND category in(";
                $categories = explode(",",$category);
                for($i = 0;$i < sizeof($categories);$i++)
                {
                    if($i == sizeof($categories) - 1)
                        $sql .= "'".$categories[$i]."'";
                    else
                        $sql .= "'".$categories[$i]."',";   
                }
                $sql .= ") LIMIT 12 offset $start";
            }
            else
            {       
                $sql = "SELECT * FROM inventory WHERE category in(";
                $categories = explode(",",$category);
                for($i = 0;$i < sizeof($categories);$i++)
                {
                    if($i == sizeof($categories) - 1)
                        $sql .= "'".$categories[$i]."'";
                    else
                        $sql .= "'".$categories[$i]."',";   
                }
                $sql .= ") LIMIT 12 offset $start";

                }    
        }
        else if($category != "" && $searchQuery != "")
        {
            if($usertype == "user")
            {
                $sql = "SELECT * FROM inventory WHERE deleteitem = 0 AND lower(itemname) LIKE lower('%$searchQuery%') AND category in (";
                $categories = explode(",",$category);
                for($i = 0;$i < sizeof($categories);$i++)
                {
                    if($i == sizeof($categories) - 1)
                        $sql .= "'".$categories[$i]."'";
                    else
                        $sql .= "'".$categories[$i]."',";   
                }
                $sql .= ")";
            }
            else
            {
                $sql = "SELECT * FROM inventory WHERE lower(itemname) LIKE lower('%$searchQuery%') and category in (";
                $categories = explode(",",$category);
                for($i = 0;$i < sizeof($categories);$i++)
                {
                    if($i == sizeof($categories) - 1)
                        $sql .= "'".$categories[$i]."'";
                    else
                        $sql .= "'".$categories[$i]."',";   
                }
                $sql .= ")";
            }

        }
        else if($category != "")
        {   
            if($usertype == "user")
            {
                $sql = "SELECT * FROM inventory WHERE deleteitem = 0 AND category in(";
                $categories = explode(",",$category);
                for($i = 0;$i < sizeof($categories);$i++)
                {
                    if($i == sizeof($categories) - 1)
                        $sql .= "'".$categories[$i]."'";
                    else
                        $sql .= "'".$categories[$i]."',";   
                }
                $sql .= ")";
            }
            else
            {
                $sql = "SELECT * FROM inventory WHERE category in(";
                $categories = explode(",",$category);
                for($i = 0;$i < sizeof($categories);$i++)
                {
                    if($i == sizeof($categories) - 1)
                        $sql .= "'".$categories[$i]."'";
                    else
                        $sql .= "'".$categories[$i]."',";   
                }
                $sql .= ")";
            }
           
        }
        else if($start != "" && $end != "")
        {
            if($usertype == "user")
            {
                $sql = "SELECT * FROM inventory WHERE deleteitem = 0 LIMIT 12 offset $start";
            }
            else
            {
                $sql = "SELECT * FROM inventory LIMIT 12 offset $start";

            }
        }
        else if($searchQuery != "")
        {
            if($usertype == "user")
            {
                $sql = "SELECT * FROM inventory WHERE deleteitem = 0 AND lower(itemname) LIKE lower('%$searchQuery%')";
            }
            else
            {
                $sql = "SELECT * FROM inventory WHERE lower(itemname) LIKE lower('%$searchQuery%')";
            }
        }
        $result = $db->runQuery($sql);
        $rowcount = mysqli_num_rows($result);
        if($rowcount >= 0)
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
            echo "ERROR";
        }

    }
    $db -> close();
?>