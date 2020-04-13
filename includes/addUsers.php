<?php 
$fname = $_REQUEST['fname'];
$lname = $_REQUEST['lname'];
$addr1 = $_REQUEST['addr1'];
$addr2 = $_REQUEST['addr2'];
$phone = $_REQUEST['phone'];
$city = $_REQUEST['city'];
$pin = $_REQUEST['pin'];
$email = $_REQUEST['email'];
$pwd = $_REQUEST['pwd'];
$gender = $_REQUEST['gender'];

require_once("dbcontroller.php");
$db = new dbcontroller();
$db -> connectDb();


$sql = "SELECT * FROM user WHERE email = '$email'";
$result = $db->runQuery($sql);
$rowcount = mysqli_num_rows($result);
if($rowcount > 0)
{
    //user already exists
    echo "1";
}
else
{
    $sql = "SELECT * FROM user WHERE phone = $phone";
    $result = $db->runQuery($sql);
    $rowcount = mysqli_num_rows($result);
    if($rowcount > 0)
    {
        //phone already exists
        echo "2";
    }
    else
    {
        $pwdHash = md5($pwd);
        $sql = "INSERT INTO user(fname,lname,phone,email,password,gender) VALUES('$fname','$lname',$phone,'$email','$pwdHash','$gender')";
        $result = $db->runQuery($sql);

        $sql = "SELECT uid from user ORDER BY uid DESC LIMIT 1";
        $result = $db->runQuery($sql);
        $row = mysqli_fetch_assoc($result);
        $uid = $row['uid'];

        $sql = "INSERT INTO user_address(uid,addr1,addr2,zip,city) VALUES($uid,'$addr1','$addr2',$pin,'$city')";
        $result = $db->runQuery($sql);
        if(!$result)
            echo mysqli_error($conn);
        else
            echo "0";

    }

    
}

?>