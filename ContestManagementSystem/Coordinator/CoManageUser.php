<?php
session_start();

if (isset($_SESSION['sessLoginCheck']) && $_SESSION['sessUserDetails']['emailId'] == "coordinator@gmail.com") {
	include './CoHeader.php';
	include_once '../SQLConnection.php';
	$sql = "SELECT userId, firstName, middleName, lastName, mobileNo, emailId, permanentAdd, city, registrationDt, status FROM Registration ORDER BY registrationDt DESC;";
	$result = $con->query($sql);

	if ($result->num_rows > 0) {
		echo "<h1 align='center'>List of Registered Users</h1>
			<table cellpadding=10 cellspacing=0 border=1 align='center'><tr>
			<th>Name</th>
			<th>Mobile No.</th>
			<th>Email Id</th>
			<th>Address</th>
			<th>City</th>
			<th>Registration Date</th>
			<th>Action</th></tr>";
		// output data of each row
		while($row = $result->fetch_assoc()) {
			if($row['emailId'] != "coordinator@gmail.com"){
				$id = $row['userId'];
				if($row["status"] == "a"){
					$status = "Active";
					$button1 = "disabled";
					$button2 = "";
				}
				else{
					$status = "Deactive";
					$button1 = "";
					$button2 = "disabled";
				}
				echo "<tr><td>" . $row['firstName'] . " " . $row['middleName'] . " "  . $row['lastName'] . "</td>
					<td>" . $row['mobileNo'] . "</td>
					<td>" . $row['emailId'] . "</td>
					<td>" . $row['permanentAdd'] . "</td>
					<td>" . $row['city'] . "</td>
					<td>" . $row['registrationDt'] . "</td>
					<td><form action='' method='POST'>
						<button type='submit' name='statusA' value='" . $id . "' " . $button1 . ">Active</button>&ensp;
						<button type='submit' name='statusD' value='" . $id . "' " . $button2 . ">Deactive</button>
					</form></td></tr>";
			}
		}
		echo "</table>";
	}
	else
		echo "Registered user is 0!";

	if(isset($_POST['statusA']) && intval($_POST['statusA'])){
		$uId = (int)$_POST['statusA'];
		$sql = "SELECT status FROM Registration WHERE userId = '" . $uId . "';";
		$result = $con->query($sql);
		if ($row = $result->fetch_assoc()) {
			if($row['status'] == 'a'){
				$sql = "UPDATE Registration SET status = 'd' WHERE userId = '" . $uId . "';";
				$con->query($sql);
			}
			else if($row['status'] == 'd'){
				$sql = "UPDATE Registration SET status = 'a' WHERE userId = '" . $uId . "';";
				$con->query($sql);
			}
			echo "<script>window.location.replace('./CoManageUser.php');</script>";
			// header('location: ./CoManageUser.php');
		}
	}
	if(isset($_POST['statusD']) && intval($_POST['statusD'])){
		$uId = (int)$_POST['statusD'];
		$sql = "SELECT status FROM Registration WHERE userId = '" . $uId . "';";
		$result = $con->query($sql);
		if ($result->num_rows == 1) {
			$row = $result->fetch_assoc();
			if($row['status'] == 'a'){
				$sql = "UPDATE Registration SET status = 'd' WHERE userId = '" . $uId . "';";
				$con->query($sql);
			}
			else if($row['status'] == 'd'){
				$sql = "UPDATE Registration SET status = 'a' WHERE userId = '" . $uId . "';";
				$con->query($sql);
			}
			echo "<script>window.location.replace('./CoManageUser.php');</script>";
			// header('location: ./CoManageUser.php');
		}
	}
	$con->close();
	include '../Footer.php';
}
else
	echo "Go to Login page & sign in as Coordinator.";
?>