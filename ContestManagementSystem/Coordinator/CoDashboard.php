<?php
session_start();

if (isset($_SESSION['sessLoginCheck']) && $_SESSION['sessUserDetails']['emailId'] == "coordinator@gmail.com") {
	include './CoHeader.php';

	include_once '../CommonFunctions.php';
	echo "<br><br>";
	displayOnlineUsers();
	echo "<br><br><br><br>";

	//graphical representation








	header("Refresh:20; url=CoDashboard.php");
	include '../Footer.php';
} else
	echo "Go to Login page & sign in as Coordinator.";
