<?php 
    require_once("dbcontroller.php");
    $db = new dbcontroller();
    $db -> connectDb();

    if(isset($_REQUEST['getCount']))
    {
        $sql1 = "SELECT * FROM inventory";
        $result1 = $db->runQuery($sql1);
        $rowcount = mysqli_num_rows($result1);
        echo $rowcount;
    }
    else
    {
        $start = $_REQUEST['start'];
        $end = $_REQUEST['end'];
        $searchQuery = $_REQUEST['searchQuery'];
        $category = $_REQUEST['category'];
        // echo "start ".$start."\n";
        // echo "end ".$end."\n";
        // echo "cate ".$category."\n";
        // echo "search".$searchQuery."\n";
        if($category != "" && ($start != "" && $end != ""))
        {
            $sql = "SELECT * FROM inventory where category in(";
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
        else if($category != "")
        {
            $sql = "SELECT * FROM inventory where category in(";
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
        else if($start != "" && $end != "")
        {
            $sql = "SELECT * FROM inventory LIMIT 12 offset $start";
        }
        else if($searchQuery != "")
        {
            $sql = "SELECT * FROM inventory where lower(itemname) LIKE lower('%$searchQuery%')";
        }
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
            echo mysqli_error($db->$conn);
        }

        }
    


?>