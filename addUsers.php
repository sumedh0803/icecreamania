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

include('conn.php');
//echo $fname, $lname, $addr1, $addr2, $phone, $city, $pin, $email, $pwd;

$sql = "SELECT * FROM user WHERE email = '$email'";
$result=mysqli_query($conn,$sql);
$rowcount = mysqli_num_rows($result);
if($rowcount > 0)
{
    //user already exists
    echo "1";
}
else
{
    $sql = "SELECT * FROM user WHERE phone = $phone";
    $result=mysqli_query($conn,$sql);
    $rowcount = mysqli_num_rows($result);
    if($rowcount > 0)
    {
         //phone already exists
        echo "2";
    }
    else
    {
        $pwdHash = md5($pwd);
        $sql = "INSERT INTO user(fname,lname,phone,email,password,addr1,addr2,zip,city) VALUES('$fname','$lname',$phone,'$email','$pwdHash','$addr1','$addr2',$pin,'$city')";
        $result=mysqli_query($conn,$sql);
        if(!$result)
            echo mysqli_error($conn);
        else
            echo "0";

    }

    
}

?>