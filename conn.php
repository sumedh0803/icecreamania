<?php

	$servername = "remotemysql.com:3306";
	$username = "tK0HEv3ZWF";
	$password = "t4qEtDKTnP";
	$database = "tK0HEv3ZWF";

	$conn = mysqli_connect($servername, $username, $password);

	if(!$conn) 
      die("Connection failed: " . mysqli_connect_error());
	mysqli_select_db($conn,$database);
?>
