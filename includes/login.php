<?php 
include("../conn.php");
$email = $_REQUEST['email'];
$pwd = $_REQUEST['pwd'];

$sql = "SELECT * FROM admin WHERE email = '$email' and pwd = '$pwd'";
$result = mysqli_query($conn, $sql);
$rowcount = mysqli_num_rows($result);
if($rowcount > 0)
{
    $row = mysqli_fetch_assoc($result);
    $data = array();
    array_push($data,"admin",$row['aid'],$row['fname']);
    echo implode(",",$data);
}
else
{
    $pwdHash = md5($pwd);
    $sql = "SELECT * FROM user WHERE email = '$email' and password = '$pwdHash'";
    $result = mysqli_query($conn, $sql);
    $rowcount = mysqli_num_rows($result);
    if($rowcount > 0)
    {
        //user exists
        $row = mysqli_fetch_assoc($result);
        $data = array();
        array_push($data,"user",$row['uid'],$row['fname']);
        echo implode(",",$data);
    }
    else
    {
        $data = array();
        array_push($data,"error"," "," ");
        echo implode(",",$data);
    }

}

?>