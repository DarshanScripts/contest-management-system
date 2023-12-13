<?php
//connect database in XAMPP
$host = "localhost";
$con_username = "root";
$con_password = "";
$db_name = "ContestManagementSystem";

$con = new mysqli($host,$con_username,$con_password,$db_name);

//check connection
if($con->connect_errno)
	die("Connection failed: " . $con->connect_errno);
?>