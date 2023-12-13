<?php
session_start();
$userId = $_SESSION['sessUserId'];
if(session_destroy()){
	echo "<script>alert('Logout Successfully!');window.location.replace('Login.php');</script>";
	include_once './CommonFunctions.php';
	offlineUser($userId);
}
?>