<?php
session_start();
include_once '../SQLConnection.php';

$contestTitle = trim($_POST['contestTitle']);

$sql = "SELECT firstName, lastName FROM Registration, Contest, Participation 
		WHERE Registration.userId = Participation.userId AND 
		Contest.cId = participation.cId AND 
		Contest.cId = (SELECT cId FROM Contest WHERE cName = '$contestTitle');";
$result = mysqli_query($con, $sql);

$output = "";
while ($row = $result->fetch_assoc()) {
	$output .= $row['firstName'] . " " . $row['lastName'] . "<br>";
	// print_r($row);
}

echo $output;
?>